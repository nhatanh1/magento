<?php

namespace Opentechiz\Blog\Block;

use Opentechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Opentechiz\Blog\Api\Data\CommentInterface;
use Opentechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
use Magento\Framework\Escaper;
use Magento\Framework\DataObject\IdentityInterface;
use Opentechiz\Blog\Model\CommentFactory;
use Magento\Customer\Model\Session;

class CommentView extends \Magento\Framework\View\Element\Template implements IdentityInterface
{
    protected $_commentCollectionFactory;

    protected $escaper;

    protected $commentFactory;

    protected $_customerSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $commentCollectionFactory,
        Escaper $escaper,
        CommentFactory $commentFactory,
        Session $customerSession,
        array $data = []
    ) {
        $this->commentFactory = $commentFactory;
        $this->escaper = $escaper;
        $this->_commentCollectionFactory = $commentCollectionFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getComments()
    {
        $this->_isScopePrivate = true;
        $post_id = $this->getRequest()->getParam('post_id');
        $comments = $this->_commentCollectionFactory
            ->create()
            ->addFilter('main_table.is_active', 1)
            ->addFilter('main_table.post_id', $post_id)
            ->addOrder(CommentInterface::CREATION_TIME, CommentCollection::SORT_ORDER_DESC);

        return $comments;
    }

    public function getPrivateComments()
    {
        $postId = $this->getRequest()->getParam('post_id');
        $customerId = $this->_customerSession->getCustomerId();
        $collection = $this->_commentCollectionFactory->create();
        $collection->addFilter('is_active', 0)
            ->addFilter('post_id', $postId)
            ->addFilter('customer_id', $customerId)
            ->addOrder(CommentInterface::CREATION_TIME, CommentCollection::SORT_ORDER_DESC);
        return $collection;
    }

    public function getFormId()
    {
        return 'comment-form';
    }

    public function getFormAction()
    {
        return $this->getUrl('blog/comment/submit');
    }

    public function getEscapedHtml($html)
    {
        return $this->escaper->escapeHtml($html);
    }

    public function getPostId()
    {
        return $this->getRequest()->getParam('post_id');
    }

    public function getIdentities()
    {
        return $this->commentFactory->create()->getIdentities();
    }
}