<?php

namespace Linhnv\ChatSystem\Ui\Component\Listing\Column;

class ChatRead extends \Magento\Ui\Component\Listing\Columns\Column
{

    protected $helper;
    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory
     * @param \Linhnv\ChatSystem\Helper\Balance\Spend                       $rewardsBalanceSpend
     * @param array                                                        $components
     * @param array                                                        $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Linhnv\ChatSystem\Helper\Data $helper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->helper = $helper;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $fieldName = $this->getData('name');
                if (isset($item['chat_id'])) {
                    $status =  $item['is_read'];

                    if($status == 1) {
                        $item['is_read'] =  __('Unread');
                    } else {
                       $item['is_read'] =  __('Read');
                    }
                }

            }

        }
        return $dataSource;
    }
}
