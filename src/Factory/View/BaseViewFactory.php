<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use Sylius\ElasticSearchPlugin\Document\DocumentInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class BaseViewFactory implements ProductListViewFactoryInterface
{

    /**
     * @var PropertyAccessor
     */
    protected $pa;

    /**
     * BaseViewFactory constructor.
     */
    public function __construct()
    {
        $this->pa = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param DocumentInterface $document
     * @param $viewClass
     * @return mixed
     */
    protected function mapDocumentToView(DocumentInterface $document, $viewClass, array $exclude = []) {

        $view = new $viewClass();
        $reflect = new \ReflectionClass($view);
        /** @var \ReflectionProperty $reflectionProperty */
        $reflectionProperties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($reflectionProperties as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            if (in_array($property, $exclude)) {
                continue;
            }
            if ($this->pa->isReadable($document, $property) && $this->pa->isWritable($view, $property)) {
                $this->pa->setValue($view, $property, $this->pa->getValue($document, $property));
            }
        }
        return $view;
    }


}
