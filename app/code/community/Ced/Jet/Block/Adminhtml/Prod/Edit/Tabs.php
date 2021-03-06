<?php
/**
  * CedCommerce
  *
  * NOTICE OF LICENSE
  *
  * This source file is subject to the End User License Agreement (EULA)
  * that is bundled with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * http://cedcommerce.com/license-agreement.txt
  *
  * @category    Ced
  * @package     Ced_Jet
  * @author      CedCommerce Core Team <connect@cedcommerce.com >
  * @copyright   Copyright CEDCOMMERCE (http://cedcommerce.com/)
  * @license      http://cedcommerce.com/license-agreement.txt
  */


class Ced_Jet_Block_Adminhtml_Prod_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
  public function __construct()
  {
      parent::__construct();
      $this->setId('form_tabs');
      $this->setDestElementId('edit_form'); // this should be same as the form id define above
      $this->setTitle(Mage::helper('jet')->__('Product Information'));
  }
 
  protected function _beforeToHtml()
  {
      $this->addTab(
          'form_section1', array(
          'label'     => Mage::helper('jet')->__('Product Information'),
          'title'     => Mage::helper('jet')->__('Product Information'),
          'content'   => $this->getLayout()->createBlock('jet/adminhtml_prod_edit_tab_prodform')->toHtml(),
          )
      );
      /*$this->addTab('form_section2', array(
          'label'     => Mage::helper('jet')->__('Shipping Exception'),
          'title'     => Mage::helper('jet')->__('Shipping Exception'),
          'content'   => $this->getLayout()->createBlock('jet/adminhtml_prod_edit_tab_shippingform')->toHtml(),
      ));
      $this->addTab('form_section3', array(
          'label'     => Mage::helper('jet')->__('Return Exception'),
          'title'     => Mage::helper('jet')->__('Return Exception'),
          'content'   => $this->getLayout()->createBlock('jet/adminhtml_prod_edit_tab_returnform')->toHtml(),
      ));*/

        $result=Mage::registry('relationship');
        if(isset($result['relationship']))
          {
              $this->addTab(
                  'form_section4', array(
                  'label'     => Mage::helper('jet')->__('Relationship'),
                  'title'     => Mage::helper('jet')->__('Relationship'),
                  'content'   => $this->getLayout()->createBlock('jet/adminhtml_prod_edit_tab_relationgrid')->toHtml(),
                    )
              );
        }

      return parent::_beforeToHtml();
  }
}
