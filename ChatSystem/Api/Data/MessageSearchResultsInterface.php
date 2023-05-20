<?php

declare(strict_types=1);

namespace Linhnv\ChatSystem\Api\Data;

interface MessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Message list.
     * @return \Linhnv\ChatSystem\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set chat_id list.
     * @param \Linhnv\ChatSystem\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

