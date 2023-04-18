<?php

namespace Packt\HelloWorld\Controller\Index;

class Collection extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\PageFactory */

    protected $collectionFactory;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $subscriptionRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Packt\HelloWorld\Model\ResourceModel\Subscription\CollectionFactory $collectionFactory,
        \Packt\HelloWorld\Api\SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->subscriptionRepository = $subscriptionRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        // $productCollection = $this->_objectManager
        //     ->create('Magento\Catalog\Model\ResourceModel\Product\Collection') //model truy van  == from
        //     ->addAttributeToSelect(['name', 'price', 'image',]) //lay du lieu cua model  == select
        //     // ->setPageSize(10,1);  // == start limit trong sql
        //     // ->addAttributeToFilter('name', 'Overnight Duffle'); // filter  = where
        //     // ->addAttributeToFilter('entity_id', array('in' => array(159, 160, 161))); // = where entity_id in []
        //     ->addAttributeToFilter('name', array('like' => '%Sport%'));

        // $subscriptionCollection = $this->collectionFactory->create();
        // $subscriptionCollection->addFieldToSelect('*')->setPageSize(10)->setCurPage(1);
        $output = '';

        $subscriptionRepository = $this->subscriptionRepository->getList();
        // var_dump($subscriptionRepository->debug());

        // $productCollection->setDataToAll('price', 20); // setDataToAll() update dulieu (chi luu vao db khi goi save())
        // var_dump($subscriptionRepository);
        foreach ($subscriptionRepository as $item) {
            // $item .= var_dump($item->debug(), null, false);
            var_dump($item->debug());
        }
        $this->getResponse()->setBody($output);
    }
}