<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $orderNum = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $orderDelivery = null;

    #[ORM\Column(length: 255)]
    private ?string $total = null;

    #[ORM\ManyToOne(inversedBy: 'idOrder')]
    private ?Clients $clients = null;

    #[ORM\ManyToMany(targetEntity: Products::class, inversedBy: 'orders')]
    private Collection $detail;

    public function __construct()
    {
        $this->detail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNum(): ?string
    {
        return $this->orderNum;
    }

    public function setOrderNum(string $orderNum): self
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getOrderDelivery(): ?\DateTimeInterface
    {
        return $this->orderDelivery;
    }

    public function setOrderDelivery(\DateTimeInterface $orderDelivery): self
    {
        $this->orderDelivery = $orderDelivery;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getClients(): ?Clients
    {
        return $this->clients;
    }

    public function setClients(?Clients $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(Products $detail): self
    {
        if (!$this->detail->contains($detail)) {
            $this->detail->add($detail);
        }

        return $this;
    }

    public function removeDetail(Products $detail): self
    {
        $this->detail->removeElement($detail);

        return $this;
    }
}
