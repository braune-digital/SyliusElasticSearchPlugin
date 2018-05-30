<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Model;


interface IndexableInterface {
    public function isIndexable(): bool;
}
