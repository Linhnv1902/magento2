<?php

declare(strict_types=1);

namespace Linhnv\ReviewApi\Model\Review\Command;

use Linhnv\ReviewApi\Api\Data\ReviewInterface;
use Linhnv\ReviewApi\Validation\ValidationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Save review data command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial GetList call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \Linhnv\ReviewApi\Api\ReviewRepositoryInterface
 * @api
 */
interface SaveInterface
{
    /**
     * Save Review
     *
     * @param ReviewInterface $dataModel
     *
     * @return ReviewInterface
     *
     * @throws ValidationException
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function execute(ReviewInterface $dataModel): ReviewInterface;
}
