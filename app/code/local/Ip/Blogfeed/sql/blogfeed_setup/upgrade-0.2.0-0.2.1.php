<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$installer->getTable('blogfeed/posts')} 
    ADD COLUMN `featured_image` varchar(255);
");
$installer->endSetup();