<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
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
    private $payment_terms;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_price;

    /**
     * @ORM\Column(type="date")
     */
    private $due_date;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $related_order;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sales_comission;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $comission_amount;

    public function __toString()
    {
        return $this->due_date;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): self
    {
        $this->total_price = $total_price;

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

    public function getRelatedOrder(): ?Order
    {
        return $this->related_order;
    }

    public function setRelatedOrder(Order $related_order): self
    {
        $this->related_order = $related_order;

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
    }

    
}
