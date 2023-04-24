<?php

namespace Opentechiz\Blog\Controller\Adminhtml\Post;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;


class MassDelete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Opentechiz_Blog::massdelete';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $filter;
    private $logger;
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Opentechiz\Blog\Model\ResourceModel\Post\CollectionFactory $collectionFactory,
        LoggerInterface $logger = null
    ) {
        $this->logger = $logger ?: ObjectManager::getInstance()->create(LoggerInterface::class);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            try {
                $item->delete();
            } catch (LocalizedException $e) {
                $this->logger->error($e->getLogMessage());
            }
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return  $resultRedirect->setPath('*/*/');
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