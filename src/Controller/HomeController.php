<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_SOLAIRE', $roles)) {
            return $this->render('home/solaire.html.twig');
        }

        return $this->render('home/lunaire.html.twig');
    }
}