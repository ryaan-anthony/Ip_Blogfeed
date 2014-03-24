<?php
$installer = $this;
$installer->startSetup();
$installer->run("
  ALTER TABLE {$installer->getTable('blogfeed/posts')}
  ADD `meta_title` varchar(255)
");
$installer->endSetup();