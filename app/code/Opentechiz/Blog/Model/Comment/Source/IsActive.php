<?php
namespace Opentechiz\Blog\Model\Comment\Source;

class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Opentechiz\Blog\Model\Comment
     */
    protected $comment;

    /**
     * Constructor
     *
     * @param \Opentechiz\Blog\Model\Comment $comment
     */
    public function __construct(\Opentechiz\Blog\Model\Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->comment->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}