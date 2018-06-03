<?php 
namespace App\Controller;

use App\Entity\Country;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController {

    /**
     * @Route("/country/index", name="indexCountries")
     */
    public function indexCountries(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $countries = $this->getDoctrine()->getRepository(Country::class)->findBy([], ['name' => 'ASC']);
            
            return $this->render('country/index.html.twig', array(
                'countries' => $countries,
            ));
        }
    }
    
    /**
     * @Route("/country/add", name="addCountry")
     */
    public function addCountry(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $country = new Country();
            
            $form = $this->createFormBuilder($country)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Country : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                    ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $country = $form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($country);
                $em->flush();
                
                return $this->redirectToRoute('indexCountries');
            }
            
            return $this->render('country/form.html.twig', array(
                'form' => $form->createView(),
                'edit' => false,
            ));
        }
    }
    
    /**
     * @Route("/country/edit/{id}", name="editCountry")
     */
    public function editCountry(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $em = $this->getDoctrine()->getManager();
            $country = $em->getRepository(Country::class)->find($id);
            
            $form = $this->createFormBuilder($country)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Country : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                    ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $country = $form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($country);
                $em->flush();
                
                return $this->redirectToRoute('indexCountries');
            }
            
            return $this->render('country/form.html.twig', array(
                'form' => $form->createView(),
                'edit' => true,
            ));
        }
    }
    
    /**
     * @Route("/country/delete/{id}", name="deleteCountry")
     */
    public function deleteCountry(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $em = $this->getDoctrine()->getManager();
            $country = $em->getRepository(Country::class)->find($id);
            
            // Check if there are users with this Country
            $qb = $em->createQueryBuilder();
            $qb->select('p')
            ->from('App\Entity\Person','p')
            ->where('p.country = ?1')
            ->setParameter(1, $id);
            $personsWithCountry = $qb->getQuery()->getResult();
            if(count($personsWithCountry)){
                $msg = "You cannot delete this Country until it has been deselected from all Users!";
                $returnRoute = "indexCountries";
                return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
            } else {
                // Check if there are competitions with this Country
                $qb = $em->createQueryBuilder();
                $qb->select('c')
                ->from('App\Entity\Competition','c')
                ->where('c.country = ?1')
                ->setParameter(1, $id);
                $competitionsWithCountry = $qb->getQuery()->getResult();
                if(count($competitionsWithCountry)){
                    $msg = "You cannot delete a Country in which you have competitions!";
                    $returnRoute = "indexCountries";
                    return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
                } else {
                    // Now we can finally delete the country
                    $em->remove($country);
                    $em->flush();
                    
                    return $this->redirectToRoute('indexCountries');
                }
            }
        }
    }
    
}

?>