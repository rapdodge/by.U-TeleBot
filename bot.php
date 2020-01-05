<?php
define('RA', true);
require_once 'fungsi.php';
require_once 'proses.php';
$entityBody = file_get_contents('php://input');
$message = json_decode($entityBody, true);
prosesApiMessage($message);
?>
