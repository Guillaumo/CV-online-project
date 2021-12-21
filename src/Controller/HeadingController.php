<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\Heading;
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
    public function addHeadingTocv($c_id, $h_id, CvRepository $cvRepository, HeadingRepository $headingRepository, EntityManagerInterface $em)
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet rubrique
        $heading = $headingRepository->find($h_id);

        // Ajout de la rubrique au CV
        $cv->addHeading($heading);
        $em->persist($cv);
        $em->flush();

        return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
    }
}