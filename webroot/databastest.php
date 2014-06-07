<?php
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php';

$db = new \Mos\Database\CDatabaseBasic();
$options = require "config_mysql.php";
$db->setOptions($options);
$db->connect();

$db->setVerbose(true);  // Set verbose mode to on



$sql = "
SELECT
    *
FROM News
ORDER BY id ASC
;";
$db->execute($sql);

$db->select()
    ->from('News')
    ->orderBy("id ASC")
;
$db->execute();