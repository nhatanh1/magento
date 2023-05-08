<?php

namespace Opentechiz\Blog\Block;

use Opentechiz\Blog\Model\PostFactory;

class PostView extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PostFactory $postFactory,
        array $data = []
    ) {
        $this->_postFactory = $postFactory;
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
}