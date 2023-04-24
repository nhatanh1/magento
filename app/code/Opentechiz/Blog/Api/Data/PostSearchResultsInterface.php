<?php
namespace Opentechiz\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Opentechiz\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Opentechiz\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}