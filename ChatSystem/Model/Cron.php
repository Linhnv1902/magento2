<?php
namespace Linhnv\ChatSystem\Model;

use Magento\Cron\Model\Schedule;

class Cron
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    protected $helper;

    protected $chatmessageFactory;

    protected $_date;

    public function __construct(
        ChatMessageFactory $chatmessageFactory,
        \Linhnv\ChatSystem\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    )
    {
        $this->chatmessageFactory = $chatmessageFactory;
        $this->logger = $logger;
        $this->helper = $helper;
        $this->_date = $date;
    }

    /**
     * Clean expired quotes (cron process)
     *
     * @return void
     */
    public function execute()
    {
        $this->cleanMessageLogs();
    }

    public function cleanMessageLogs()
    {
        $collection = $this->chatmessageFactory->create()->getCollection();
        $enable_clean_log = $this->helper->getConfig("system/enable_clean_log");
        $clean_older_day = $this->helper->getConfig("system/clean_older_day");
        if($clean_older_day && $enable_clean_log){
            $current_date = $this->_date->gmtDate();
            $currentDateTime = strtotime($current_date);
            $clean_older_day = '- '.(int)$clean_older_day.' days';//2021-05-20 04:35:35
            $olderDate = date('Y-m-d H:i:s',strtotime($clean_older_day, $currentDateTime));
            $collection->addFieldToFilter('created_at', ['lteq' => $olderDate]);

            $totals = $collection->count();
            if($totals){
                foreach ($collection as $key => $model) {
                    $model->delete();
                }
            }
        }
    }
}
