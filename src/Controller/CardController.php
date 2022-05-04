<?php

namespace App\Controller;

use App\Entity\CardName;
use App\Form\FilterType;
use App\Service\FileUpload;
use App\Repository\CardNameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/card', name: 'list_card')]
    public function list(Request $request, CardNameRepository $repo): Response
    {
        $filter = $this->createForm(FilterType::class);
        $filter->handleRequest($request);
        $cards = $repo->findAll();

        if($filter->isSubmitted() && $filter->isValid()){
            $card = $filter['price']->getData();
            $order = ($filter['priceOrder']->getData()? 'ASC' : 'DESC');
            $cards = $repo->filterCard($order);
        }

        return $this->render('card/cardlist.html.twig', [
            'cards' => $cards,
            'filter' => $filter->createView()
        ]);



        
    }

    #[Route('/deletecard', name: 'delete_card')]
    public function delete(EntityManagerInterface $em, CardName $card): Response
    {
        $em->remove($card);
        try{
            $em->flush();
            $this->addFlash('success', 'Carte supprimée.');
        }catch(Exception $e){
            $this->addFlash('danger', 'Echec lors de la suppression de la carte.');
        }

        return $this->redirectToRoute("list_card");
    }

    #[Route('/newcard', name: 'new_card')]
    public function new(FileUpload $fileUploader, EntityManagerInterface $em, Request $request): Response{
        $card = new CardName();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($card->getCardImage() === null){
                $card->setCardImage('default.png');
            }else{
                $imageFile = $form->get('image')->getData();
                $imageFileName = $fileUploader->upload($imageFile);
                $card->setCardImage($imageFileName);
            }
            $em->persist($card);
            try{
                $em->flush();
                $this->addFlash('success', 'Carte créée.');
            }catch(Exception $e){
                $this->addFlash('danger', 'Echec lors de la création de la carte.');

                return $this->redirectToRoute('new_card');
            }
            
            return $this->redirectToRoute('list_card');
        }
        return $this->render('card/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
