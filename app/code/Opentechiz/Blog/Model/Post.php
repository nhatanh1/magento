<?php

namespace Opentechiz\Blog\Model;

use Opentechiz\Blog\Api\Data\PostInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface
{
    const CACHE_TAG = 'packt_opentechiz_post';
    const STATUS_ENABLE = '1';
    const STATUS_DISABLED = '0';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'blog_post';

    /**
     * @param \Magento\Framework\Model\Context $context
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
        $this->_init('Opentechiz\Blog\Model\ResourceModel\Post');
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

    public function checkUrlKey($url_key)
    {
        return $this->_getResource()->checkUrlKey($url_key);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLE => __("Enable"), self::STATUS_DISABLED => __("Disabled")];
    }

    public function getId()
    {
        return $this->_getData(self::POST_ID);
    }

    public function setId($id)
    {
        return $this->_setData(self::POST_ID, $id);
    }

    public function getUrlKey()
    {
        return $this->_getData(self::URL_KEY);
    }

    public function setUrlKey($url_key)
    {
        return $this->_setData(self::URL_KEY, $url_key);
    }

    public function getTitle()
    {
        return $this->_getData(self::TITLE);
    }

    public function setTitle($title)
    {
        return $this->_setData(self::TITLE, $title);
    }

    public function getContent()
    {
        return $this->_getData(self::CONTENT);
    }

    public function setContent($content)
    {
        return $this->_setData(self::CONTENT, $content);
    }

    public function getCreationTime()
    {
        return $this->_getData(self::CREATION_TIME);
    }

    public function setCreationTime($creationTime)
    {
        return $this->_setData(self::CREATION_TIME, $creationTime);
    }

    public function getUpdateTime()
    {
        return $this->_getData(self::UPDATE_TIME);
    }

    public function setUpdateTime($updateTime)
    {
        return $this->_setData(self::UPDATE_TIME, $updateTime);
    }

    public function isActive()
    {
        return $this->_getData(self::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        return $this->_setData(self::IS_ACTIVE, $isActive);
    }
}
