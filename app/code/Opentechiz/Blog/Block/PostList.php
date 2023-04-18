<?php

namespace Opentechiz\Blog\Block;

use Opentechiz\Blog\Api\Data\PostInterface;
use Opentechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class PostList extends \Magento\Framework\View\Element\Template
{
    protected $postCollectionFactory;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Opentechiz\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->postCollectionFactory = $postCollectionFactory;
    }

    public function getPosts()
    {
        if (!$this->hasData('posts')) {
            $posts = $this->postCollectionFactory
                ->create()
                ->addFilter('is_active', 1)
                ->addOrder(
                    PostInterface::CREATION_TIME,
                    PostCollection::SORT_ORDER_DESC
                );
            $this->setData('posts', $posts);

            return $this->getData('posts');
        }
    }
}
