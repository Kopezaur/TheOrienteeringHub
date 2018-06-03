<?php 
namespace App\Controller;

use App\Entity\Club;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClubController extends Controller {

    /**
     * @Route("/club/index", name="indexClubs")
     */
    public function indexClubs(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $clubs = $this->getDoctrine()->getRepository(Club::class)->findBy([], ['name' => 'ASC']);
            
            return $this->render('club/index.html.twig', array(
                'clubs' => $clubs,
            ));
        }
    }
    
    /**
     * @Route("/club/view/{id}", name="viewClub")
     */
    public function viewClub(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Club::class)->find($id);
        
        $form = $this->createFormBuilder($club)
        ->add('logoname', FileType::class, array(
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
                    $file = $form['logoname']->getData();
                    
                    $fileName = $this->generateUniqueFileName().'.'.$file->getClientOriginalExtension();
                    
                    // moves the file to the directory where images are stored
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                        );
                    
                    // updates the 'profile' property to store the image name
                    // instead of its contents
                    $club->setLogoname($fileName);
                    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($club);
                    $em->flush();
                    
                    return $this->redirectToRoute('viewClub', array('id' => $id));
                }
        
        return $this->render('club/view.html.twig', array(
            'club' => $club,
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/club/add", name="addClub")
     */
    public function addClub(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin" && $user->getRole()->getName() != "Coach"){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $club = new Club();
            
            // create the selector list for "President"
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qb->select('p')
            ->from('App\Entity\Person', 'p')
            ->orderBy('p.lastname', 'ASC')
            ->where('p.id != 1')
            ->andWhere('p.validated != 0');
            $query = $qb->getQuery();
            $personsQuery = $query->getResult();
            $persons = [];
            foreach($personsQuery as $person){
                $persons[$person->getLastname() . ' ' . $person->getFirstname()] = $person;
            }
            
            $form = $this->createFormBuilder($club)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Club : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('foundationdate', DateTimeType::class, array(
                    'label' => 'Date of foundation : ',
                    'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                    'required' => true,
                    'data' => new \DateTime(),
                    'attr' => array('class' => 'form-control')))
                    ->add('president', ChoiceType::class, array(
                        'choices' => $persons,
                        'required' => true,
                        'label' => 'President : ',
                        'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                        'attr' => array('class' => 'form-control custom-select')))
                        ->add('save', SubmitType::class, array(
                            'label' => 'Save',
                            'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                            ->getForm();
                    
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $club = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($club);
                $em->flush();
                
                $person = $club->getPresident();
                $person->setActiveclub($club);
                $em->persist($person);
                $em->flush();
                
                if($user->getRole()->getName() != "Admin"){
                    return $this->redirectToRoute('indexSocialClubs');
                } else {
                    return $this->redirectToRoute('indexClubs');
                }
            }

            return $this->render('club/form.html.twig', array(
                'form' => $form->createView(),
                'edit' => false
            ));
        }
    }
    
    /**
     * @Route("/club/edit/{id}", name="editClub")
     */
    public function editClub(Request $request, $id)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin" && $user->getRole()->getName() != "Coach" && $user->getActiveclub()->getId() != $id){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $em = $this->getDoctrine()->getManager();
            $club = $em->getRepository(Club::class)->find($id);
            
            // create the selector list for "President"
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qb->select('p')
            ->from('App\Entity\Person', 'p')
            ->orderBy('p.lastname', 'ASC')
            ->where('p.id != 1');
            $query = $qb->getQuery();
            $personsQuery = $query->getResult();
            $persons = [];
            foreach($personsQuery as $person){
                $persons[$person->getLastname() . ' ' . $person->getFirstname()] = $person;
            }
            
            $form = $this->createFormBuilder($club)
            ->add('name', TextType::class, array(
                'label' => 'Name of the Club : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('foundationdate', DateTimeType::class, array(
                    'label' => 'Date of foundation : ',
                    'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                    ->add('president', ChoiceType::class, array(
                        'choices' => $persons,
                        'required' => true,
                        'label' => 'President : ',
                        'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                        'attr' => array('class' => 'form-control custom-select')))
                        ->add('save', SubmitType::class, array(
                            'label' => 'Save',
                            'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                            ->getForm();
                            
                            $form->handleRequest($request);
                            
                            if ($form->isSubmitted() && $form->isValid()) {
                                
                                $club = $form->getData();
                                
                                $em = $this->getDoctrine()->getManager();
                                $em->persist($club);
                                $em->flush();
                                if($user->getRole()->getName() != "Admin"){
                                    return $this->redirectToRoute('indexSocialClubs');
                                } else {
                                    return $this->redirectToRoute('indexClubs');
                                }
                            }
                            
                            return $this->render('club/form.html.twig', array(
                                'form' => $form->createView(),
                                'edit' => true
                            ));
        }
    }
    
    /**
     * @Route("/club/delete/{id}", name="deleteClub")
     */
    public function deleteClub(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Club::class)->find($id);
        
        if($user->getRole()->getName() != "Admin" || $user->getId() != $club->getPresident()->getId()){
            return $this->redirectToRoute('access-denied');
        } else {
            // Check if this club has competitions organized
            $qb = $em->createQueryBuilder();
            $qb->select('c')
            ->from('App\Entity\Competition','c')
            ->where('c.organizer = ?1')
            ->setParameter(1, $id);
            $competitionsOrganized = $qb->getQuery()->getResult();
            if(count($competitionsOrganized)){
                $msg = "You cannot delete this Club until all his organized competition have been deleted as well!";
                $returnRoute = "indexClubs";
                return $this->redirectToRoute('customError', array('msg' => $msg, 'returnRoute' => $returnRoute));
            } else {
                // Check if this club has active members
                $qb = $em->createQueryBuilder();
                $qb->select('p')
                ->from('App\Entity\Person','p')
                ->where('p.activeclub = ?1')
                ->setParameter(1, $id);
                $activeMembers = $qb->getQuery()->getResult();
                if(count($activeMembers)){
                    // If it has active members, we release them out from the active club
                    foreach($activeMembers as $person){
                        $person->setActiveclub(null);
                        $em->persist($person);
                        $em->flush();
                    }
                }
                
                // Now we can finally delete the Club
                $em->remove($club);
                $em->flush();
                
                return $this->redirectToRoute('indexClubs');
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