<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\MailerType;
use Symfony\Component\Mime\Email;
use App\Repository\CardRepository;
use Symfony\Component\Mime\Address;
use App\Repository\CardNameRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer/{id}", name="sendmail")
     */
    public function mailer(CardNameRepository $repo, string $id,  MailerInterface $mailer): Response
    {   
        
        $repo = $repo->findOneBy(['id' => $id]);
        $name = $repo->getCardName();
      
        $email = (new TemplatedEmail())
        ->from('cyrilgrangeontest@example.com')
        ->to('cyril43@example.com')
        ->subject('Demande de carte !')
        ->text('Cet utilisateur souhaite proposer un prix pour cette carte')
        // path of the Twig template to render
      // ->htmlTemplate('mailer/index.html.twig')

        // pass variables (name => value) to the template
        ->context([
            'card_name' => $name
        ])
    ;

        $mailer->send($email);

        return $this->render('mailer/index.html.twig',);
      

        //return $this->redirectToRoute('homecard');


        
    }
}