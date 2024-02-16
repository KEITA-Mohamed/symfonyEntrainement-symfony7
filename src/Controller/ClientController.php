<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/client')]
class ClientController extends AbstractController
{

    #[Route('/edit/{id}', name:'app_client_edit', methods:['GET', 'POST'])]
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
        $id=(int) $id;

        if($id){

            $client=$em->getRepository(Client::class)->find($id);

            //dd($client);
        }
        else{
            $client=new Client();
        }

        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('app_client');
        }

        return $this->render('/client/form.html.twig',['form'=>$form]);

    }


    #[Route('/', name: 'app_client', methods: ['GET','POST'])]
    public function index(ClientRepository $cr): Response
    {
        $clients=$cr->findAll();

        //dd($clients);

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'nbr'=>count($clients),
        ]);
    }
}
