<?php 
namespace App\Controller;

use App\Entity\Person;
use App\Entity\Document;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PersonController extends Controller {

    /**
     * @Route("/person/index", name="indexPersons")
     */
    public function indexPersons(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $persons = $this->getDoctrine()->getRepository(Person::class)->findBy([], ['username' => 'ASC']);
            
            return $this->render('person/index.html.twig', array(
                'persons' => $persons,
            ));
        }
    }
    
	/**
      * @Route("/person/view/{id}", name="viewPerson")
      */
    public function viewPerson(Request $request, $id)
    {
        $user = $this->getUser();
         $em = $this->getDoctrine()->getManager();
         $person = $em->getRepository(Person::class)->find($id);
         
         // Retrieve the list of posts for this user
         $qb = $em->createQueryBuilder();
         $qb->select('p')
         ->from('App\Entity\Post','p')
         ->orderBy('p.id', 'DESC')
         ->where('p.author = ?1')
         ->setParameter(1, $id);
         $posts = $qb->getQuery()->getResult();
         
         $postImages = [];
         // Retrieve the list of images for each post
         foreach($posts as $post){
             $qb = $em->createQueryBuilder();
             $qb->select('p')
             ->from('App\Entity\PostImage','p')
             ->where('p.post = ?1')
             ->setParameter(1, $post->getId());
             $postImages[$post->getId()] = $qb->getQuery()->getResult();
         }
         
         $form = $this->createFormBuilder($person)
         ->add('profilephoto', FileType::class, array(
             'label' => false,
             'label_attr' => array('class' => 'mb-3 font-weight-normal'),
             'required' => true,
             'data_class' => null))
             ->add('save', SubmitType::class, array(
                 'label' => 'Save',
                 'attr' => array('class' => 'btn btn-primary', 'onclick' => 'form_submit()')))
             ->getForm();
             
         $form->handleRequest($request);
             
         if ($form->isSubmitted() && $form->isValid()) {
             
             /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
             $file = $form['profilephoto']->getData();
             
             $fileName = $this->generateUniqueFileName().'.'.$file->getClientOriginalExtension();
             
             // moves the file to the directory where images are stored
             $file->move(
                 $this->getParameter('images_directory'),
                 $fileName
                 );
             
             // updates the 'profile' property to store the image name
             // instead of its contents
             $person->setProfilephoto($fileName);
             
             $em = $this->getDoctrine()->getManager();
             $em->persist($person);
             $em->flush();
             
             return $this->redirectToRoute('viewPerson', array('id' => $id));
         }
         
         return $this->render('person/view.html.twig', array(
             'person' => $person,
             'posts' => $posts,
             'postImages' => $postImages,
             'form' => $form->createView()
         ));
    }
     
     /**
      * @Route("/person/edit/{id}", name="editPerson")
      */
     public function editPerson(Request $request, $id)
     {
         
         $user = $this->getUser();
         
         if($user->getRole()->getName() != "Admin" && $user->getId() != $id){
             return $this->redirectToRoute('access-denied');
         } else {
             $em = $this->getDoctrine()->getManager();
             $person = $em->getRepository(Person::class)->find($id);
             
             // create the selector list for "Role"
             $qb = $em->createQueryBuilder();
             if($user->getRole()->getName() != "Admin"){
                 $qb->select('r')
                 ->from('App\Entity\Role', 'r')
                 ->orderBy('r.name', 'ASC')
                 ->where('r.id != 1');
             } else {
                 $qb->select('r')
                 ->from('App\Entity\Role', 'r')
                 ->orderBy('r.name', 'ASC');
             }
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
             
             // create the selector list for "Validated"
             $statuses = [];
             $statuses["VALIDATED"] = true;
             $statuses["NOT VALIDATED"] = false;
             
             $form = $this->createFormBuilder($person)
             ->add('firstname', TextType::class, array(
                 'label' => 'First name : ',
                 'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                 'required' => true,
                 'attr' => array('class' => 'form-control')))
                 ->add('lastname', TextType::class, array(
                     'label' => 'Last name : ',
                     'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                     'required' => true,
                     'attr' => array('class' => 'form-control')))
                     ->add('username', TextType::class, array(
                         'label' => 'Username : ',
                         'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                         'required' => true,
                         'attr' => array('class' => 'form-control')))
                         ->add('validated', ChoiceType::class, array(
                             'choices' => $statuses,
                             'required' => true,
                             'label' => 'Status : ',
                             'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                             'attr' => array('class' => 'form-control custom-select')))
                                 ->add('email', EmailType::class, array(
                                     'label' => 'Email : ',
                                     'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                                     'required' => true,
                                     'attr' => array('class' => 'form-control')))
                                     ->add('role', ChoiceType::class, array(
                                         'choices' => $roles, 
                                         'required' => true,
                                         'label' => 'Role : ',
                                         'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                                         'attr' => array('class' => 'form-control custom-select')))
                                         ->add('country', ChoiceType::class, array(
                                             'choices' => $countries, 
                                             'required' => true,
                                             'label' => 'Country * : ',
                                             'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                                             'attr' => array('class' => 'form-control custom-select')))
                                             ->add('category', ChoiceType::class, array(
                                                 'choices' => $categories, 
                                                 'required' => false,
                                                 'label' => 'Running Category : ',
                                                 'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                                                 'attr' => array('class' => 'form-control custom-select')))
                                                 ->add('activeclub', ChoiceType::class, array(
                                                     'choices' => $clubs, 
                                                     'required' => false,
                                                     'label' => 'Active club : ',
                                                     'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                                                     'attr' => array('class' => 'form-control custom-select')))
                                                     ->add('save', SubmitType::class, array(
                                                         'label' => 'Save',
                                                         'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                                                         ->getForm();
                                                     
             $form->handleRequest($request);
            
             if ($form->isSubmitted() && $form->isValid()) {
                 
                 $person = $form->getData();
                 
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($person);
                 $em->flush();
                 
                 if($user->getId() == $id){
                    return $this->redirectToRoute('viewPerson', array('id' => $id));
                 } else {
                    return $this->redirectToRoute('indexPersons');       
                 }
             }
             
             return $this->render('person/form.html.twig', array(
                 'form' => $form->createView(),
             ));
         }
     }
     
     /**
      * @Route("/person/delete/{id}", name="deletePerson")
      */
     public function deletePerson(Request $request, $id)
     {
         $user = $this->getUser();
         if($user->getRole()->getName() != "Admin"){
             return $this->redirectToRoute('access-denied');
         } else {
             $em = $this->getDoctrine()->getManager();
             $person = $em->getRepository(Person::class)->find($id);
             
             // Check if he is president of a club
             $qb = $em->createQueryBuilder();
             $qb->select('c')
             ->from('App\Entity\Club','c')
             ->where('c.president = ?1')
             ->setParameter(1, $id);
             $clubsWithPerson = $qb->getQuery()->getResult();
             if(count($clubsWithPerson)){
                 $msg = "You cannot delete this Person until it has been removed from his position as a president to a club!";
                 $returnRoute = "indexUsers";
                 return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
             } else {
                 // Check if he still has clubs in his history
                 if(count($person->getClub())){
                     $msg = "You cannot delete this Person until it has been removed from his position as a president to a club!";
                     $returnRoute = "indexUsers";
                     return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
                 } else {
                     // Check if he still has participations on competitions
                     if(count($person->getClub())){
                         $msg = "You cannot delete this Person until it has been removed from his position as a president to a club!";
                         $returnRoute = "indexUsers";
                         return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
                     } else {
                         // Delete his posts
                         $qb = $em->createQueryBuilder();
                         $qb->select('p')
                         ->from('App\Entity\Post','p')
                         ->where('p.person = ?1')
                         ->setParameter(1, $id);
                         $postsWithPerson = $qb->getQuery()->getResult();
                         foreach($postsWithPerson as $post){
                             $em->remove($post);
                             $em->flush();
                         }
                         
                         // Now we can finally delete the Person
                         $em->remove($person);
                         $em->flush();
                         
                         return $this->redirectToRoute('indexPersons');
                     }
                 }
             }
         }
     }
     
     /**
      * @return string
      */
     private function generateUniqueFileName()
     {
         // md5() reduces the similarity of the file names generated by
         // uniqid(), which is based on timestamps
         return md5(uniqid());
     }
     
}

?>
