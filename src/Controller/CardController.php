<?php

namespace App\Controller;

use App\Form\CardType;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CardController extends AbstractController
{
    #[Route('/card', name: 'list_card')]
    public function list(Request $request, CardNameRepository $repo): Response
    {
        $filter = $this->createForm(FilterType::class);
        $filter->handleRequest($request);
        $cards = $repo->findAll();

        if($filter->isSubmitted() && $filter->isValid()){
            // $cards = $filter['CardValueEuros']->getData();
            $order = ($filter['priceOrder']->getData()? 'ASC' : 'DESC');
            $cards = $repo->filterCard($order);
        }

        return $this->render('card/cardlist.html.twig', [
            'cards' => $cards,
            'filter' => $filter->createView()
        ]);



        
    }

    #[Route('/deletecard/{id}', name: 'delete_card')]
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
    public function new(FileUpload $fileUploader, EntityManagerInterface $em, Request $request): Response
    {
        
        $card = new CardName();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($card->getCardImage() === null){
                $card->setCardImage('default.png');
            }else{
                $imageFile = $form->get('card_image')->getData();
                $imageFileName = $fileUploader->upload($imageFile);
                $card->setCardImage($imageFileName);
            }
           $card ->setCardName($form->getData() -> getCardName());
           
           $em ->persist($card);

           try
           {
                $em -> flush($card);
           }catch(Exception $e)
           {
                return $this->redirectToRoute('new_card');
           }
           
        }

        return $this->render('card/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    

    #[Route('/editcard/{id}', name: 'edit_card')]
    public function edit(FileUpload $fileUploader, CardName $card, Request $request, EntityManagerInterface $em): Response
    {
        $oldImage = $card->getCardImage();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
         $imageFile = $form->get('card_image')->getData();
         if($imageFile){
             
             if($imageFile !== $imageFile){
                 $fileUploader->fileDelete($oldImage);
             }
            $imageFileName = $fileUploader->upload($imageFile);
             $card->setCardImage($imageFileName);
         }else{
             $imageFile = $form->get('card_image')->getData();
             $imageFileName = $fileUploader->upload($imageFile);
             $card->setCardImage($imageFileName);
         }
         $em -> flush();
             return $this->redirectToRoute('list_card');
        }
 
         return $this->render('card/editcard.html.twig', [
             'form' => $form->createView()
         ]);
     }
}
