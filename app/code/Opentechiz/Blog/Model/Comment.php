<?php

namespace Opentechiz\Blog\Model;

use Opentechiz\Blog\Api\Data\CommentInterface;

class Comment extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, CommentInterface
{
    const CACHE_TAG = 'opentechiz_blog_comment';

    /**
     * Model cache tag for clear cache in after save and after delete
     *CommentInterface
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'comment';

    /**
     * @param \Magento\Framework\Model\Context $contextCommentInterface
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Opentechiz\Blog\Model\ResourceModel\Comment');
    }

    /**
     * Return a unique id for the model.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->_getData('comment_id');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    public function getCommentId()
    {
        return $this->getData(self::COMMENT_ID);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function getDetail()
    {
        return $this->getData(self::DETAIL);
    }

    public function getNickName()
    {
        return $this->getData(self::NICKNAME);
    }

    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function IsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    public function setCommentId($commentId)
    {
        return $this->setData(self::COMMENT_ID, $commentId);
    }

    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function setDetail($detail)
    {
        return $this->setData(self::DETAIL, $detail);
    }

    public function setNickName($nickName)
    {
        return $this->setData(self::NICKNAME, $nickName);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }
}