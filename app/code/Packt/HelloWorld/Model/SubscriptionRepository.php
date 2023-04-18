<?php
namespace Packt\HelloWorld\Model;

use Packt\HelloWorld\Api\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    const CACHE_TAG = 'packt_helloworld_subscription_repository';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'subscription_repository';

    /**
     * Undocumented variable
     *
     * @var \Packt\HelloWorld\Model\SubscriptionFactory
     */
    protected $subscriptionFactory;
    
    /**
     * Undocumented variable
     *
     * @var \Packt\HelloWorld\Model\ResourceModel\Subscription\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Packt\HelloWorld\Model\ResourceModel\Subscription\CollectionFactory $collectionFactory,
        \Packt\HelloWorld\Model\SubscriptionFactory $subscriptionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->subscriptionFactory = $subscriptionFactory;
    }

    public function getById($id)
    {
        $subscription = $this->subscriptionFactory->create();
        $subscription->load($id);
        return $subscription;
    }

    public function getList()
    {
        $collection = $this->collectionFactory->create();
        return $collection->getItems();
    }
}