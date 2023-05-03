<?php

namespace Opentechiz\Blog\Block;

use Opentechiz\Blog\Model\PostFactory;
use Opentechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Opentechiz\Blog\Api\Data\CommentInterface;
use Opentechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
use Magento\Framework\Escaper;

class PostView extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;

    protected $_commentCollectionFactory;

    protected $escaper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PostFactory $postFactory,
        CollectionFactory $commentCollectionFactory,
        Escaper $escaper,
        array $data = []
    ) {
        $this->_postFactory = $postFactory;
        $this->escaper = $escaper;
        $this->_commentCollectionFactory = $commentCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getPost()
    {
        $post_id = $this->getRequest()->getParam('post_id');

        $post = $this->_postFactory->create();
        $post->load($post_id);
        // $data = PostResource::load($post, $post_id, 'post_id');
        // Collection::getCommentBypostId($postId);
        return $post;
    }

    public function getComments()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $comments = $this->_commentCollectionFactory
            ->create()
            ->addFilter('main_table.is_active', 1)
            ->addFilter('main_table.post_id', $post_id)
            ->join('customer_entity', 'customer_entity.entity_id=main_table.customer_id', ['lastname', 'firstname'])
            ->addOrder(CommentInterface::CREATION_TIME, CommentCollection::SORT_ORDER_DESC);

        return $comments;
    }

    public function getFormId()
    {
        return 'blog_comment_form';
    }

    public function getFormAction()
    {
        return $this->getUrl('blog/comment/submit');
    }

    public function getEscapedHtml($html)
    {
        return $this->escaper->escapeHtml($html);
    }
}