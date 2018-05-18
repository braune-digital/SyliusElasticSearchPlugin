<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ExclusionPolicy("all")
 */
class ImageView implements ViewInterface
{
    /**
     * @var string
     * @Groups({"autocomplete", "search"})
     */
    public $code;

    /**
     * @var string
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $path;
}
