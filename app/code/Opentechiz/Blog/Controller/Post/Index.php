<?php
namespace Opentechiz\Blog\Controller\Post;

use Opentechiz\Blog\Api\Data\PostInterface;
use Opentechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    protected $postCollectionFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Opentechiz\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // $posts = $this->postCollectionFactory
        //     ->create()
        //     ->addFilter('is_active', 1)
        //     ->addOrder(
        //         PostInterface::CREATION_TIME,
        //         PostCollection::SORT_ORDER_DESC
        //     );

        // foreach ($posts as $post) {
        //     var_dump($post->debug());
        //     die;
        // }        
                
        return $this->_pageFactory->create();
    }
}