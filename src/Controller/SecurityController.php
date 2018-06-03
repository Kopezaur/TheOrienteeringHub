<?php 
namespace App\Controller;

use App\Entity\Person;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $person = new Person();
        $em = $this->getDoctrine()->getManager();
        
        // create the selector list for "Role"
        $qb = $em->createQueryBuilder();
        $qb->select('r')
        ->from('App\Entity\Role', 'r')
        ->orderBy('r.name', 'ASC')
        ->where('r.id != 1');
        $query = $qb->getQuery();
        $rolesQuery = $query->getResult();
        $roles = [];
        foreach($rolesQuery as $role){
            $roles[$role->getName()] = $role;
        }
        
        // create the selector list for "Country"
        $qb = $em->createQueryBuilder();
        $qb->select('c')
        ->from('App\Entity\Country', 'c')
        ->orderBy('c.name', 'ASC');
        $query = $qb->getQuery();
        $countriesQuery = $query->getResult();
        $countries = [];
        foreach($countriesQuery as $country){
            $countries[$country->getName()] = $country;
        }
        
        // create the selector list for "Running Category"
        $qb = $em->createQueryBuilder();
        $qb->select('c')
        ->from('App\Entity\Category', 'c')
        ->orderBy('c.name', 'ASC');
        $query = $qb->getQuery();
        $categoriesQuery = $query->getResult();
        $categories = [];
        foreach($categoriesQuery as $category){
            $categories[$category->getName()] = $category;
        }
        
        // create the selector list for "Active Club"
        $qb = $em->createQueryBuilder();
        $qb->select('c')
        ->from('App\Entity\Club', 'c')
        ->orderBy('c.name', 'ASC');
        $query = $qb->getQuery();
        $clubsQuery = $query->getResult();
        $clubs = [];
        foreach($clubsQuery as $club){
            $clubs[$club->getName()] = $club;
        }
        
        $form = $this->createFormBuilder($person)
        ->add('firstname', TextType::class, array(
            'label' => 'First name * : ', 
            'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
            'attr' => array('class' => 'form-control')))
        ->add('lastname', TextType::class, array(
            'label' => 'Last name * : ', 
            'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
            'attr' => array('class' => 'form-control')))
        ->add('username', TextType::class, array(
            'label' => 'Username * : ', 
            'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
            'attr' => array('class' => 'form-control')))
        ->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'label' => false,
            'first_options'  => array(
                'label' => 'Password * : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control')),
            'second_options' => array(
                'label' => 'Re-type Password * : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control'))))
        ->add('email', EmailType::class, array(
                'label' => 'Email * : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control')))
        ->add('role', ChoiceType::class, array(
                'choices' => $roles, 'required' => true, 
                'label' => 'Role * : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control custom-select')))
        ->add('country', ChoiceType::class, array(
                'choices' => $countries, 'required' => true, 
                'label' => 'Country * : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control custom-select')))
        ->add('category', ChoiceType::class, array(
                'choices' => $categories, 'required' => false, 
                'label' => 'Running Category : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control custom-select')))
        ->add('activeclub', ChoiceType::class, array(
                'choices' => $clubs, 'required' => false, 
                'label' => 'Active club : ', 
                'label_attr' => array('class' => 'mb-3 font-weight-normal'), 
                'attr' => array('class' => 'form-control custom-select')))
        ->add('save', SubmitType::class, array(
            'label' => 'Submit',
            'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $person = $form->getData();
            $password = $passwordEncoder->encodePassword($person, $person->getPlainPassword());
            $person->setPassword($password);
            $person->setValidated(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            
            return $this->redirectToRoute('login');
        }
        
        return $this->render('security/register.html.twig', array(
            'form' => $form->createView(),
        ));
    
    }
}

?>