<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\LigneCommande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[ROUTE('/commande')]
class CommandeController extends AbstractController
{

    #[ROUTE('/submit', name:'app_commande_submit', methods:['GET','POST'])]
    public function ligneCommandeSubmit(EntityManagerInterface $em, Request $request):Response
    {   
        $commande_id=$request->get('commande_id');
        $numArticle=$request->get('numArticle');
        $quantite=$request->get('quantite');
        $quantite=(!$quantite)?1:$quantite;


        $commande=$em->getRepository(Commande::class)->find($commande_id);
        $article=$em->getRepository(Article::class)->findOneBy(['numArticle'=>$numArticle]);

        $ligneCommande=new LigneCommande();
        $ligneCommande->setCommande($commande);
        $ligneCommande->setArticle($article);
        $ligneCommande->setQuantite($quantite);
        $ligneCommande->setPrixUnitaire($article->getPrixUnitaire());

        $em->persist($ligneCommande);
        $em->flush();

        $rows=[];
        $total=0;

        $ligneCommandes=$commande->getLigneCommandes();

        foreach($ligneCommandes as $ligne)
        {
           $article=$ligne->getArticle();
           $prixUnitaire=$ligne->getPrixUnitaire();
           $quantite=$ligne->getQuantite();
           $montant=$prixUnitaire*$quantite;

           $total+=$montant;

           $rows[]=[
            "numArticle"=>$article->getNumArticle(),
            "prixUnitaire"=>$prixUnitaire,
            "montant"=>$montant,
            "quantite"=>$quantite,
            'designation'=>$article->getDesignation(),
           ];


        }

        $response=[
            'rows'=>$rows,
            'total'=>$total,
        ];

        echo json_encode($response);
        exit;

        
    }


    #[ROUTE('/search_code', name:'app_commande_search_code', methods:['GET','POST'])]
    public function searchCode(EntityManagerInterface $em, Request $request)
    {
        $numArticle=$request->get('numArticle');

        $article=$em->getRepository(Article::class)->findOneBy(['numArticle'=>$numArticle]);

        if($article)
        {
           $response=[
            'id'=>$article->getId(),
            'numArticle'=>$article->getNumArticle(),
            'designation'=>$article->getDesignation(),
            'prixUnitaire'=>$article->getPrixUnitaire(),
           ];
        }
        else
        {
            $response=[];
        }

        echo json_encode($response);
        exit;
    }



    #[ROUTE('/content/{id}', name:'app_commande_content', methods:['GET','POST'])]
    public function ligneCommande(EntityManagerInterface $em, $id):Response
    {
        $commande=$em->getRepository(Commande::class)->find($id);

        $ligneCommandes=$commande->getLigneCommandes();

        $total=0;
        $rows=[];

        foreach($ligneCommandes as $ligne)
        {
            $article=$ligne->getArticle();
            $quantite=$ligne->getQuantite();
            $prixUnitaire=$ligne->getPrixUnitaire();

            $montant=$prixUnitaire*$quantite;
            $total+=$montant;

            $rows=[
                'numArticle'=>$article->getNumArticle(),
                'designation'=>$article->getDesignation(),
                'prixUnitaire'=>number_format($prixUnitaire,2,'.',''),
                'montant'=>number_format($montant,2,'.',''),

            ];


        }

        return $this->render('commande/ligneCommande.html.twig',[
            'commande'=>$commande,
            'rows'=>$rows,
            'total'=>$total,
        ]);

        //dd($commande);
       // dd($ligneCommandes);
    }

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
