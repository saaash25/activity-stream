<?php

require_once '../_conf.php';
require_once BASEPATH . 'Classes/Activity.php';
$activityObj = new Activity();
date_default_timezone_set("Asia/Kolkata");
if (isset($_POST['action']) && $_POST['action'] == 'signup') {
    $loginTime = date('Y-m-d h:i:s');
    $activityObj->signUpArray = array(
        'US_Name' => $_REQUEST['name'],
        'US_Username' => $_REQUEST['reg-username'],
        'US_Password' => md5($_REQUEST['reg-password']),
        'US_SignUpDate' => $loginTime
    );
    $userDataCount = $activityObj->Existcheck();
    if ($userDataCount == 0) {
        $userId = $activityObj->SignUp();
        if ($userId) {

            $activityObj->activityArray = array(
                'US_Id' => $userId,
                'AC_ActivityLog' => 'Sign Up on ' . $loginTime,
                'AC_ActivityTime' => $loginTime
            );
            $userDataCount = $activityObj->SaveLoginTime();
            echo json_encode(array('status' => 1));
        } else
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
            'AC_ActivityLog' => 'Logged In at ' . $loginTime,
            'AC_ActivityTime' => $loginTime
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
        $loginTime = date('Y-m-d h:i:s');
        $activityObj->activityArray = array(
            'US_Id' => $_REQUEST['USID'],
            'AC_ActivityLog' => 'Logged Out at ' . $loginTime,
            'AC_ActivityTime' => $loginTime
        );
        $userDataCount = $activityObj->SaveLoginTime();
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
            $loginTime = date('Y-m-d h:i:s');
            $activityObj->activityArray = array(
                'US_Id' => $_REQUEST['USID'],
                'AC_ActivityLog' => 'Session Expired at ' . $loginTime,
                'AC_ActivityTime' => $loginTime
            );
            $userDataCount = $activityObj->SaveLoginTime();
            echo json_encode(array('status' => 2));
        } else {
            echo json_encode(array('status' => 1));
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'activityListing') {
    setcookie('actLength', $_REQUEST['length'], 0, '/; samesite=strict');
    $where = " AND US_Id='" . $_REQUEST['USID'] . "'";
    $activityObj->activityListing($where);
    $activitys = $activityObj->Activity;
    $i = $_REQUEST['start'] + 1;

    $totalCount = count($activitys);
    $filterCount = count($activitys);
    $activityObj->Activity = [];
    if ($_REQUEST['start'] >= 0 && $_REQUEST['length'] != -1) {
        $Limit = " LIMIT " . $_REQUEST['start'] . ", " . $_REQUEST['length'];
    }

    $activityObj->activityListing($where, $Limit);
    $activitys = $activityObj->Activity;
    foreach ($activitys as $key => $val) {
        $val->SLNO = $i;
        $date1 = date_create(date('Y-m-d', strtotime($val->AC_ActivityTime)));
        $date2 = date_create(date('Y-m-d'));

        $diff = date_diff($date1, $date2)->days;
        if ($diff == 0) {
            $val->AddedDate = date('h:i:s', strtotime($val->AC_ActivityTime));
        } else {
            $val->AddedDate = date('d-M-Y , h:i:s', strtotime($val->AC_ActivityTime));
        }

        $i++;
    }

    $results = ["draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalCount,
        "recordsFiltered" => $filterCount,
        "data" => $activitys];
    echo json_encode($results);
} else if (isset($_POST['action']) && $_POST['action'] == 'menuAdd') {
    $menu = $_REQUEST['menu'];
    $usid = $_REQUEST['USID'];
    $addTime = date('Y-m-d h:i:s');
    $activityObj->menuArray = array(
        'MN_Name' => htmlspecialchars($menu, ENT_QUOTES),
        'US_Id' => $usid,
        'MN_AddedTime' => $addTime
    );
    $menuId = $activityObj->MenuSave();
    if ($menuId) {
        $activityObj->activityArray = array(
            'US_Id' => $usid,
            'AC_ActivityLog' => 'New Menu ' . htmlspecialchars($menu, ENT_QUOTES) . ' Added  at ' . $addTime,
            'AC_ActivityTime' => $addTime
        );
        $userDataCount = $activityObj->SaveLoginTime();
        echo json_encode(array('status' => 1));
    } else {
        echo json_encode(array('status' => 2));
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'menuListing') {
    setcookie('menuLength', $_REQUEST['length'], 0, '/; samesite=strict');
    $where = " AND US_Id='" . $_REQUEST['USID'] . "'";
    $activityObj->menuListing($where);
    $menuData = $activityObj->Menus;
    $i = $_REQUEST['start'] + 1;

    $totalCount = count($menuData);
    $filterCount = count($menuData);
    $activityObj->Menus = [];
    if ($_REQUEST['start'] >= 0 && $_REQUEST['length'] != -1) {
        $Limit = " LIMIT " . $_REQUEST['start'] . ", " . $_REQUEST['length'];
    }

    $activityObj->menuListing($where, $Limit);
    $menuData = $activityObj->Menus;
    foreach ($menuData as $key => $val) {
        $val->SLNO = $i;
        $i++;
    }
    $results = ["draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalCount,
        "recordsFiltered" => $filterCount,
        "data" => $menuData];
    echo json_encode($results);
} else if (isset($_POST['action']) && $_POST['action'] == 'menuDelete') {
    $where = " AND MN_Id='" . $_REQUEST['MNID'] . "'";
    $MN_Name=$_REQUEST['MN_Name'];
    $usid = $_REQUEST['USID'];
    $activityObj->menuDelete($where);
    $deleteId = $activityObj->deleteId;
    $deleteTime = date('Y-m-d h:i:s');
    if ($deleteId) {
        $activityObj->activityArray = array(
            'US_Id' => $usid,
            'AC_ActivityLog' => 'Menu ' . htmlspecialchars($MN_Name, ENT_QUOTES) . ' Deleted  at ' . $deleteTime,
            'AC_ActivityTime' => $deleteTime
        );
        $userDataCount = $activityObj->SaveLoginTime();
        echo json_encode(array('status' => 1));
    } else {
        echo json_encode(array('status' => 2));
    }
}
else if (isset($_POST['action']) && $_POST['action'] == 'getMenuData') {
     $where = " AND MN_Id='" . $_REQUEST['MNID'] . "'";
     $menuData = $activityObj->getMenuData($where);
     echo json_encode(array('data' => $menuData));
}
else if (isset($_POST['action']) && $_POST['action'] == 'menuUpdate') {
    $where = " MN_Id='" . $_REQUEST['MNID'] . "'";
    $MN_Name=$_REQUEST['MN_Name'];
    $menu = $_REQUEST['menu'];
    $usid = $_REQUEST['USID'];
    $updateTime = date('Y-m-d h:i:s');
    $activityObj->menuArray = array(
        'MN_Name' => htmlspecialchars($menu, ENT_QUOTES),
    );
    $menuId = $activityObj->menuUpdate($where);
    if ($menuId) {
        $activityObj->activityArray = array(
            'US_Id' => $usid,
            'AC_ActivityLog' => 'Menu name updated from ' . htmlspecialchars($MN_Name, ENT_QUOTES) . ' to  at ' . htmlspecialchars($menu, ENT_QUOTES) .' at '.  $updateTime,
            'AC_ActivityTime' => $updateTime
        );
        $userDataCount = $activityObj->SaveLoginTime();
        echo json_encode(array('status' => 1));
    } else {
        echo json_encode(array('status' => 2));
    }
}
?>