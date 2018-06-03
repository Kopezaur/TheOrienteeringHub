<?php 
namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostImage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

	/**
      * @Route("/home", name="home")
      */
    public function indexHomeAction(Request $request)
     {
        
         $user = $this->getUser();
         if($user->getValidated()){
             $posts = $this->getDoctrine()->getRepository(Post::class)->findBy([], ['id' => 'DESC']);
             
             $em = $this->getDoctrine()->getManager();
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
             
             return $this->render('home/home.html.twig', array(
                 'posts' => $posts,
                 'postImages' => $postImages
             ));
         } else {
             return $this->render('home/validation.html.twig', array(
                 'firstname' => $user->getFirstname(),
                 ));
         }
     }

}

?>
