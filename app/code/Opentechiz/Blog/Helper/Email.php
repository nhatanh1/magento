<?php

namespace Opentechiz\Blog\Helper;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Sender email
     */
    const SENDER_EMAIL = 'trans_email/ident_general/email';
    /**
     * Email Template
     */
    const EMAIL_TEMPLATE = 'blog/email/comment_notification_email';
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    protected $request;
    protected $scopeConfig;

    /**
     * ChangeRequestEmailSender constructor
     *
     * @param TransportBuilder $transportBuilder
     * @param StateInterface   $inlineTranslation
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->logger = $logger;
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function sendEmail($customerName, $customerEmail)
    {
        $this->inlineTranslation->suspend();
        $adminAmail = $this->senderEmail();
        $emailtemplate = $this->emailTemplate();
        try {
            $templateVars = [
                'name' => $customerName,
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('blog_comment_notification_email_template')
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $this->_storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars(['name'=> $customerName])
                ->setFrom($adminAmail)
                ->addTo([$customerEmail])
                ->setReplyTo($customerEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (Exception $e) {
            print_r($e->getMessage());
            exit;
            $this->inlineTranslation->resume();
        }
    }

    public function senderEmail($type = null, $storeId = null)
    {
        $sender['email'] = 'noly241161@gmail.com';
        $sender['name'] = 'Admin';

        return $sender;
    }

    public function emailTemplate()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(
            self::EMAIL_TEMPLATE,
            $storeScope
        );
    }
}