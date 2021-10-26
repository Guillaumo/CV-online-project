<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Identity;
use App\Form\AdminFormType;
use App\Repository\IdentityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
     * Fonction traitant la création d'un nouveau compte d'utilisateur
     * @Route("/newuser", name="new_user")
     */
    public function newuser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher, IdentityRepository $identityRepository): Response
    {
        // Si déjà connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('welcome');
        }

        // Instanciation des classes Identity et Admin
        $identity = new Identity();
        $user = new Admin();
        // Initialisation du formulaire de création de compte issu de la classe Admin
        $form_user = $this->createForm(AdminFormType::class, $user);
        // Récupération des champs remplis
        $form_user->handleRequest($request);
        // Lors de la soumission et de la validation des données saisies du formualaire
        if ($form_user->isSubmitted() && $form_user->isValid()) {
            // Données de la classe Identity
            $lastname = $form_user->get('lastname')->getData();
            $firstname = $form_user->get('firstname')->getData();
            $email = $form_user->get('email')->getData();
            // On vérifie si l'email n'existe pas déjà dans la table Identity
            $existing_email = $identityRepository->findBy(['email' => $email]);
            if ($existing_email) {
                $this->addFlash('error', "L'email saisi existe déjà, vous devez en choisir un autre.");
                return $this->redirectToRoute('new_user');
            }
            $identity->setLastname($lastname);
            $identity->setFirstname($firstname);
            $identity->setEmail($email);
            // Mise à jour du champs Roles et hashage du mot de passe
            $user->setRoles(["ROLE_USER"]);
            $pwd = $user->getPassword();
            $user->setPassword($userPasswordHasher->hashPassword($user, $pwd));

            // Mise à jour de la  base de données
            $em->persist($user);
            $identity->setAdmin($user);
            $em->persist($identity);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }


        return $this->render('welcome/newuser.html.twig', [
            'form_user' => $form_user->createView(),
        ]);
    }
}