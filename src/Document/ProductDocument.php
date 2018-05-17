<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;
use ONGR\ElasticsearchBundle\Result\ObjectIterator;

/**
 * @ElasticSearch\Document(type="product")
 */
class ProductDocument implements DocumentInterface
{
    /**
     * @var string
     *
     * @ElasticSearch\Id()
     */
    protected $uuid;

    /**
     * @var mixed
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $id;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $code;

    /**
     * @var string
     *
     * @ElasticSearch\Property(
     *    type="text",
     *    name="name",
     *    options={
     *        "fielddata"=true,
     *        "analyzer"="standard",
     *        "fields"={
     *            "raw"={"type"="keyword"},
     *            "standard"={"type"="text", "analyzer"="standard"}
     *        }
     *    }
     * )
     */
    protected $name;

    /**
     * @var bool
     *
     * @ElasticSearch\Property(type="boolean")
     */
    protected $enabled;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $slug;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $channelCode;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $localeCode;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="text")
     */
    protected $description;

    /**
     * @var PriceDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\PriceDocument")
     */
    protected $price;

    /**
     * @var TaxonDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\TaxonDocument")
     */
    protected $mainTaxon;

    /**
     * @var ObjectIterator|TaxonDocument[]
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\TaxonDocument", multiple=true)
     */
    protected $taxons;

    /**
     * @var ObjectIterator
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\AttributeDocument", multiple=true)
     */
    protected $attributes;

    /**
     * @var ObjectIterator
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\ImageDocument", multiple=true)
     */
    protected $images;

    /**
     * @var float
     */
    protected $averageReviewRating;

    /**
     * @var \DateTimeInterface
     *
     * @ElasticSearch\Property(type="date")
     */
    protected $createdAt;

    /**
     * @var ObjectIterator
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\VariantDocument", multiple=true)
     */
    protected $variants;

    /**
     * @var \DateTimeInterface
     *
     * @ElasticSearch\Property(type="date")
     */
    protected $synchronisedAt;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->taxons = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->variants = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getChannelCode(): string
    {
        return $this->channelCode;
    }

    /**
     * @param string $channelCode
     */
    public function setChannelCode(string $channelCode): void
    {
        $this->channelCode = $channelCode;
    }

    /**
     * @return string
     */
    public function getLocaleCode(): string
    {
        return $this->localeCode;
    }

    /**
     * @param string $localeCode
     */
    public function setLocaleCode(string $localeCode): void
    {
        $this->localeCode = $localeCode;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return PriceDocument
     */
    public function getPrice(): PriceDocument
    {
        return $this->price;
    }

    /**
     * @param PriceDocument $price
     */
    public function setPrice(PriceDocument $price): void
    {
        $this->price = $price;
    }

    /**
     * @return TaxonDocument
     */
    public function getMainTaxon(): ?TaxonDocument
    {
        return $this->mainTaxon;
    }

    /**
     * @param TaxonDocument $mainTaxon
     */
    public function setMainTaxon(TaxonDocument $mainTaxon): void
    {
        $this->mainTaxon = $mainTaxon;
    }

    /**
     * @return Collection|TaxonDocument[]
     */
    public function getTaxons(): Collection
    {
        return $this->taxons;
    }

    /**
     * @param Collection|TaxonDocument[] $taxons
     */
    public function setTaxons($taxons): void
    {
        $this->taxons = $taxons;
    }

    /**
     * @return ObjectIterator
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    /**
     * @param ObjectIterator $attributes
     */
    public function setAttributes(Collection $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return ObjectIterator
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param ObjectIterator $images
     */
    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    /**
     * @return float
     */
    public function getAverageReviewRating(): ?float
    {
        return $this->averageReviewRating;
    }

    /**
     * @param float $averageReviewRating
     */
    public function setAverageReviewRating(float $averageReviewRating): void
    {
        $this->averageReviewRating = $averageReviewRating;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getSynchronisedAt(): \DateTimeInterface
    {
        return $this->synchronisedAt;
    }

    /**
     * @param \DateTimeInterface $synchronisedAt
     */
    public function setSynchronisedAt(\DateTimeInterface $synchronisedAt): void
    {
        $this->synchronisedAt = $synchronisedAt;
    }

    /**
     * @return ObjectIterator
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    /**
     * @param ObjectIterator $variants
     */
    public function setVariants(Collection $variants): void
    {
        $this->variants = $variants;
    }
}
