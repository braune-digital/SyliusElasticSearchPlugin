<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\ViewInterface;
use Sylius\ElasticSearchPlugin\Document\DocumentInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class ListViewFactory implements ListViewFactoryInterface
{

    /**
     * @var PropertyAccessor
     */
    protected $pa;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * ListViewFactory constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->pa = PropertyAccess::createPropertyAccessor();
    }


    /**
     * {@inheritdoc}
     */
    public function createFromSearchResponse(SearchResponse $response, $listViewClass): ViewInterface
    {
        $result = $response->getResult();
        $filters = $response->getFilters();

        $listView = new $listViewClass();
        $listView->filters = $this->serializer->toArray($filters, SerializationContext::create());

        $pager = $filters['paginator']->getSerializableData()['pager'];
        $listView->page = $pager['current_page'];
        $listView->total = $pager['total_items'];
        $listView->pages = $pager['num_pages'];
        $listView->limit = $pager['limit'];
        return $listView;
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
