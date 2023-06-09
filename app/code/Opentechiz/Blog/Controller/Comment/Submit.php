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
use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Translate\Inline\State;
use Opentechiz\Blog\Model\CustomEmailSender;

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

    protected $_customerSession;

    protected $scopeConfig;

    protected $_inlineTranslation;

    /**
     * @var CustomEmail
     */
    protected $_customEmail;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        CommentFactory $commentFactory,
        DateTime $dateTime,
        JsonFactory $resultJsonFactory,
        TransportBuilder $transportBuilder,
        Session $session,
        ScopeConfigInterface $scopeConfig,
        State $state,
        CustomEmailSender $customEmailSender,
    ) {
        $this->dateTime = $dateTime;
        $this->commentFactory = $commentFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->_customerSession = $session;
        $this->scopeConfig = $scopeConfig;
        $this->_inlineTranslation = $state;
        $this->_customEmail = $customEmailSender;
        return parent::__construct($context);
    }

    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $customer = $this->_customerSession->getCustomer();

        $error = false;
        $message = '';
        $jsonResult = $this->resultJsonFactory->create();

        $comments = $this->commentFactory->create();
        if (!$this->_customerSession->isLoggedIn()) {
            $jsonResult->setData(['result' => 'error', 'message' => 'You not logged in']);
            return $jsonResult;
        }



        // Lấy dữ liệu gửi lên từ from
        $data = $this->checkComment();

        if (array_key_exists('error', $data)) {
            $error = true;
            $message = $data['error'];
        } else {
            $comments->setData($data);

            $nickname = $data['nickname'];
            $email = $customer['email'];

            $check = $comments->save();
        }

        $parameters = [
            'name' => $nickname,
            'email' => $email
        ];

        if ($check) {
            $this->_eventManager->dispatch('comment_success', $parameters);
            // $templateId = 'blog_comment_notification_email_template'; // template id
            // $fromEmail = 'noly241161@gmail.com';  // sender Email id
            // $fromName = 'Admin';             // sender Name
            // $toEmail = $customer['email']; // receiver email id
            // $templateVars = ['name' => $nickname];
            // $this->_customEmail->sendEmail($templateId, $templateVars, $fromEmail, $toEmail);
        }

        if (!$error) {
            $jsonResult->setData(['result' => 'success', 'message' => 'Thanks you submission', 'data' => $data]);
        } else {
            $jsonResult->setData(['result' => 'error', 'message' => $message]);
        }

        return $jsonResult;
    }

    public function checkComment()
    {
        $data = $this->getRequest()->getPostValue();
        // return $data;
        $now = $this->dateTime->gmtDate();

        $customerId = $this->_customerSession->getCustomerId();

        $formData = new DataObject($data);
        if (!$formData) {
            $error = 'Your submission is invalid. Please try again.';
            return ['error' => $error];
        }

        $post_id = $formData->getData('post_id');
        $nickname = $formData->getData('nickname');
        $title = $formData->getData('title');
        $comment = $formData->getData('comment');

        if (empty($nickname) || empty($title) || empty($comment)) {
            $error =  'Name can not be empty.';
            return ['error' => $error];
        }

        $comments = [
            'post_id' => $post_id,
            'title' => $title,
            'detail' => $comment,
            'nickname' => $nickname,
            'customer_id' => $customerId,
            'is_active' => '0',
            'creation_time' => $now,
            'update_time' => $now
        ];

        return $comments;
    }
}