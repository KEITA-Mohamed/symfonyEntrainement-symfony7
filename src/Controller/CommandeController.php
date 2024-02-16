<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[ROUTE('/commande')]
class CommandeController extends AbstractController
{

    #[ROUTE('/delete/{id}', name:'app_commande_delete', methods:['GET','POST'])]
    public function delete(EntityManagerInterface $em, $id,):Response
    {
        $commande=$em->getRepository(Commande::class)->find($id);
        $em->remove($commande);
        $em->flush();

        return $this->redirectToRoute('app_commande');
    }

    #[ROUTE('/show/{id}', name:'app_commande_show', methods:['GET', 'POST'])]
    public function show(CommandeRepository $cm, $id):Response
    {
        $commande=$cm->find($id);

        return $this->render("commande/show.html.twig",[
            'commande'=>$commande,
        ]);
    }




    #[ROUTE('/edit/{id}', name:'app_commande_edit', methods:['GET','POST'])]
    public function edit(EntityManagerInterface $em, Request $request, $id): Response
    {
        $id=(int) $id;

        if($id)
        {
            $commande=$em->getRepository(Commande::class)->find($id);
            
        }
        else
        {
            $commande=new Commande();
        }

    

        $form = $this->createForm(CommandeType::class,$commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($commande);
            $em->flush();
            
            return $this->redirectToRoute("app_commande");
        }

        return $this->render("commande/form.html.twig",[
            'form'=>$form->createView(),
        ]);

    }

    #[Route('/', name: 'app_commande', methods:['GET','POST'])]
    public function index(CommandeRepository $cm): Response
    {

        $commandes=$cm->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
