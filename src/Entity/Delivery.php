<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="delivery", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\Column(type="date")
     */
    private $shipping_date;

    /**
     * @ORM\Column(type="date")
     */
    private $delivery_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shipping_coditions;

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

    public function getShippingDate(): ?\DateTimeInterface
    {
        return $this->shipping_date;
    }

    public function setShippingDate(\DateTimeInterface $shipping_date): self
    {
        $this->shipping_date = $shipping_date;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->delivery_date;
    }

    public function setDeliveryDate(\DateTimeInterface $delivery_date): self
    {
        $this->delivery_date = $delivery_date;

        return $this;
    }

    public function getShippingCoditions(): ?string
    {
        return $this->shipping_coditions;
    }

    public function setShippingCoditions(string $shipping_coditions): self
    {
        $this->shipping_coditions = $shipping_coditions;

        return $this;
    }
}
