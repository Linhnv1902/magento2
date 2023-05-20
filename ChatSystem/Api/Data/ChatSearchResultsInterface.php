<?php
declare(strict_types=1);

namespace Linhnv\ChatSystem\Api\Data;

interface ChatSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Chat list.
     * @return \Linhnv\ChatSystem\Api\Data\ChatInterface[]
     */
    public function getItems();

    /**
     * Set user_id list.
     * @param \Linhnv\ChatSystem\Api\Data\ChatInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

