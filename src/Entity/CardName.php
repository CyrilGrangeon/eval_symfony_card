<?php

namespace App\Entity;

use App\Repository\CardNameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardNameRepository::class)]
class CardName
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $card_name;

    #[ORM\Column(type: 'integer')]
    private $number_cards_in_collection;

    #[ORM\Column(type: 'integer')]
    private $card_value_euros;

    #[ORM\Column(type: 'string', length: 255)]
    private $card_image;

    #[ORM\Column(type: 'datetime_immutable')]
    private $purchase_date;

    #[ORM\Column(type: 'datetime_immutable')]
    private $release_date;

    #[ORM\Column(type: 'boolean')]
    private $is_on_sale;

    #[ORM\Column(type: 'text')]
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardName(): ?string
    {
        return $this->card_name;
    }

    public function setCardName(string $card_name): self
    {
        $this->card_name = $card_name;

        return $this;
    }

    public function getNumberCardsInCollection(): ?int
    {
        return $this->number_cards_in_collection;
    }

    public function setNumberCardsInCollection(int $number_cards_in_collection): self
    {
        $this->number_cards_in_collection = $number_cards_in_collection;

        return $this;
    }

    public function getCardValueEuros(): ?int
    {
        return $this->card_value_euros;
    }

    public function setCardValueEuros(int $card_value_euros): self
    {
        $this->card_value_euros = $card_value_euros;

        return $this;
    }

    public function getCardImage(): ?string
    {
        return $this->card_image;
    }

    public function setCardImage(string $card_image): self
    {
        $this->card_image = $card_image;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeImmutable
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(\DateTimeImmutable $purchase_date): self
    {
        $this->purchase_date = $purchase_date;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeImmutable $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getIsOnSale(): ?bool
    {
        return $this->is_on_sale;
    }

    public function setIsOnSale(bool $is_on_sale): self
    {
        $this->is_on_sale = $is_on_sale;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
