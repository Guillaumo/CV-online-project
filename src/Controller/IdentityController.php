<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\Identity;
use App\Form\CvFormType;
use App\Form\IdentityFormType;
use App\Repository\CvRepository;
use App\Repository\IdentityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdentityController extends AbstractController
{

    /**
     * @Route("/user/index", name="user")
     */
    public function index(CvRepository $cvRepository, IdentityRepository $identityRepository): Response
    {
        // On récupère l'user connecté
        $user = $this->getUser();
        $identity = $user->getIdentity();
        // On récupère le cas échéant la liste (tableau) des CV associés à l'user connecté
        $existing_cv = $cvRepository->findBy(['identity' => $identity]);
        // On définit si il y a au moins une propriété de l'objet identity qui est nulle
        $is_identity_not_complete = $identity->fieldAsNull();
        if ($is_identity_not_complete) {
            $message = "Certains champs de votre identité ne sont pas remplis.";
        } else {
            $message = "Votre identité est compléte. Vous pouvez néanmoins la modifier.";
        }

        return $this->render('identity/index.html.twig', [
            'cvs' => $existing_cv,
            'message' => $message,
        ]);
    }

    /**
     * @Route("/user/identity", name="user_identity")
     */
    public function editIdentity(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // On récupère l'objet identity correspondant à l'user connecté
        $user=$this->getUser();
        $identity = $user->getIdentity();
        // Initialisation du formulaire de modification de l'identité de l'user connecté
        $form_identity = $this->createForm(IdentityFormType::class, $identity);
        // Récupération des champs remplis ou non
        $form_identity->handleRequest($request);
        // Lors de la soumission et de la validation des données saisies du formualaire
        if ($form_identity->isSubmitted() && $form_identity->isValid()) {
            // On récupère l'image uploadée
            $picture_file = $form_identity->get('picture')->getData();
            // Comme le champ 'picture' n'est pas obligatoire, on vérifie si un fichier est téléchargé
            if ($picture_file) {
                // On récupère le chemin original du fichier
                $originalFilename = pathinfo($picture_file->getClientOriginalName(), PATHINFO_FILENAME);
                //
                $safeFilename = $slugger->slug($originalFilename);
                // On renomme le fichier afin qu'il soit unique
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture_file->guessExtension();
                // On le sauvegarde dans un répertoire défini
                $picture_file->move($this->getParameter('identity_picture'), $newFilename);
            }
            // Mise à jour de l'objet identity
            $identity = $form_identity->getData();
            $identity->setPicture($newFilename);
            $em->persist($identity);
            $em->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('identity/editidentity.html.twig', [
            'form_identity' => $form_identity->createView()
        ]);
    }

    /**
     * @Route("/user/newcv", name="user_newcv")
     */
    public function editCv(): Response
    {
        $cv = new Cv();
        $form_cv = $this->createForm(CvFormType::class, $cv);

        return $this->render('identity/newcv.html.twig', [
            'form_cv' => $form_cv->createView()
        ]);
    }
}