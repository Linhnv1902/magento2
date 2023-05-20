<?php

declare(strict_types=1);

namespace Linhnv\ReviewApi\Model\Review\Command;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete review by id command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial GetList call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \Linhnv\ReviewApi\Api\ReviewRepositoryInterface
 * @api
 */
interface DeleteByIdInterface
{
    /**
     * Delete the review data by review.
     *
     * @param int $reviewId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $reviewId): void;
}
