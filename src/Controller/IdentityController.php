<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\Identity;
use App\Form\CvFormType;
use App\Form\IdentityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdentityController extends AbstractController
{
    /**
     * @Route("/user/identity", name="user")
     */
    public function editIdentity(): Response
    {
        $identity = new Identity();
        $form_identity = $this->createForm(IdentityFormType::class, $identity);
        
        return $this->render('identity/index.html.twig', [
            'form_identity' => $form_identity->createView()
        ]);
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function editCv(): Response
    {
        $cv = new Cv();
        $form_cv = $this->createForm(CvFormType::class, $cv);

        return $this->render('identity/index.html.twig', [
            'form_cv' => $form_cv->createView()
        ]);
    }
}