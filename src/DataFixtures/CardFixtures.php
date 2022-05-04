<?php

namespace App\DataFixtures;


use App\Entity\CardName;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i= 1; $i < 15; $i++){
            $card = new CardName();
            $cardNumber = rand(5, 10);
           


            $card->setCardName("Carte n° $i")
            ->setNumberCardsInCollection($cardNumber)
            ->setCardValueEuros($cardNumber)
            ->setCardImage("default.png")
            ->setPurchaseDate(new \DateTimeImmutable())
            ->setReleaseDate(new \DateTimeImmutable())
            ->setIsOnSale(true)
            ->setDescription("Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.");

            $manager->persist($card);

        }
        
        

        $manager->flush();
    }
}
