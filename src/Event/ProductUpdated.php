<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Event;

use Sylius\ElasticSearchPlugin\Model\SearchableInterface;


class ProductUpdated extends Updated {


    /**
     * @param SearchableInterface $entity
     *
     * @return self
     */
    public static function occur(SearchableInterface $entity)
    {
        return new self($entity);
    }
}
