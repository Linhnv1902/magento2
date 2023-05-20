<?php

declare(strict_types=1);

namespace Linhnv\ReviewApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Search results of Repository::getList method
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
interface ReviewSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Linhnv\ReviewApi\Api\Data\ReviewInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Linhnv\ReviewApi\Api\Data\ReviewInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
