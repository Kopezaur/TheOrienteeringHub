<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController {

	/**
      * @Route("/error/access-denied", name="access-denied")
      */
    public function accessDeniedError(Request $request)
     {
         return $this->render('errors/access-denied.html.twig');
     }

     /**
      * @Route("/error/custom-error/{msg}/{returnRoute}", name="customError")
      */
     public function customError(Request $request, $msg, $returnRoute)
     {
         return $this->render('errors/custom-error.html.twig', array(
             'msg' => $msg,
             'returnRoute' => $returnRoute,
             ));
     }
}

?>
