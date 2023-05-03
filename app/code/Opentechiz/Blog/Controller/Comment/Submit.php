<?php

namespace Opentechiz\Blog\Controller\Comment;

use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Opentechiz\Blog\Model\ResourceModel\CommentFactory as ResourceCommentFactory;
use Opentechiz\Blog\Model\CommentFactory;
use Opentechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Submit extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var ResourceCommentFactory $commentFactory
     */
    protected $resourceCommentFactory;

    /**
     * @var CollectionFactory $commentCollectionFactory
     */
    protected $commentCollectionFactory;

    protected $commentFactory;

    /** 
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     */
    protected $dateTime;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        ResourceCommentFactory $resourceCommentFactory,
        CollectionFactory $commentCollectionFactory,
        CommentFactory $commentFactory,
        DateTime $dateTime,
        Validator $formKeyValidator
    ) {
        $this->dateTime = $dateTime;
        $this->_pageFactory = $pageFactory;
        $this->commentFactory = $commentFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->resourceCommentFactory = $resourceCommentFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
        return parent::__construct($context);
    }

    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            throw new LocalizedException(__('Form key is invalid.'));
        }

        $collection = $this->commentCollectionFactory->create();

        $comments = $this->commentFactory->create();

        // Lấy dữ liệu gửi lên từ from
        $data = $this->getRequest()->getPostValue();

        $formData = new DataObject($data);

        $post_id = $formData->getData('post_id');
        $customer_id = $formData->getData('customer_id');
        $post_url = $formData->getData('post_url');
        $nickname = $formData->getData('nickname');
        $title = $formData->getData('title');
        $comment = $formData->getData('comment');

        if (empty($nickname) || empty($title) || empty($comment)) {
            throw new LocalizedException(__('Please fill in all required fields.'));

            $this->messageManager->addErrorMessage(__('Please fill in all required fields.'));
            $this->_redirect($post_url);
        }

        $comments->setData([
            'post_id' => $post_id,
            'customer_id' => $customer_id,
            'title' => $title,
            'detail' => $comment,
            'nickname' => $nickname,
            'is_active' => '0',
            'creation_time' => $this->dateTime->gmtDate(),
            'update_time' => $this->dateTime->gmtDate()
        ]);

        $comments->save();

        $this->messageManager->addSuccessMessage(__('Your comment has been submitted successfully.'));
        $this->_redirect($post_url);
    }
}
