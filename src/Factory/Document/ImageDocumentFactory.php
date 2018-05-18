<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\Document;

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\ElasticSearchPlugin\Document\DocumentInterface;

final class ImageDocumentFactory implements ImageDocumentFactoryInterface
{
    /** @var string */
    private $imageDocumentClass;

    public function __construct(string $imageDocumentClass)
    {
        $this->imageDocumentClass = $imageDocumentClass;
    }

    public function create(ImageInterface $image): DocumentInterface
    {
        /** @var ImageDocument $imageDocument */
        $imageDocument = new $this->imageDocumentClass();
        $imageDocument->setCode($image->getType());
        $imageDocument->setPath($image->getPath());

        return $imageDocument;
    }
}
