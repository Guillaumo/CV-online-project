<?php

namespace App\Controller;

use App\Form\ArticleFormType;
use App\Form\HeadingFormType;
use App\Repository\CvRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/user/cv/{c_id}/editarticle/{a_id}", name="user_editarticle")
     */
    public function editArticle($c_id, $a_id, CvRepository $cvRepository, ArticleRepository $articleRepository, Request $request, EntityManagerInterface $em): Response
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet article
        $article = $articleRepository->find($a_id);
        // Initialisation du formulaire de modification d'un article
        $form_editarticle = $this->createForm(ArticleFormType::class, $article);
        // Récupération des champs remplis
        $form_editarticle->handleRequest($request);
        // Lors de la soumission et de la validation des données saisies du formualaire
        if ($form_editarticle->isSubmitted() && $form_editarticle->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
        }
        
        return $this->render('article/editarticle.html.twig', [
            'form_editarticle' => $form_editarticle->createView(),
            'article' => $article,
            'cv' => $cv,
        ]);
    }

    /**
     * @Route("/user/cv/{c_id}/removearticle/{a_id}", name="user_removearticle")
     */
    public function removeArticleFromCV($c_id, $a_id, CvRepository $cvRepository, ArticleRepository $articleRepository, EntityManagerInterface $em): Response
    {
        // On récupère l'objet CV
        $cv = $cvRepository->find($c_id);
        // On récupère l'objet article
        $article = $articleRepository->find($a_id);
        // Vérifier si la rubrique a du contenu

        // Suppression de l'article
        $em->remove($article);
        // $em->persist($heading);
        $em->flush();
        
        return $this->redirectToRoute('user_cv', ['id' => $cv->getId()]);
    }
}