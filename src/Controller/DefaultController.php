<?php namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {

	/**
      * @Route("/", name="default")
      */
    public function indexAction(Request $request)
     {
//          return $this->redirectToRoute('login');
         return $this->redirectToRoute('login');
           
     }

}

?>
