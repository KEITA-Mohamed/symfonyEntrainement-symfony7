<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{

    #[Route('/article/edit/{id}', name:'app_article_edit', methods:["GET","POST"])]
    public function edit(ArticleRepository $am, EntityManagerInterface $em, Request $request, $id):Response
    {
        if($id){

            $article=$am->find($id);
        }
        else{
            $article=new Article();
        }

        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_article');
        }

        return $this->render('/article/form.html.twig',['form'=>$form]);
    }

    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $am): Response
    {

        $articles=$am->findAll();  
        return $this->render('/article/index.html.twig', [
            'articles' => $articles,
            'nbr'=>count($articles),
        ]);
    }


}
