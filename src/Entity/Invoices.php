<?php

namespace App\Entity;

use App\Repository\InvoicesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoicesRepository::class)
 */
class Invoices
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
    private $paymentTerm;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderRelated;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $salesComission;

    /**
     * @ORM\Column(type="integer")
     */
    private $comissionAmount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $isPaidDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentTerm(): ?string
    {
        return $this->paymentTerm;
    }

    public function setPaymentTerm(string $paymentTerm): self
    {
        $this->paymentTerm = $paymentTerm;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getOrderRelated(): ?Order
    {
        return $this->orderRelated;
    }

    public function setOrderRelated(Order $orderRelated): self
    {
        $this->orderRelated = $orderRelated;

        return $this;
    }

    public function getSalesComission(): ?string
    {
        return $this->salesComission;
    }

    public function setSalesComission(string $salesComission): self
    {
        $this->salesComission = $salesComission;

        return $this;
    }

    public function getComissionAmount(): ?int
    {
        return $this->comissionAmount;
    }

    public function setComissionAmount(int $comissionAmount): self
    {
        $this->comissionAmount = $comissionAmount;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getIsPaidDate(): ?\DateTimeInterface
    {
        return $this->isPaidDate;
    }

    public function setIsPaidDate(?\DateTimeInterface $isPaidDate): self
    {
        $this->isPaidDate = $isPaidDate;

        return $this;
    }
}
