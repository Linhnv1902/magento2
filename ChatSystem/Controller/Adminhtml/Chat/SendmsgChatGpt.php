<?php
namespace Linhnv\ChatSystem\Controller\Adminhtml\Chat;

use GuzzleHttp\Exception\GuzzleException;
use Linhnv\ChatSystem\Helper\Data;
use Linhnv\ChatSystem\Model\BlacklistFactory;
use Linhnv\ChatSystem\Model\ChatFactory;
use Linhnv\ChatSystem\Model\ChatMessage;
use Linhnv\ChatSystem\Model\Sender;
use Magecomp\Chatgptaicontent\Model\CompletionConfig;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Linhnv\ChatSystem\Model\ChatGPT\V2 as ChatGPTV2;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManager;

/**
 * Display Hello on screen
 */
class SendmsgChatGpt extends Action
{
    protected $_cacheTypeList;
    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var ResponseInterface
     */
    protected $_response;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    protected $_message;

    protected $_chat;

    protected $sender;

    protected $_chatModelFactory;

    protected $httpRequest;

    /**
     * @var RemoteAddress
     */
    protected $remoteAddress;

    protected $blacklistFactory;

    /**
     * @var StoreManager
     */
    protected $storeManager;
    private CompletionConfig $completionConfig;
    public function __construct(
        Context $context,
        StoreManager $storeManager,
        PageFactory $resultPageFactory,
        Data $helper,
        ChatMessage $message,
        Sender $sender,
        ForwardFactory $resultForwardFactory,
        Registry $registry,
        TypeListInterface $cacheTypeList,
        Session $customerSession,
        ChatFactory $chatModelFactory,
        RemoteAddress $remoteAddress,
        Http $httpRequest,
        CompletionConfig $completionConfig,
        BlacklistFactory $blacklistFactory
    ) {
        $this->sender = $sender;
        $this->resultPageFactory    = $resultPageFactory;
        $this->_helper              = $helper;
        $this->_message             = $message;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_request             = $context->getRequest();
        $this->_chatModelFactory    = $chatModelFactory;
        $this->httpRequest          = $httpRequest;
        $this->remoteAddress        = $remoteAddress;
        $this->blacklistFactory     = $blacklistFactory;
        $this->storeManager = $storeManager;
        $this->completionConfig=$completionConfig;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return Page
     * @throws GuzzleException
     */
    public function execute()
    {
        $data = $this->_request->getPostValue();
        $chatGPT = new ChatGPTV2('eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1UaEVOVUpHTkVNMVFURTRNMEZCTWpkQ05UZzVNRFUxUlRVd1FVSkRNRU13UmtGRVFrRXpSZyJ9.eyJodHRwczovL2FwaS5vcGVuYWkuY29tL3Byb2ZpbGUiOnsiZW1haWwiOiJsaW5obnZAbWFnZXBsYXphLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlfSwiaHR0cHM6Ly9hcGkub3BlbmFpLmNvbS9hdXRoIjp7InVzZXJfaWQiOiJ1c2VyLXY2MHFFV3NNTW5hc2lHeGxhMWl4ODhETyJ9LCJpc3MiOiJodHRwczovL2F1dGgwLm9wZW5haS5jb20vIiwic3ViIjoiZ29vZ2xlLW9hdXRoMnwxMTQzMjczNTMxODU4MTM3MTI0NzYiLCJhdWQiOlsiaHR0cHM6Ly9hcGkub3BlbmFpLmNvbS92MSIsImh0dHBzOi8vb3BlbmFpLm9wZW5haS5hdXRoMGFwcC5jb20vdXNlcmluZm8iXSwiaWF0IjoxNjgxMTIyMDUxLCJleHAiOjE2ODIzMzE2NTEsImF6cCI6IlRkSkljYmUxNldvVEh0Tjk1bnl5d2g1RTR5T282SXRHIiwic2NvcGUiOiJvcGVuaWQgcHJvZmlsZSBlbWFpbCBtb2RlbC5yZWFkIG1vZGVsLnJlcXVlc3Qgb3JnYW5pemF0aW9uLnJlYWQgb2ZmbGluZV9hY2Nlc3MifQ.sOkRGauU_oku--IGG2nAecTkbFO97No89HT6j25RBrdOrafBAuo-Pyr1pfP6X27lL1neYGem76t3U7uXeFi4VnHKBsW23sAyx2L7iltE8abcl2xfWNfrhmAsFIAWGF4hh9qR0tVLB4k-XPjWeOyrntUbnvXsYpycQsFyKIossejIkuff0EjomRaz4q1LM8HRap0Zi2rugnz7rHRWT7S6QAb4j3rDec0wjt0gP9zQebVzyMs3Fkh1b1L1r8v3WL_rlj_pt_FZH7-k-XIvLOKGDcuNmT_IC1g6g3vzBDC5iLvHXLRVC3cbkQTS7oMxoKdJ0QEl3kP1kOt6g7pgn1WJqg');
        $answers = $chatGPT->ask('Hello, how are you?', null, true);
//        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
//        $response->setHeader('Content-type', 'text/plain');
//        $response = $response->setData([
//                'answer' => $answer['answer']
//            ]);
//
//        return $response;


    }
}
