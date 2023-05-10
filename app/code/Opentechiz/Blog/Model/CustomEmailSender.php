<?php
namespace Opentechiz\Blog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class CustomEmailSender 
{
    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var StateInterface
     */
    protected $_inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * CustomEmail constructor.
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @param string $templateId
     * @param array $templateVars
     * @param string $from
     * @param string $to
     * @return bool
     * @throws MailException
     */
    public function sendEmail($templateId, $templateVars, $from, $to)
    {
        $transport = $this->_transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions([
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ])
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($to)
            ->setReplyTo($from)
            ->getTransport();

        $this->_inlineTranslation->suspend();
        try {
            $transport->sendMessage();
            $this->_inlineTranslation->resume();
            return true;
        } catch (\Exception $e) {
            $this->_inlineTranslation->resume();
            throw new MailException(new \Magento\Framework\Phrase($e->getMessage()), $e);
        }
    }
}