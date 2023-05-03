<?php
namespace Opentechiz\Blog\Controller\View;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultForwardFactory;

    protected $_commentCollectionFactory;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
                                \Opentechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollection,
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_commentCollectionFactory = $commentCollection;
        parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        // $comments = $this->_commentCollectionFactory->create()
        // ->addFilter('main_table.is_active', 1)
        // ->addFilter('main_table.post_id', $post_id)
        // ->join('customer_entity', 'customer_entity.entity_id=main_table.customer_id',['lastname','firstname']);
        // foreach ($comments as $item) {
        //     print_r($item->debug());
        // }
        // die;
        $post_helper = $this->_objectManager->get('Opentechiz\Blog\Helper\Post');
        $result_page = $post_helper->prepareResultPost($this, $post_id);
        if (!$result_page) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $result_page;
    }
}