<?php

namespace Packt\HelloWorld\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $categorySetupFactory;

    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.2') < 0) {

            $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

            $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY); // lay khoa chinh

            $categorySetup->addAttribute(
                $entityTypeId,
                'helloworld_layble',
                [
                    'type' => 'varchar',
                    'label' => 'HeloWorld label',
                    'input' => 'text',
                    'required' => false,
                    'visible_on_front' => true,
                    'apply_to' =>
                    'simple,configurable,virtual,bundle,downloadable',
                    'unique' => false,
                    'group' => 'HelloWorld'
                ]
            );
        }
        $setup->endSetup();
    }
}