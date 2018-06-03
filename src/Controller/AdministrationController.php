<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdministrationController extends AbstractController {

	/**
      * @Route("/administration", name="administration")
      */
    public function indexAdminPanel(Request $request)
     {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            return $this->render('administration/administration.html.twig');
        }
     }

}

?>
