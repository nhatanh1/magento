<?php

namespace Opentechiz\Blog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class PostActions extends Column
{
    /** Url path */
    const BLOG_URL_PATH_EDIT = 'blog/post/edit';
    const BLOG_URL_PATH_DELETE = 'blog/post/delete';
    const BLOG_URL_PATH_DISABLE = 'blog/post/disable';
    const BLOG_URL_PATH_ENABLE = 'blog/post/enable';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

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
        $editUrl = self::BLOG_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
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
                if (isset($item['post_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['post_id' => $item['post_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE, ['post_id' => $item['post_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "%1"', $item['title']),
                            'message' => __('Are you sure you wan\'t to delete a "%1" record?', $item['title'])
                        ]
                    ];
                    if ($item['is_active'] == 1) {
                        $item[$name]['disable'] = [
                            'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DISABLE, ['post_id' => $item['post_id']]),
                            'label' => __('Disable'),
                            'confirm' => [
                                'title' => __('Disable "%1"', $item['title']),
                                'message' => __('Are you sure you wan\'t to disable a "%1" record?', $item['title'])
                            ]
                        ];
                    } else {
                        $item[$name]['enable'] = [
                            'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_ENABLE, ['post_id' => $item['post_id']]),
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