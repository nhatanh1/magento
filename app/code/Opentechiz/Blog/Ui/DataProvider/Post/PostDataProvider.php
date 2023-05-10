<?php

namespace Opentechiz\Blog\Ui\DataProvider\Post;

use Opentechiz\Blog\Model\ResourceModel\Post\CollectionFactory;
use Opentechiz\Blog\Api\Data\PostInterface;
use Opentechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class PostDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create()
            ->addFieldToSelect('*');
    }
}