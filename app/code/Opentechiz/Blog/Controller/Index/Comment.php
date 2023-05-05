<?php

namespace Opentechiz\Blog\Controller\Index;

use Magento\Framework\Controller\Result\JsonFactory;

class Comment extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $error = false;
        $message = '';

        $post = $this->getRequest()->getPostValue();
        $name = $post->getData('nickname');

        if (!$post) {
            $error = true;
            $message = 'Your submission is invalid. Please try again.';
        }
        $postObject = new \Magento\Framework\DataObject;
        $postObject->setData($post);


        if (isset($name)) {
            $error = true;
            $message .= 'Name can not be empty.';
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