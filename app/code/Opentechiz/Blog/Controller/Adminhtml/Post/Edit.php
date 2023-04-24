<?php

namespace Opentechiz\Blog\Controller\Adminhtml\Post;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    const ADMIN_RESOURCE = 'Opentechiz_Blog::edit';

    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_pageFactory->create();
        $resultPage->setActiveMenu(static::ADMIN_RESOURCE);
        $resultPage->addBreadcrumb(__(static::PAGE_TITLE), __(static::PAGE_TITLE));
        $resultPage->getConfig()->getTitle()->prepend(__(static::PAGE_TITLE));

        return $resultPage;
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}