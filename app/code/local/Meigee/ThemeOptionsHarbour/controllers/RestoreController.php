<?php
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsHarbour_RestoreController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
     $this->loadLayout(array('default'));

         $this->_addLeft($this->getLayout()
                ->createBlock('core/text')
                ->setText('
                    <h5>Predefined pages:</h5>
                    <ul>
                        <li>home</li>
						<li>home2</li>
						<li>home3</li>
						<li>home4</li>
						<li>home5</li>
						<li>no-route</li>
                    </ul><br />
                    <h5>Predefined static blocks:</h5>
                    <ul>
                        <li>harbour_footer</li>
						<li>harbour_footer2</li>
						<li>harbour_footer3</li>
						<li>harbour_product_custom</li>
						<li>harbour_product_banner</li>
						<li>harbour_sidebar_banner</li>
						<li>harbour_popup_content</li>
						<li>harbour_contact_map_block</li>
						<li>harbour_header2_text_banners</li>
						<li>new_arrivals</li>
						<li>bags</li>
						<li>hoodies</li>
						<li>harbour_phones</li>
						<li>harbour_right_menu</li>
						<li>harbour_header5_text_banner</li>
                    </ul><br />
                    <strong style="color:red;">To get more info regarding these blocks please read documentation that comes with this theme.</strong>'));
		$this->_addContent($this->getLayout()->createBlock('themeoptionsharbour/adminhtml_restore_edit'));
		$this->renderLayout();


    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
        	
        $stores = $this->getRequest()->getParam('stores', array(0));
        $setup_package = $this->getRequest()->getParam('setup_package', 0);
        $this->_clear = $this->getRequest()->getParam('clear_scope', false);
        $setup_pages = $this->getRequest()->getParam('setup_pages', 0);
        $setup_blocks = $this->getRequest()->getParam('setup_blocks', 0);

        if ($this->_clear) {
            if ( !in_array(0, $this->_stores) )
                $stores[] = 0;
        }

        try {
            foreach ($stores as $store) {
                $scope = ($store ? 'stores' : 'default');
                Mage::getConfig()->saveConfig('design/header/logo_src', 'images/logo.gif', $scope, $store);
                Mage::getConfig()->saveConfig('design/footer/copyright', '<a href="https://meigeeteam.com" title="MeigeeTeam">Meigee</a> &copy; 2015 <a href="https://meigeeteam.com/magento-themes" title="Magento Themes">Magento Themes</a>', $scope, $store);

                if ($setup_package) {
                    Mage::getConfig()->saveConfig('design/package/name', 'default', $scope, $store);
                }
            }
            $defaults = new Varien_Simplexml_Config();
            $defaults->loadFile(Mage::getBaseDir().'/app/code/local/Meigee/ThemeOptionsHarbour/etc/config.xml');

            $this->_restoreSettings($defaults->getNode('default/meigee_harbour_general')->children(), 'meigee_harbour_general');
            $this->_restoreSettings($defaults->getNode('default/meigee_harbour_general')->children(), 'meigee_harbour_productpage');
            $this->_restoreSettings($defaults->getNode('default/meigee_harbour_general')->children(), 'meigee_harbour_sidebar');

            if ($setup_pages) {
                Mage::getModel('ThemeOptionsHarbour/restore')->setupPages();
            }

            if ($setup_blocks) {
                Mage::getModel('ThemeOptionsHarbour/restore')->setupBlocks();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('ThemeOptionsHarbour')->__('Default settings has been restored. Please clear all the cache (System > Cache management)'));
        
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ThemeOptionsHarbour')->__('An error occurred while restoring theme. '.$e->getMessage()));
        }

        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
        }
    }

    private function _restoreSettings($items, $path)
    {
        $websites = Mage::app()->getWebsites();
        $stores = Mage::app()->getStores();
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->_restoreSettings($item->children(), $path.'/'.$item->getName());
            } else {
                if ($this->_clear) {
                    Mage::getConfig()->deleteConfig($path.'/'.$item->getName());
                    foreach ($websites as $website) {
                        Mage::getConfig()->deleteConfig($path.'/'.$item->getName(), 'websites', $website->getId());
                    }
                    foreach ($stores as $store) {
                        Mage::getConfig()->deleteConfig($path.'/'.$item->getName(), 'stores', $store->getId());
                    }
                }
                foreach ($this->_stores as $store) {
                    $scope = ($store ? 'stores' : 'default');
                    Mage::getConfig()->saveConfig($path.'/'.$item->getName(), (string)$item, $scope, $store);
                }
            }
        }
    }
}