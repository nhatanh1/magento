<?php

namespace Opentechiz\Blog\Controller\Comment;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\DataObject;
use Opentechiz\Blog\Model\ResourceModel\CommentFactory as ResourceCommentFactory;
use Opentechiz\Blog\Model\CommentFactory;
use Opentechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Mail\Template\TransportBuilder;

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

    protected $resultJsonFactory;

    protected $_transportBuilder;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        CommentFactory $commentFactory,
        DateTime $dateTime,
        JsonFactory $resultJsonFactory,
        TransportBuilder $transportBuilder
    ) {
        $this->dateTime = $dateTime;
        $this->commentFactory = $commentFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_transportBuilder = $transportBuilder;
        return parent::__construct($context);
    }

    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $error = false;
        $message = '';

        $comments = $this->commentFactory->create();

        // Lấy dữ liệu gửi lên từ from
        $data = $this->getRequest()->getPostValue();

        $formData = new DataObject($data);
        if (!$formData) {
            $error = true;
            $message = 'Your submission is invalid. Please try again.';
        }

        $post_id = $formData->getData('post_id');
        $email = $formData->getData('email');
        $nickname = $formData->getData('nickname');
        $title = $formData->getData('title');
        $comment = $formData->getData('comment');

        if (empty($nickname) || empty($title) || empty($comment)) {
            $error = true;
            $message .= 'Name can not be empty.';
        }

        $comments->setData([
            'post_id' => $post_id,
            'email' => $email,
            'title' => $title,
            'detail' => $comment,
            'nickname' => $nickname,
            'is_active' => '0',
            'creation_time' => $this->dateTime->gmtDate(),
            'update_time' => $this->dateTime->gmtDate()
        ]);

        $check = $comments->save();

        if ($check) {
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $from = ['email' => 'noly241161@gmail.com', 'name' => 'Nanhh'];
            
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->scopeConfig->getValue('blog/general/template', $storeScope))
                ->setTemplateOptions(
                    [
                        'area' =>   \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                        'store' =>  \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['name' => $nickname])
                ->setFrom($from )
                ->addTo([$email])
                ->setReplyTo($email)
                ->getTransport();

            $transport->sendMessage();
        }

        $jsonResult = $this->resultJsonFactory->create();

        if (!$error) {
            $jsonResult->setData(['result' => 'success', 'message' => 'Thanks you submission']);
        } else {
            $jsonResult->setData(['result' => 'error', 'message' => $message]);
        }

        return $jsonResult;
    }
}