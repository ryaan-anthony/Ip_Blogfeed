<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$installer->getTable('blogfeed/posts')} 
    ADD COLUMN `meta_title` varchar(255) AFTER `url_key`;
");
$installer->endSetup();