<?php
namespace Linhnv\ChatSystem\Model\Config\Source;

class EmailTemplate extends \Magento\Config\Model\Config\Source\Email\Template
{

  /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        array_unshift(
            $options,
            [
                 'value' => 'none',
                 'label' => __('- Disable these emails -'),
            ]
        );

        return $options;
    }
}
