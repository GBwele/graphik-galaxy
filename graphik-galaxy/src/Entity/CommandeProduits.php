<?php

namespace App\Entity;

use App\Repository\CommandeProduitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeProduitsRepository::class)]
class CommandeProduits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    private ?Products $produits = null;

    #[ORM\Column]
    private ?int $quantité = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduits(): ?Products
    {
        return $this->produits;
    }

    public function setProduits(?Products $produits): static
    {
        $this->produits = $produits;

        return $this;
    }

    public function getQuantité(): ?int
    {
        return $this->quantité;
    }

    public function setQuantité(int $quantité): static
    {
        $this->quantité = $quantité;

        return $this;
    }
}
