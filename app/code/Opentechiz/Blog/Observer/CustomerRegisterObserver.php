<?php

namespace Opentechiz\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Opentechiz\Blog\Helper\Email;

class CustomerRegisterObserver implements ObserverInterface
{
    private $helperEmail;

    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $name = $observer['name'];
        $email = $observer['email'];
        return $this->helperEmail->sendEmail($name, $email);
    }
}
