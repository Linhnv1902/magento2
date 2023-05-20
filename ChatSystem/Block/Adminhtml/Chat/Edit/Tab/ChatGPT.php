<?php

namespace Linhnv\ChatSystem\Block\Adminhtml\Chat\Edit\Tab;

class ChatGPT extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    protected $_template = 'Linhnv_ChatSystem::chat/chatgpt.phtml';

    protected $_columnDate = 'main_table.created_at';

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    protected $authSession;

    protected $messsage;

    protected $_chatModelFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Linhnv\ChatSystem\Model\ChatMessage $messsage,
        \Linhnv\ChatSystem\Model\ChatFactory $chatModelFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $registry;
        $this->formKey   = $context->getFormKey();
        $this->authSession = $authSession;
        $this->messsage = $messsage;
        $this->_chatModelFactory = $chatModelFactory;
    }

    public function getCurrentChat() {
        return $this->_coreRegistry->registry('linhnvchatsystem_chat');
    }
    public function getFormKey() {
        return $this->formKey->getFormKey();
    }

    public function getUser() {
        $user = $this->authSession->getUser();
        return $user;
    }
    public function isRead() {
//        $chat = $this->_chatModelFactory->create()->load($this->getCurrentChat()->getData('chat_id'));
//        //$messsage = $objectManager->create('Linhnv\ChatSystem\Model\ChatMessage')->load()->getCollection();
//        $messsage = $this->messsage->getCollection()->addFieldToFilter('chat_id',$this->getCurrentChat()->getData('chat_id'))->addFieldToFilter('is_read',1);
//        foreach ($messsage as $key => $_messsage) {
//            $_messsage->setData('is_read',0)->save();
//        }
//
//        $chat->setData('is_read',0)->save();

        return;
    }
}
