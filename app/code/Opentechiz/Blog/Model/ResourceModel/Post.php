<?php
namespace Opentechiz\Blog\Model\ResourceModel;

use Magento\Framework\Stdlib\DateTime\DateTime;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected $date;
    
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        DateTime $date,
    )
    {
        parent::__construct($context);
        $this->date = $date;
    }

    protected function _construct()
    {
        $this->_init('opentechiz_blog_post', 'post_id');
    }

    protected function _getLoadByUrlKeySelect($url_key, $isActive = null)
    {
        $select = $this->getConnection()->select()->from(
            ['bp' => $this->getMainTable()]
        )->where(
            'bp.url_key = ?',
            $url_key
        );

        if (!is_null($isActive)) {
            $select->where('bp.is_active = ?', $isActive);
        }

        return $select;
    }


    public function checkUrlKey($url_key)
    {
        $select = $this->_getLoadByUrlKeySelect($url_key, 1);
        $select->reset(\Zend_Db_Select::COLUMNS)->columns('bp.post_id')->limit(1);

        return $this->getConnection()->fetchOne($select);
    }
}