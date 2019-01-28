<?php
namespace MOBTEXTING\SMS\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use \Magento\Framework\Event\Observer       as Observer;
use \Magento\Framework\View\Element\Context as Context;
use \MOBTEXTING\SMS\Helper\Data                 as Helper;

/*
Custome class for multiselect order status value
*/
class Senderid implements ArrayInterface
{
    public function __construct(
        Context $context,
        Helper $helper
    ) {
        $this->_helper  = $helper;
        $this->_request = $context->getRequest();
        $this->_layout  = $context->getLayout();
    }
    public function toOptionArray()
    {
        $settings = $this->_helper->getSettings();
        $Text = new \MOBTEXTING\SMS\Observer\SMSlocal(false, false, $settings['sms_auth_token'], false);
                      
        $response = $Text->getSenderNames()->sender_names;
        $respons = array();
        foreach ($response as $key => $store) {
                $respons[] = array(
                'value' => $store,
                'label' => $store
                );
        }
        return $respons;
    }
}