<?php
require_once '_conf.php';
require_once BASEPATH . 'Classes/Activity.php';
$activityObj = new Activity();
if ($_COOKIE['USID']) {
    $logoutStatus = $activityObj->checkLogoutStausCheck($_COOKIE['USID']);
    if ($logoutStatus == 1) {
         unset($_COOKIE['USID']);
    }
}
?>