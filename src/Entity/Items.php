<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $short_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price_off_percent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dt_create = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dt_update = null;

    public function __construct()
    {
        if (null === $this->dt_create) {
            $this->dt_create = new \DateTime();
        }

        $this->dt_update = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceOffPercent(): ?int
    {
        return $this->price_off_percent;
    }

    public function setPriceOffPercent(int $price_off_percent): static
    {
        $this->price_off_percent = $price_off_percent;

        return $this;
    }

    public function getDtCreate(): ?\DateTimeInterface
    {
        return $this->dt_create;
    }

    public function setDtCreate(\DateTimeInterface $dt_create): static
    {
        $this->dt_create = $dt_create;

        return $this;
    }

    public function getDtUpdate(): ?\DateTimeInterface
    {
        return $this->dt_update;
    }

    public function setDtUpdate(\DateTimeInterface $dt_update): static
    {
        $this->dt_update = $dt_update;

        return $this;
    }
}
