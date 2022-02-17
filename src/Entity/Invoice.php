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
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payment_term;

    /**
     * @ORM\Column(type="float")
     */
    private $total_price;

    /**
     * @ORM\Column(type="date")
     */
    private $due_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(Order $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getPaymentTerm(): ?string
    {
        return $this->payment_term;
    }

    public function setPaymentTerm(string $payment_term): self
    {
        $this->payment_term = $payment_term;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): self
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
}
