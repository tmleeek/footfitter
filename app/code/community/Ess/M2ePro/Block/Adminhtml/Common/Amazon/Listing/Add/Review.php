<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Block_Adminhtml_Common_Amazon_Listing_Add_Review
    extends Ess_M2ePro_Block_Adminhtml_Common_Listing_Add_Review
{
    //########################################

    public function __construct()
    {
        parent::__construct();

        // Initialization block
        // ---------------------------------------
        $this->setId('listingProductReview');
        $this->setData('component', Ess_M2ePro_Helper_Component_Amazon::NICK);
        // ---------------------------------------

        $this->_headerText = Mage::helper('M2ePro')->__('Congratulations');

        $this->setTemplate('M2ePro/common/amazon/listing/add/review.phtml');
    }

    //########################################
}