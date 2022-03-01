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
     * @ORM\Column(type="date")
     */
    private $date;

     /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="date")
     */
    private $shippingDate;

    /**
     * @ORM\Column(type="date")
     */
    private $deliveryDate;

    /**
     * @ORM\OneToOne(targetEntity=Invoices::class, mappedBy="orderRelated", cascade={"persist", "remove"})
     */
    private $invoice;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    

    /* public function getTotalPrice(): ?string
    {
        return $this->total_price;
    }

    public function setTotalPrice(string $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getPaymentTerms(): ?string
    {
        return $this->payment_terms;
    }

    public function setPaymentTerms(string $payment_terms): self
    {
        $this->payment_terms = $payment_terms;

        return $this;
    }

    
    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(\DateTimeInterface $due_date): self
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getSalesComission(): ?string
    {
        return $this->sales_comission;
    }

    public function setSalesComission(string $sales_comission): self
    {
        $this->sales_comission = $sales_comission;

        return $this;
    }

    public function getComissionAmount(): ?string
    {
        return $this->comission_amount;
    }

    public function setComissionAmount(string $comission_amount): self
    {
        $this->comission_amount = $comission_amount;

        return $this;
    } */

    public function getShippingDate(): ?\DateTimeInterface
    {
        return $this->shippingDate;
    }

    public function setShippingDate(\DateTimeInterface $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

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

   
}
