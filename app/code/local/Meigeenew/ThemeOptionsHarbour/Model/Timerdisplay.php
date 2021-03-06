<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsHarbour_Model_Timerdisplay
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('ThemeOptionsHarbour')->__('Hours: Minutes: Seconds')),
            array('value'=>'1', 'label'=>Mage::helper('ThemeOptionsHarbour')->__('Days: Hours: Minutes: Seconds'))
        );
    }

}