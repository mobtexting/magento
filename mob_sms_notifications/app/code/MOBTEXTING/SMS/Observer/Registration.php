<?php

namespace MOBTEXTING\SMS\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer as Observer;
use \Magento\Framework\View\Element\Context as Context;
use \MOBTEXTING\SMS\Helper\Data as Helper;

/**
 * Customer login observer
 */
class Registration implements ObserverInterface
{
    /**
     * Message manager
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    const AJAX_PARAM_NAME = 'infscroll';
    /**
     *
     */
    const AJAX_HANDLE_NAME = 'infscroll_ajax_request';

    /**
     * Https request
     *
     * @var \Zend\Http\Request
     */
    protected $_request;

    /**
     * Layout Interface
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    /**
     * Cache
     * @var $_cache
     */
    protected $_cache;

    /**
     * Helper for SmsnotificationsSMS Module
     * @var \MOBTEXTING\SMS\Helper\Data
     */
    protected $_helper;

    /**
     * Message Manager
     * @var $messageManager
     */
    protected $messageManager;

    /**
     * Username
     * @var $username
     */
    protected $username;

    /**
     * Password
     * @var $password
     */
    protected $password;

    /**
     * Sender ID
     * @var $senderId
     */
    protected $senderId;

    /**
     * Destination
     * @var $destination
     */
    protected $destination;

    /**
     * Message
     * @var $message
     */
    protected $message;

    /**
     * Whether Enabled or not
     * @var $enabled
     */
    protected $enabled;

    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper _helper
     */
    public function __construct(
        Context $context,
        Helper $helper
    )
    {
        $this->_helper = $helper;
        $this->_request = $context->getRequest();
        $this->_layout = $context->getLayout();
    }

    /**
     * The execute class
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $settings = $this->_helper->getSettings();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');

        if (!empty($_POST['telephone'])) {
            $telephone = $_POST['telephone'];

            $text = $settings['customer_register'];
            if (!$text) {
                return true;
            }

            $admin_recipients[] = $settings['admin_recipients'];

            array_push($admin_recipients, $telephone);

            $object_manager = \Magento\Framework\App\ObjectManager::getInstance();
            $result = $object_manager->get('MOBTEXTING\SMS\Helper\Data')->sendSms($text, $admin_recipients);
        }

        return true;
    }

}
    
