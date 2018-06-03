<?php 
namespace App\Controller;

use App\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoleController extends AbstractController {

    /**
     * @Route("/role/index", name="indexRoles")
     */
    public function indexRoles(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $roles = $this->getDoctrine()->getRepository(Role::class)->findBy([], ['name' => 'ASC']);
            
            return $this->render('role/index.html.twig', array(
                'roles' => $roles,
            ));
        }
    }
    
    /**
     * @Route("/role/add", name="addRole")
     */
    public function addRole(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $role = new Role();
            
            $form = $this->createFormBuilder($role)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Role : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                    ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $role = $form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();
                
                return $this->redirectToRoute('indexRoles');
            }
            
            return $this->render('role/form.html.twig', array(
                'form' => $form->createView(),
                'edit' => false,
            ));
        }
    }
    
    /**
     * @Route("/role/edit/{id}", name="editRole")
     */
    public function editRole(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository(Role::class)->find($id);
            
            $form = $this->createFormBuilder($role)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Role : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                    ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $role = $form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();
                
                return $this->redirectToRoute('indexRoles');
            }
            
            return $this->render('role/form.html.twig', array(
                'form' => $form->createView(),
                'edit' => true,
            ));
        }
    }
    
    /**
     * @Route("/role/delete/{id}", name="deleteRole")
     */
    public function deleteRole(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository(Role::class)->find($id);
            
            // Check if there are users with this Role
            $qb = $em->createQueryBuilder();
            $qb->select('p')
            ->from('App\Entity\Person','p')
            ->where('p.role = ?1')
            ->setParameter(1, $id);
            $personsWithRole = $qb->getQuery()->getResult();
            if(count($personsWithRole)){
                $msg = "You cannot delete this Role until it has been deselected from all Users!";
                $returnRoute = "indexRoles";
                return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
            }
            
            $em->remove($role);
            $em->flush();
            
            return $this->redirectToRoute('indexRoles');
        }
    }
    
}

?>