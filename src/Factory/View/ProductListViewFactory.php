<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Serializer;
use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\AttributeView;
use Sylius\ElasticSearchPlugin\Controller\ImageView;
use Sylius\ElasticSearchPlugin\Controller\PriceView;
use Sylius\ElasticSearchPlugin\Controller\ProductListView;
use Sylius\ElasticSearchPlugin\Controller\ProductView;
use Sylius\ElasticSearchPlugin\Controller\TaxonView;
use Sylius\ElasticSearchPlugin\Controller\VariantView;
use Sylius\ElasticSearchPlugin\Controller\ViewInterface;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;
use Sylius\ElasticSearchPlugin\Document\VariantDocument;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ProductListViewFactory extends ListViewFactory
{
    /** @var string */
    protected $productListViewClass;

    /** @var string */
    protected $productViewClass;

    /** @var string */
    protected $productVariantViewClass;

    /** @var string */
    protected $attributeViewClass;

    /** @var string */
    protected $imageViewClass;

    /** @var string */
    protected $priceViewClass;

    /** @var string */
    protected $taxonViewClass;

    public function __construct(
        Serializer $serializer,
        string $productListViewClass,
        string $productViewClass,
        string $productVariantViewClass,
        string $attributeViewClass,
        string $imageViewClass,
        string $priceViewClass,
        string $taxonViewClass
    ) {
        parent::__construct($serializer);
        $this->productListViewClass = $productListViewClass;
        $this->productViewClass = $productViewClass;
        $this->productVariantViewClass = $productVariantViewClass;
        $this->attributeViewClass = $attributeViewClass;
        $this->imageViewClass = $imageViewClass;
        $this->priceViewClass = $priceViewClass;
        $this->taxonViewClass = $taxonViewClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromSearchResponse(SearchResponse $response, $listViewClass): ViewInterface
    {
        $result = $response->getResult();

        /** @var ProductListView $productListView */
        $productListView = parent::createFromSearchResponse($response, $this->productListViewClass);

        /** @var ProductDocument $product */
        foreach ($result as $product) {
            $productListView->items[] = $this->getProductView($product);
        }

        return $productListView;
    }

    /**
     * @param Collection|ImageDocument[] $images
     *
     * @return ImageView[]
     */
    protected function getImageViews(Collection $images): array
    {
        $imageViews = [];
        foreach ($images as $image) {
            /** @var ImageView $imageView */
            $imageView = new $this->imageViewClass();
            $imageView->code = $image->getCode();
            $imageView->path = $image->getPath();

            $imageViews[] = $imageView;
        }

        return $imageViews;
    }

    /**
     * @param Collection|TaxonDocument[] $taxons
     * @param TaxonDocument|null $mainTaxonDocument
     *
     * @return TaxonView
     */
    protected function getTaxonView(Collection $taxons, ?TaxonDocument $mainTaxonDocument): TaxonView
    {
        /** @var TaxonView $taxonView */
        $taxonView = new $this->taxonViewClass();

        $taxonView->main = null === $mainTaxonDocument ? null : $mainTaxonDocument->getCode();
        foreach ($taxons as $taxon) {
            $taxonView->others[] = $taxon->getCode();
        }

        return $taxonView;
    }

    /**
     * @param Collection|AttributeDocument[] $attributes
     *
     * @return AttributeView[]
     */
    protected function getAttributeViews(Collection $attributes): array
    {
        $attributeValueViews = [];
        foreach ($attributes as $attribute) {
            /** @var AttributeView $attributeView */
            $attributeView = new $this->attributeViewClass();
            $attributeView->code = $attribute->getCode();
            $attributeView->value = $attribute->getValue();
            $attributeView->name = $attribute->getName();

            $attributeValueViews[$attribute->getCode()] = $attributeView;
        }

        return $attributeValueViews;
    }

    /**
     * @param PriceDocument $price
     *
     * @return PriceView
     */
    protected function getPriceView(PriceDocument $price): PriceView
    {
        /** @var PriceView $priceView */
        $priceView = new $this->priceViewClass();
        $priceView->current = $price->getAmount();
        $priceView->currency = $price->getCurrency();
        $priceView->original = $price->getOriginalAmount();

        return $priceView;
    }

    /**
     * @param VariantDocument[]|Collection $variants
     *
     * @return array
     */
    protected function getVariantViews(Collection $variants): array
    {
        $variantViews = [];
        foreach ($variants as $variant) {
            $variantView = $this->mapDocumentToView($variant, $this->productVariantViewClass, ['images']);
            if ($variant->getImages()->count() > 0) {
                $variantView->images = $this->getImageViews($variant->getImages());
            }
            $variantViews[] = $variantView;
        }

        return $variantViews;
    }

    /**
     * @param ProductDocument $product
     *
     * @return ProductView
     */
    protected function getProductView(ProductDocument $product): ProductView
    {

        /** @var ProductView $productView */
        $productView = $this->mapDocumentToView($product, $this->productViewClass, ['images', 'taxons', 'attributes', 'variants', 'price', 'mainTaxon']);

        if ($product->getImages()->count() > 0) {
            $productView->images = $this->getImageViews($product->getImages());
        }
        $productView->taxons = $this->getTaxonView($product->getTaxons(), $product->getMainTaxon());
        $productView->attributes = $this->getAttributeViews($product->getAttributes());
        $productView->variants = $this->getVariantViews($product->getVariants());
        $productView->price = $this->getPriceView($product->getPrice());

        return $productView;
    }
}
