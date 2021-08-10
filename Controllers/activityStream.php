<?php

require_once '../_conf.php';
require_once BASEPATH . 'Classes/Activity.php';
$activityObj = new Activity();
if (isset($_POST['action']) && $_POST['action'] == 'signup') {

    $activityObj->signUpArray = array(
        'US_Name' => $_REQUEST['name'],
        'US_Username' => $_REQUEST['reg-username'],
        'US_Password' => md5($_REQUEST['reg-password']),
        'US_SignUpDate' => date('Y-m-d h:i:s')
    );
    $userDataCount = $activityObj->Existcheck();
    if ($userDataCount == 0) {
        $userId = $activityObj->SignUp();
        if ($userId)
            echo json_encode(array('status' => 1));
        else
            echo json_encode(array('status' => 0));
    }else {
        echo json_encode(array('status' => 2));
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'signin') {
    $activityObj->signInArray = array(
        'US_Username' => $_REQUEST['username'],
        'US_Password' => $_REQUEST['password'],
    );
    $userDetails = $activityObj->Autheticate();
    if ($userDetails) {
        setcookie('usid', $userDetails->US_Id, time() + 3600, '/');
        $loginTime = date('Y-m-d h:i:s');
        $activityObj->activityArray = array(
            'US_Id' => $userDetails->US_Id,
            'AC_LoginTime' => $loginTime
        );
        $userDataCount = $activityObj->SaveLoginTime();
        $activityObj->UpdateLogInTime($userDetails->US_Id, $loginTime);
        echo json_encode(array('status' => 1, 'USID' => $userDetails->US_Id));
    } else {
        echo json_encode(array('status' => 2));
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    if (isset($_COOKIE['usid']) && $_COOKIE['usid'] != "") {
        unset($_COOKIE['usid']);
        setcookie("usid", "", time() - 3600, '/');

        $activityObj->UpdateLogoutStatus($_REQUEST['USID']);
        echo json_encode(array('status' => 1));
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'checkLoginStatus') {
    if (isset($_REQUEST['USID']) && $_REQUEST['USID'] != "") {
        $logoutStatus = $activityObj->checkLogoutStausCheck($_REQUEST['USID']);
        if ($logoutStatus == 1) {
            if (isset($_COOKIE['usid']) && $_COOKIE['usid'] != "") {
                unset($_COOKIE['usid']);
                setcookie("usid", "", time() - 3600, '/');
            }

            echo json_encode(array('status' => 2));
        } else {
            echo json_encode(array('status' => 1));
        }
    }
}
?>