<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Cv;
use App\Entity\Heading;
use App\Form\ArticleFormType;
use App\Form\HeadingFormType;
use App\Repository\CvRepository;
use App\Repository\HeadingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HeadingController extends AbstractController
{
    /**
     * @Route("/heading", name="heading")
     */
    public function index(): Response
    {
        return $this->render('heading/index.html.twig', [
            'controller_name' => 'HeadingController',
        ]);
    }

    /**
     * @Route("/user/cv/{c_id}/editheading/{h_id}", name="user_editheading")
     */
    public function editHeading($c_id, $h_id, CvRepository $cvRepository, HeadingRepository $headingRepository, Request $request, EntityManagerInterface $em): Response
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet rubrique
        $heading = $headingRepository->find($h_id);
        // Initialisation du formulaire de modification d'une rubrique d'un CV
        $form_editheading = $this->createForm(HeadingFormType::class, $heading);
        // Récupération des champs remplis
        $form_editheading->handleRequest($request);
        // Lors de la soumission et de la validation des données saisies du formualaire
        if ($form_editheading->isSubmitted() && $form_editheading->isValid()) {
            $em->persist($heading);
            $em->flush();

            return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
        }
        
        return $this->render('heading/editheading.html.twig', [
            'form_editheading' => $form_editheading->createView(),
            'heading' => $heading,
            'cv' => $cv,
        ]);
    }

    /**
     * @Route("/user/cv/{c_id}/removeheading/{h_id}", name="user_removeheading")
     */
    public function removeHeadingFromCV($c_id, $h_id, CvRepository $cvRepository, HeadingRepository $headingRepository, EntityManagerInterface $em): Response
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet rubrique
        $heading = $headingRepository->find($h_id);
        // Vérifier si la rubrique a du contenu

        // Suppression de la rubrique du CV
        $heading->removeCv($cv);
        // $em->persist($heading);
        $em->flush();
        
        return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
    }

    /**
     * @Route("/user/cv/{c_id}/addheading/{h_id}", name="user_addheading")
     */
    public function addHeadingTocv($c_id, $h_id, CvRepository $cvRepository, HeadingRepository $headingRepository, EntityManagerInterface $em): Response
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet rubrique
        $heading = $headingRepository->find($h_id);
        // On vérifie si la rubrique est déjà rattachée à ce CV
        $cvs = $heading->getCvs()->toArray();
        if (in_array($cv, $cvs)) {
            $this->addFlash('error', "Cette rubrique est déjà rattachée à ce CV.");
            return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
        }
        // Ajout de la rubrique au CV
        // $cv->addHeading($heading);
        // $em->persist($cv);
        // $em->flush();

        return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
    }

    /**
     * @Route("/user/cv/{c_id}/heading/{h_id}/newarticle", name="user_newarticle")
     */
    public function newArticle($c_id, $h_id, CvRepository $cvRepository, HeadingRepository $headingRepository, Request $request, EntityManagerInterface $em)
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet rubrique
        $heading = $headingRepository->find($h_id);
        // On instancie un nouvel objet Aricle (contenu)
        $article= new Article();
        // Initialisation du formulaire de création d'un contenu pour la rubrique sélectionnée
        $form_newarticle = $this->createForm(ArticleFormType::class, $article);
        // Récupération des champs remplis
        $form_newarticle->handleRequest($request);
        
        if ($form_newarticle->isSubmitted() && $form_newarticle->isValid()) {
            $article->setHeading($heading);
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
        }

        return $this->render('heading/newarticle.html.twig', [
            'cv' => $cv,
            'heading' => $heading,
            'form_newarticle' => $form_newarticle->createView(),
        ]);
    }
}