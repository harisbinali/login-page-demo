<?php
  if (!function_exists('curl_init')) {
    require_once 'lib/purl/Purl.php';
  }
  require_once('config.php');
  require_once('functions.php');
  require_once('pageactions.php');
  require_once('externalactions.php');
?>
<head>
  <title><?php echo CAPTIVE_PORTAL_NAME; ?></title>
</head>
