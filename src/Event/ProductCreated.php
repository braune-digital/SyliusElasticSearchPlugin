<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Event;


use Sylius\ElasticSearchPlugin\Model\SearchableInterface;

class ProductCreated extends Created {


    /**
     * @param ProductInterface $product
     *
     * @return self
     */
    public static function occur(SearchableInterface $entity)
    {
        return new self($entity);
    }
}
