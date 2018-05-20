<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Event;

use Sylius\ElasticSearchPlugin\Model\SearchableInterface;


class ProductDeleted extends Deleted {

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
