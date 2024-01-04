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
    private ?string $shortName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $priceOffPercent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dtCreate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dtUpdate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shopName = null;

    #[ORM\Column(length: 255)]
    private ?string $salePrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Shop $shopId = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Category $category = null;

    #[ORM\Column(length: 1020, nullable: true)]
    private ?string $feature = null;

    public function __construct()
    {
        if (null === $this->dtCreate) {
            $this->dtCreate = new \DateTime();
        }

        $this->dtUpdate = new \DateTime();
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
        return $this->shortName;
    }

    public function setShortName(string $shortName): static
    {
        $this->shortName = $shortName;

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
        return $this->priceOffPercent;
    }

    public function setPriceOffPercent(int $priceOffPercent): static
    {
        $this->priceOffPercent = $priceOffPercent;

        return $this;
    }

    public function getDtCreate(): ?\DateTimeInterface
    {
        return $this->dtCreate;
    }

    public function setDtCreate(\DateTimeInterface $dtCreate): static
    {
        $this->dtCreate = $dtCreate;

        return $this;
    }

    public function getDtUpdate(): ?\DateTimeInterface
    {
        return $this->dtUpdate;
    }

    public function setDtUpdate(\DateTimeInterface $dtUpdate): static
    {
        $this->dtUpdate = $dtUpdate;

        return $this;
    }

    public function getShopName(): ?string
    {
        return $this->shopName;
    }

    public function setShopName(?string $shopName): static
    {
        $this->shopName = $shopName;

        return $this;
    }

    public function getSalePrice(): ?string
    {
        return $this->salePrice;
    }

    public function setSalePrice(string $salePrice): static
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getShopId(): ?Shop
    {
        return $this->shopId;
    }

    public function setShopId(?Shop $shopId): static
    {
        $this->shopId = $shopId;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFeature(): ?string
    {
        return $this->feature;
    }

    public function setFeature(?string $feature): static
    {
        $this->feature = $feature;

        return $this;
    }
}
