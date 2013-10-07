<?php

class Ip_Blogfeed_Model_Backend_Url extends Mage_Core_Model_Config_Data
{

    public function save()
    {
        $frontName = Mage::getConfig()->getNode('frontend/routers/blogfeed/args/frontName');
        $id_path = $frontName.'/list';
        $target_path = $frontName.'/posts/list';
        //delete if already exists
        $exists = Mage::getModel('core/url_rewrite')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->loadByIdPath($id_path);
        if($exists && $exists->getIdPath()){
            $exists->delete();
        }
        //save new
        Mage::getModel('core/url_rewrite')->setIsSystem(0)
            ->setOptions('')
            ->setIdPath($id_path)
            ->setTargetPath($target_path)
            ->setRequestPath($this->getValue())
            ->save();
        return parent::save();
    }

}