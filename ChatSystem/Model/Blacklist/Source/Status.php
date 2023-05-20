<?php

declare(strict_types=1);

namespace Linhnv\ChatSystem\Model\Blacklist\Source;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface {

    protected $_blacklist;

    public function __construct(
        \Linhnv\ChatSystem\Model\Blacklist $_blacklist
        ) {
        $this->_blacklist = $_blacklist;
    }

    public function toOptionArray()     {
        $availableOptions = $this->_blacklist->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                "label" => $value,
                "value" => $key
            ];
        }
        return $options;
    }

}
