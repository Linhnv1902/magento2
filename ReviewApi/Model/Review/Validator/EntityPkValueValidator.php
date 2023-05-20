<?php

declare(strict_types=1);

namespace Linhnv\ReviewApi\Model\Review\Validator;

use Linhnv\ReviewApi\Api\Data\ReviewInterface;
use Linhnv\ReviewApi\Validation\ValidationResult;
use Linhnv\ReviewApi\Validation\ValidationResultFactory;
use Linhnv\ReviewApi\Model\ReviewValidatorInterface;

/**
 * Class TitleValidator - validates review entityPkValue
 */
class EntityPkValueValidator implements ReviewValidatorInterface
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
     * Check if Review has entity pk value
     *
     * @param ReviewInterface $review
     *
     * @return ValidationResult
     */
    public function validate(ReviewInterface $review): ValidationResult
    {
        $value = (int)$review->getEntityPkValue();
        $errors = [];

        if (!$value) {
            $errors[] = __('"%field" can not be empty. Add Product ID.', ['field' => ReviewInterface::ENTITY_PK_VALUE]);
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
