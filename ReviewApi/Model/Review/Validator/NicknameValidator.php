<?php

declare(strict_types=1);

namespace Linhnv\ReviewApi\Model\Review\Validator;

use Linhnv\ReviewApi\Api\Data\ReviewInterface;
use Linhnv\ReviewApi\Validation\ValidationResult;
use Linhnv\ReviewApi\Validation\ValidationResultFactory;
use Linhnv\ReviewApi\Model\ReviewValidatorInterface;

/**
 * Class TitleValidator - - validates review nickname
 */
class NicknameValidator implements ReviewValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(ValidationResultFactory $validationResultFactory)
    {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * Check if nickname is not empty
     *
     * @param ReviewInterface $review
     *
     * @return ValidationResult
     */
    public function validate(ReviewInterface $review): ValidationResult
    {
        $value = (string)$review->getNickname();
        $errors = [];

        if (trim($value) === '') {
            $errors[] = __('"%field" can not be empty.', ['field' => ReviewInterface::NICKNAME]);
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
