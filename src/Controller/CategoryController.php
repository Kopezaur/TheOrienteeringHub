<?php 
namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController {

    /**
     * @Route("/category/index", name="indexCategories")
     */
    public function indexCategories(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $categories = $this->getDoctrine()->getRepository(Category::class)->findBy([], ['name' => 'ASC']);
            
            return $this->render('category/index.html.twig', array(
                'categories' => $categories,
            ));
        }
    }
    
    /**
     * @Route("/category/add", name="addCategory")
     */
    public function addCategory(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $category = new Category();
            
            $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Category : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('agegap', TextType::class, array(
                    'label' => 'Age-gap : ',
                    'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                    ->getForm();
                    
                    $form->handleRequest($request);
                    
                    if ($form->isSubmitted() && $form->isValid()) {
                        
                        $category = $form->getData();
                        
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($category);
                        $em->flush();
                        
                        return $this->redirectToRoute('indexCategories');
                    }
                    
                    return $this->render('category/form.html.twig', array(
                        'form' => $form->createView(),
                        'edit' => false,
                    ));
        }
    }
    
    /**
     * @Route("/category/edit/{id}", name="editCategory")
     */
    public function editCategory(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository(Category::class)->find($id);
            
            $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Category : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('agegap', TextType::class, array(
                    'label' => 'Age-gap : ',
                    'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                    ->add('save', SubmitType::class, array(
                        'label' => 'Save',
                        'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                        ->getForm();
                        
                        $form->handleRequest($request);
                        
                        if ($form->isSubmitted() && $form->isValid()) {
                            
                            $category = $form->getData();
                            
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($category);
                            $em->flush();
                            
                            return $this->redirectToRoute('indexCategories');
                        }
                        
                        return $this->render('category/form.html.twig', array(
                            'form' => $form->createView(),
                            'edit' => true,
                        ));
        }
    }
    
    /**
     * @Route("/category/delete/{id}", name="deleteCategory")
     */
    public function deleteCategory(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository(Category::class)->find($id);
            
            // Check if there are Competitions with this Category
            if(count($category->getCompetition())){
                $msg = "You cannot delete this Category until it has been deselected from all Competitions!";
                $returnRoute = "indexCategories";
                return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
            }
            
            // Check if there are Courses with this Category
            if(count($category->getCourse())){
                $msg = "You cannot delete this Category until it has been deselected from all Courses!";
                $returnRoute = "indexCategories";
                return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
            }
            
            $em->remove($category);
            $em->flush();
            
            return $this->redirectToRoute('indexCategories');
        }
    }
    
}
?>