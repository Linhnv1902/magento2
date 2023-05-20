<?php

declare(strict_types=1);

namespace Linhnv\ReviewApi\Model\Review\Command;

use Linhnv\ReviewApi\Api\Data\ReviewInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Get review by id command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial GetList call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \Linhnv\ReviewApi\Api\ReviewRepositoryInterface
 * @api
 */
interface GetInterface
{
    /**
     * Retrieve Review By Id
     *
     * @param int $reviewId
     *
     * @return ReviewInterface
     * @throws NoSuchEntityException
     */
    public function execute(int $reviewId): ReviewInterface;
}
