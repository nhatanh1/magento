<?php

namespace Opentechiz\Blog\Model\Post\Source;

use Magento\Framework\Data\Form\Element\Column;

class PostAction extends Column
{


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as $items) {
                $name = $this->getData('name');
                if (isset(['post_id'])) {
                    $items[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE, ['post_id' => $items['post_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${$.$data.title}"'),
                            'message' => __('Are you sure you wan\'t to delete a "${$.$data.title}" record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
