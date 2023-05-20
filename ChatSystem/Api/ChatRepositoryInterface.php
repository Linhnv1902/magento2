<?php

declare(strict_types=1);

namespace Linhnv\ChatSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ChatRepositoryInterface
{

    /**
     * Save Chat
     * @param \Linhnv\ChatSystem\Api\Data\ChatInterface $chat
     * @return \Linhnv\ChatSystem\Api\Data\ChatInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Linhnv\ChatSystem\Api\Data\ChatInterface $chat
    );

    /**
     * Retrieve Chat
     * @param string $chatId
     * @return \Linhnv\ChatSystem\Api\Data\ChatInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($chatId);

    /**
     * Retrieve Chat matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Linhnv\ChatSystem\Api\Data\ChatSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Chat
     * @param \Linhnv\ChatSystem\Api\Data\ChatInterface $chat
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Linhnv\ChatSystem\Api\Data\ChatInterface $chat
    );

    /**
     * Delete Chat by ID
     * @param string $chatId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($chatId);

    /**
     * Admin user send message
     * @param \Linhnv\ChatSystem\Api\Data\MessageInterface $message
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendAdminChatMessage(\Linhnv\ChatSystem\Api\Data\MessageInterface $message);

    /**
     * get customer message
     * @param int $customerId
     * @return \Linhnv\ChatSystem\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMyChat($customerId);

    /**
     * Customer send message
     * @param int $customerId
     * @param \Linhnv\ChatSystem\Api\Data\MessageInterface $message
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendCustomerChatMessage($customerId, \Linhnv\ChatSystem\Api\Data\MessageInterface $message);

}

