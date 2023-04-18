<?php
namespace Opentechiz\Blog\Model\Post\Source;

class isActive implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $post;

    public function __construct(\Opentechiz\Blog\Model\Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $avaliableOptions = $this->post->getAvailableStatuses();
        foreach ($avaliableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}