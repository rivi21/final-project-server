<?php

namespace App\Entity;

use App\Repository\ShoppingCartItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingCartItemRepository::class)
 */
class ShoppingCartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="shoppingCartItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderRelated;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="shoppingCartItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Product;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrderRelated(): ?Order
    {
        return $this->orderRelated;
    }

    public function setOrderRelated(?Order $orderRelated): self
    {
        $this->orderRelated = $orderRelated;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }
}
