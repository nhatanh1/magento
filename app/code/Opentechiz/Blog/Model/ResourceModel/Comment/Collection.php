<?php
namespace Opentechiz\Blog\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'comment_id';
    protected $_eventPrefix = 'opentechiz_blog_comment_collection';
    protected $_eventObject = 'comment_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Opentechiz\Blog\Model\Comment', 'Opentechiz\Blog\Model\ResourceModel\Comment');
    }
}