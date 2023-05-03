<?php
namespace Opentechiz\Blog\Controller\Adminhtml\Post;

class Enable extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Opentechiz_Blog::enable';

    const PAGE_TITLE = 'Enable Post';

   
    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Opentechiz\Blog\Model\Post');
                $model->load($id);
                $model->setIsActive(true);
                $model->save();
                $this->messageManager->addSuccess(__('The post has been enable.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a post to enable.'));
        return $resultRedirect->setPath('*/*/');
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