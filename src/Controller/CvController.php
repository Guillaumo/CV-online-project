<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Form\CvFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CvController extends AbstractController
{
    /**
     * @Route("/user/cv/{id}", name="user_cv")
     */
    public function index(Cv $cv): Response
    {
        // On récupère l'user connecté
        $user = $this->getUser();
        $identity = $user->getIdentity();
        // On définit si il y a au moins une propriété de l'objet identity qui est nulle
        $is_identity_not_complete = $identity->fieldAsNull();
        if ($is_identity_not_complete) {
            $message = "Certains champs de votre identité ne sont pas remplis.";
        } else {
            $message = "Votre identité est compléte. Vous pouvez néanmoins la modifier.";
        }
        
        return $this->render('cv/index.html.twig', [
            'cv' => $cv,
            'message' => $message,
        ]);
    }

    /**
     * @Route("/user/editcv/{id}", name="user_editcv")
     */
    public function editcv(Cv $cv, Request $request, EntityManagerInterface $em): Response
    {
        // Initialisation du formulaire de modification d'un CV de l'user connecté
        $form_editcv = $this->createForm(CvFormType::class, $cv);
        // Récupération des champs remplis
        $form_editcv->handleRequest($request);
        // Lors de la soumission et de la validation des données saisies du formualaire
        if ($form_editcv->isSubmitted() && $form_editcv->isValid()) {
            $em->persist($cv);
            $em->flush();

            return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
        }
        return $this->render('cv/editcv.html.twig', [
            'form_editcv' => $form_editcv->createView(),
            'cv' => $cv,
        ]);
    }
}