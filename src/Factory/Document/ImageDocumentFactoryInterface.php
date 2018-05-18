<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\Document;

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\ElasticSearchPlugin\Document\DocumentInterface;

interface ImageDocumentFactoryInterface extends DocumentFactoryInterface
{
    public function create(ImageInterface $image): DocumentInterface;
}
