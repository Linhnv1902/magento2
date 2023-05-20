<?php

namespace Linhnv\ChatSystem\Block\Chat;

class Chat extends \Magento\Framework\View\Element\Template
{
     /**
     *
     * @var int
     */
    private $_username = - 1;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $_customerSession;
    /**
     *
     * @var \Linhnv\ChatSystem\Model\ChatFactory
     */
    protected $chat;
     /**
     *
     * @var \Linhnv\ChatSystem\Helper\Data
     */
    protected $helper;
    /**
     *
     * @var \Magento\Customer\Model\Url
     */
    protected $_customerUrl;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Linhnv\ChatSystem\Helper\Url $customerUrl,
        \Linhnv\ChatSystem\Helper\Data $helper,
        \Linhnv\ChatSystem\Model\ChatFactory $chatFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->chat = $chatFactory;
        $this->_customerSession  = $customerSession;
        $this->_customerUrl = $customerUrl;
        parent::__construct($context, $data);
    }

    public function _toHtml()
	{
		if($this->helper->getConfig("general_settings/enable")){
            return parent::_toHtml();
        }
        return;
    }

    public function isLogin()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return true;
        }
        return false;
    }

    public function getChatId()
    {
        return $this->helper->getChatId($this->chat);
    }

    public function getCurrentUrl()
    {
        return $this->_urlBuilder->getCurrentUrl();
    }

    public function getCustomerSession()
    {
        return $this->_customerSession;
    }
    public function getCustomer()
    {
        return $this->getCustomerSession()->getCustomer();
    }
     /**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getPostActionUrl() {
        $post_action_url = $this->_customerUrl->getLoginPostUrl ();
        $post_action_url = str_replace("/linhnvchatsystem/","/", $post_action_url);
        return $post_action_url;
    }

    /**
     * Retrieve password forgotten url
     *
     * @return string
     */
    public function getForgotPasswordUrl() {
        return $this->_customerUrl->getForgotPasswordUrl ();
    }


    public function getRegisterUrl() {
        return $this->_customerUrl->getRegisterUrl ();
    }
    /**
     * Retrieve username for form field
     *
     * @return string
     */
    public function getUsername() {
        if (- 1 === $this->_username) {
            $this->_username = $this->_customerSession->getUsername ( true );
        }
        return $this->_username;
    }

    /**
     * Check if autocomplete is disabled on storefront
     *
     * @return bool
     */
    public function isAutocompleteDisabled() {
        return ( bool ) ! $this->_scopeConfig->getValue ( \Magento\Customer\Model\Form::XML_PATH_ENABLE_AUTOCOMPLETE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
    }
}
