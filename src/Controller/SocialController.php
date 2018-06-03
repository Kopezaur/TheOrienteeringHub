<?php 
namespace App\Controller;

use App\Entity\Person;
use App\Entity\Club;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocialController extends AbstractController {
    
    /**
     * @Route("/social", name="homeSocial")
     */
    public function homeSocial(Request $request)
    {
        return $this->render('social/home.html.twig');
    }
    
    /**
     * @Route("/social/persons", name="indexSocialPersons")
     */
    public function indexSocialPersons(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve the list of people
        $qb = $em->createQueryBuilder();
        $qb->select('p')
        ->from('App\Entity\Person', 'p')
        ->orderBy('p.lastname', 'ASC')
        ->where('p.id != 1')
        ->andWhere('p.validated != 0');
        $persons = $qb->getQuery()->getResult();
        
        return $this->render('social/index-persons.html.twig', array(
            'persons' => $persons
        ));
    }
    
    /**
     * @Route("/social/clubs", name="indexSocialClubs")
     */
    public function indexSocialClubs(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve the list of people
        $qb = $em->createQueryBuilder();
        $qb->select('c')
        ->from('App\Entity\Club', 'c');
        $clubs = $qb->getQuery()->getResult();
        
        return $this->render('social/index-clubs.html.twig', array(
            'clubs' => $clubs
        ));
    }
    
    
    
}
?>