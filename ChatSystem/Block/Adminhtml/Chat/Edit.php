<?php
namespace Linhnv\ChatSystem\Block\Adminhtml\Chat;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize cms page edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'chat_id';
        $this->_blockGroup = 'Linhnv_ChatSystem';
        $this->_controller = 'adminhtml_chat';
        parent::_construct();
        $chat_id = $this->_coreRegistry->registry('linhnvchatsystem_chat')->getId();
        $this->buttonList->remove('save');
        $this->buttonList->remove('reset');
        $this->buttonList->add(
                    'blacklist',
                    [
                        'label' => __('Add to Blacklist'),
                        'class' => 'save primary',
                        'onclick' => 'setLocation(\'' . $this->getUrl('linhnvchatsystem/*/addBlacklist', ["chat_id"=>(int)$chat_id]) . '\')'
                    ]

        );

        //$this->buttonList->add(
                    //'close_chat',
                    //[
                        //'label' => __('Close Chat'),
                        //'class' => 'save primary',
                        //'onclick' => 'setLocation(\'' . $this->getUrl('linhnvchatsystem/*/closechat') . '\')'
                    //]

        //);



    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('linhnvchatsystem_chat')->getId()) {
            return __("Edit Chat '%1'", $this->escapeHtml($this->_coreRegistry->registry('linhnvchatsystem_chat')->getTitle()));
        } else {
            return __('New Chat');
        }
    }

    /**
     * Check chat for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            };
        ";
        return parent::_prepareLayout();
    }
}
