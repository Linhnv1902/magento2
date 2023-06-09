<?php
declare(strict_types=1);

namespace Linhnv\ReviewApi\Model;

use Linhnv\ReviewApi\Api\GetProductReviewsInterface;
use Magento\Review\Model\ResourceModel\Review\Product\Collection as ReviewCollection;
use Magento\Review\Model\ResourceModel\Review\Product\CollectionFactory as ReviewCollectionFactory;
use Linhnv\ReviewApi\Model\Converter\Review\ToDataModel as ReviewConverter;

/**
 * Class GetProductReviews load product reviews by product sku
 */
class GetProductReviews implements GetProductReviewsInterface
{
    /**
     * @var ReviewConverter
     */
    private $reviewConverter;

    /**
     * @var ReviewCollectionFactory
     */
    private $reviewCollectionFactory;

    /**
     * GetProductReviews constructor.
     *
     * @param ReviewConverter $reviewConverter
     * @param ReviewCollectionFactory $collectionFactory
     */
    public function __construct(
        ReviewConverter $reviewConverter,
        ReviewCollectionFactory $collectionFactory
    ) {
        $this->reviewConverter = $reviewConverter;
        $this->reviewCollectionFactory = $collectionFactory;
    }

    /**
     * @inheritdoc
     *
     * @param string $sku
     *
     * @return array|\Linhnv\ReviewApi\Api\Data\ReviewInterface[]
     */
    public function execute(string $sku)
    {
        /** @var ReviewCollection $collection */
        $collection = $this->reviewCollectionFactory->create();
        $collection->addStoreData();
        $collection->addFieldToFilter('sku', $sku);
        $collection->addRateVotes();

        $reviews = [];

        /** @var \Magento\Catalog\Model\Product $productReview */
        foreach ($collection as $productReview) {
            $productReview->setCreatedAt($productReview->getReviewCreatedAt());
            $reviewDataObject = $this->reviewConverter->toDataModel($productReview);
            $reviews[] = $reviewDataObject;
        }

        return $reviews;
    }
}
