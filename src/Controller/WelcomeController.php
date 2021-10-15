<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Identity;
use App\Form\AdminFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

    /**
     * @Route("/newuser", name="new_user")
     */
    public function newuser(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('welcome');
        }

        $identity = new Identity();
        $user = new Admin();
        $form_user = $this->createForm(AdminFormType::class, $user);

        return $this->render('welcome/newuser.html.twig', [
            'form_user' => $form_user->createView(),
        ]);
    }
}