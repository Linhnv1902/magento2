<?php
namespace Linhnv\ChatSystem\Model\ResourceModel\Blacklist;

use \Linhnv\ChatSystem\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'blacklist_id';

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Linhnv\ChatSystem\Model\Blacklist', 'Linhnv\ChatSystem\Model\ResourceModel\Blacklist');
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }

    public function addEmailsToFilter($emails)
    {
        $this->addFieldToFilter('email', ['in' => $emails]);
        return $this;
    }
}
