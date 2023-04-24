<?php
namespace Opentechiz\Blog\Controller\Adminhtml\Post;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\ResultFactory;

class MassDisable extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Opentechiz_Blog::massdisable';

    protected $filter;
    private $logger;
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Magento\Ui\Component\MassAction\Filter $filter,
       \Psr\Log\LoggerInterface $logger,
       \Opentechiz\Blog\Model\ResourceModel\Post\Collection $collectionFactory,
    )
    {
        $this->filter = $filter;
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
        return parent::__construct($context);
    }

    
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        
        foreach ($collection as $item) {
            try {
                //code...
                $item->setIsActive(false);
            $item->save();
            } catch (LocalizedException $e) {
                //throw $th;
                $this->logger->error($e->getLogMessage());
            }
            
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collection->getSize()));
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