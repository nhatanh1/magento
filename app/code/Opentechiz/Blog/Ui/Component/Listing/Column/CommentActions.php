<?php

namespace Opentechiz\Blog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class CommentActions extends Column
{
    /** Url path */
    const BLOG_URL_PATH_DELETE = 'blog/comments/delete';
    const BLOG_URL_PATH_DISABLE = 'blog/comments/disable';
    const BLOG_URL_PATH_ENABLE = 'blog/comments/enable';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['comment_id'])) {
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE, ['comment_id' => $item['comment_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "%1"', $item['title']),
                            'message' => __('Are you sure you wan\'t to delete a "%1" record?', $item['title'])
                        ]
                    ];
                    if ($item['is_active'] == 1) {
                        $item[$name]['disable'] = [
                            'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DISABLE, ['comment_id' => $item['comment_id']]),
                            'label' => __('Disable'),
                            'confirm' => [
                                'title' => __('Disable "%1"', $item['title']),
                                'message' => __('Are you sure you wan\'t to disable a "%1" record?', $item['title'])
                            ]
                        ];
                    } else {
                        $item[$name]['enable'] = [
                            'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_ENABLE, ['comment_id' => $item['comment_id']]),
                            'label' => __('Enable'),
                            'confirm' => [
                                'title' => __('Enable "%1"', $item['title']),
                                'message' => __('Are you sure you wan\'t to enable a "%1" record?', $item['title'])
                            ]
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}
