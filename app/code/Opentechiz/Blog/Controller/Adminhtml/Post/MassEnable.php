<?php
namespace Opentechiz\Blog\Controller\Adminhtml\Post;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Opentechiz\Blog\Model\ResourceModel\Post\CollectionFactory;

class MassEnable extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Opentechiz_Blog::massenable';

    protected $filter;
    private $logger;
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       Filter $filter,
       LoggerInterface $logger,
       CollectionFactory $collectionFactory,
    )
    {
        $this->filter = $filter;
        $this->logger = $logger;
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
            $item->setIsActive(true);
            $item->save();
        } catch (LocalizedException $e) {
           $this->logger->error($e->getLogMessage());
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been enabled.', $collectionSize));
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
       }
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