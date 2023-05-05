<?php

namespace Opentechiz\Blog\Ui\DataProvider\Comment;

use Opentechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Opentechiz\Blog\Api\Data\CommentInterface;
use Opentechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class CommentDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
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
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create()
        ->addOrder(CommentInterface::CREATION_TIME, CommentCollection::SORT_ORDER_DESC);
    }
}