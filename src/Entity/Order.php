<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryDate;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity=Invoices::class, mappedBy="orderRelated", cascade={"persist", "remove"})
     */
    private $invoice;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingCartItem::class, mappedBy="orderRelated")
     */
    private $shoppingCartItems;

    /**
     * @ORM\Column(type="boolean",  nullable=true)
     */
    private $isPreparing;

    /**
     * @ORM\Column(type="boolean",  nullable=true)
     */
    private $isPrepared;

    /**
     * @ORM\Column(type="boolean",  nullable=true)
     */
    private $isDelivered;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPending;

    public function __construct()
    {
        $this->shoppingCartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    public function setShippingDate(string $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(string $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getInvoice(): ?Invoices
    {
        return $this->invoice;
    }

    public function setInvoice(Invoices $invoice): self
    {
        // set the owning side of the relation if necessary
        if ($invoice->getOrderRelated() !== $this) {
            $invoice->setOrderRelated($this);
        }

        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return Collection<int, ShoppingCartItem>
     */
    public function getShoppingCartItems(): Collection
    {
        return $this->shoppingCartItems;
    }

    public function addShoppingCartItem(ShoppingCartItem $shoppingCartItem): self
    {
        if (!$this->shoppingCartItems->contains($shoppingCartItem)) {
            $this->shoppingCartItems[] = $shoppingCartItem;
            $shoppingCartItem->setOrderRelated($this);
        }

        return $this;
    }

    public function removeShoppingCartItem(ShoppingCartItem $shoppingCartItem): self
    {
        if ($this->shoppingCartItems->removeElement($shoppingCartItem)) {
            // set the owning side to null (unless already changed)
            if ($shoppingCartItem->getOrderRelated() === $this) {
                $shoppingCartItem->setOrderRelated(null);
            }
        }

        return $this;
    }

    public function getIsPreparing(): ?bool
    {
        return $this->isPreparing;
    }

    public function setIsPreparing(bool $isPreparing): self
    {
        $this->isPreparing = $isPreparing;

        return $this;
    }

    public function getIsPrepared(): ?bool
    {
        return $this->isPrepared;
    }

    public function setIsPrepared(bool $isPrepared): self
    {
        $this->isPrepared = $isPrepared;

        return $this;
    }

    public function getIsDelivered(): ?bool
    {
        return $this->isDelivered;
    }

    public function setIsDelivered(bool $isDelivered): self
    {
        $this->isDelivered = $isDelivered;

        return $this;
    }

    public function getIsPending(): ?bool
    {
        return $this->isPending;
    }

    public function setIsPending(bool $isPending): self
    {
        $this->isPending = $isPending;

        return $this;
    }
}
