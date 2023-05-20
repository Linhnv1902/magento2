<?php
namespace Linhnv\ChatSystem\Model\ResourceModel\ChatMessage;

use \Linhnv\ChatSystem\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'message_id';
    /**
     * Define resource model
     *
     * @return void
     */

     /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        //$this->performAfterLoad('linhnv_chatsystem_category_store', 'category_id');
        // $this->getProductsAfterLoad();
        return parent::_afterLoad();
    }


    protected function _construct()
    {
        $this->_init('Linhnv\ChatSystem\Model\ChatMessage', 'Linhnv\ChatSystem\Model\ResourceModel\ChatMessage');
    }

      /**
     * Returns pairs category_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('message_id', 'title');
    }
    /**
     * Add link attribute to filter.
     *
     * @param string $code
     * @param array $condition
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }
}
