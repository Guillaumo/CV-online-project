<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\Identity;
use App\Form\CvFormType;
use App\Form\IdentityFormType;
use App\Repository\CvRepository;
use App\Repository\IdentityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdentityController extends AbstractController
{

    /**
     * @Route("/user/index", name="user")
     */
    public function index(CvRepository $cvRepository, IdentityRepository $identityRepository): Response
    {
        // On récupére l'user connecté
        $user = $this->getUser();
        $identity = $user->getIdentity();
        $existing_cv = $cvRepository->findBy(['identity' => $identity]);

        return $this->render('identity/index.html.twig', [
            'cvs' => $existing_cv
        ]);
    }

    /**
     * @Route("/user/identity", name="user_identity")
     */
    public function editIdentity(): Response
    {
        $identity = new Identity();
        $form_identity = $this->createForm(IdentityFormType::class, $identity);
        
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