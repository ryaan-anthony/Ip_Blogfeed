<?php

class Ip_Blogfeed_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function makeUrlKey($title)
    {
        return str_replace(' ','-',
            preg_replace("/[^0-9a-zA-Z ]/", "",
                strtolower(trim($title))
            )
        );
    }

    public function getTimestamp($_post)
    {
        return $this->formattedTime($_post->getTimestamp());
    }

    public function getDate($_post)
    {
        return $this->formattedTime($_post->getDate());
    }

    protected function formattedTime($time)
    {
        return date('F jS, Y', strtotime($time));
    }

    public function filter($content)
    {
        $_processor = Mage::helper('cms')->getBlockTemplateProcessor();
        return $_processor->filter($content);
    }


}