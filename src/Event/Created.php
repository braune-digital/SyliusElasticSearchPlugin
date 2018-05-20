<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Event;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\ElasticSearchPlugin\Model\SearchableInterface;

abstract class Created
{
    /**
     * @var SearchableInterface
     */
    private $entity;

    /**
     * @param ProductInterface $product
     */
    public function __construct(SearchableInterface $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param ProductInterface $product
     *
     * @return self
     */
    abstract public static function occur(SearchableInterface $entity);

    /**
     * @return SearchableInterface
     */
    public function entity(): SearchableInterface
    {
        return $this->entity;
    }
}
