<?php
namespace Linhnv\ChatSystem\Controller\Adminhtml\Chat;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Display Hello on screen
 */
class Sendmsg extends \Magento\Framework\App\Action\Action
{
    protected $_cacheTypeList;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Linhnv\ChatSystem\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    protected $_message;

    protected $sender;

    protected $_chatModelFactory;

    protected $authSession;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Linhnv\ChatSystem\Helper\Data $helper,
        \Linhnv\ChatSystem\Model\ChatMessage $message,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Linhnv\ChatSystem\Model\Sender $sender,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Model\Session $customerSession,
        \Linhnv\ChatSystem\Model\ChatFactory $chatModelFactory,
        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        $this->resultPageFactory    = $resultPageFactory;
        $this->_helper              = $helper;
        $this->_message             = $message;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry        = $registry;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_customerSession     = $customerSession;
        $this->_request             = $context->getRequest();
        $this->sender = $sender;
        $this->_chatModelFactory = $chatModelFactory;
        $this->authSession  = $authSession;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $data = $this->_request->getPostValue();
        $data['current_time'] = $this->_helper->getCurrentTime();
        $data = $this->_helper->xss_clean_array($data);
        if(!empty($data)){
            $responseData = [];
            $message = $this->_message;

            try{
                $user_id = $this->getUser()->getData('user_id');
                $user_name = $this->getUser()->getData('firstname').' '.$this->getUser()->getData('lastname');
                if(!isset($data['user_name']) || ($data['user_name'] != $user_name)){
                    $data['user_name'] = $user_name;
                }
                if(!isset($data['user_id']) || ($data['user_id'] != $user_id)){
                    $data['user_id'] = $user_id;
                }
                $message->setData($data)->save();
                $chat = $this->_chatModelFactory->create()->load($data['chat_id']);
                $number_message = $chat->getData('number_message') + 1;
                $chat
                    ->setUserName($data['user_name'])
                    ->setData("user_id", (int)$data['user_id'])
                    ->setData('is_read',3)
                    ->setData('answered',0)
                    ->setData('number_message',$number_message)
                    ->save();
                $this->_cacheTypeList->cleanType('full_page');
                if($data['customer_name'] && $this->_helper->getConfig('email_settings/enable_email')) {
                    $data['url'] = $this->_helper->getUrl();
                    $this->sender->sendAdminChat($data);
                }
            }catch(\Exception $e){
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                return;
            }
        }
    }
    protected function getUser() {
        $user = $this->authSession->getUser();
        return $user;
    }
}