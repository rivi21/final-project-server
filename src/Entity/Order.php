<?php

namespace App\Entity;

use App\Repository\OrderRepository;
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
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer_id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=Invoice::class, mappedBy="order_id", cascade={"persist", "remove"})
     */
    private $invoice;

    /**
     * @ORM\OneToOne(targetEntity=Delivery::class, mappedBy="order_id", cascade={"persist", "remove"})
     */
    private $delivery;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?Customer
    {
        return $this->customer_id;
    }

    public function setCustomerId(?Customer $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        // set the owning side of the relation if necessary
        if ($invoice->getOrderId() !== $this) {
            $invoice->setOrderId($this);
        }

        $this->invoice = $invoice;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(Delivery $delivery): self
    {
        // set the owning side of the relation if necessary
        if ($delivery->getOrderId() !== $this) {
            $delivery->setOrderId($this);
        }

        $this->delivery = $delivery;

        return $this;
    }
}
