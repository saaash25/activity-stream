<?php

require_once 'Connection.php';

class Activity {

    function Existcheck() {
        GLOBAL $con;
        $this->SQL = "SELECT COUNT(US_Id) AS COUNT FROM users WHERE 1 AND US_Username='" . $this->signUpArray["US_Username"] . "'";

        $result = mysqli_query($con, $this->SQL);
        $row = mysqli_fetch_object($result);
        mysqli_free_result($result);
        return $this->COUNT = $row->COUNT;
    }

    function SignUp() {
        GLOBAL $con;
        $this->SQL = "INSERT INTO users ( " . implode(', ', array_keys($this->signUpArray)) . ") VALUES (" . "'" . implode("','", array_values($this->signUpArray)) . "'" . ")";

        $result = mysqli_query($con, $this->SQL);
        return $this->USId = mysqli_insert_id($con);
    }

    function Autheticate() {
        GLOBAL $con;
        $this->SQL = "SELECT US_Id,US_Username,US_LastLoginTime FROM users WHERE 1 AND US_Username='" . trim($this->signInArray["US_Username"]) . "' AND US_Password='" . trim(md5($this->signInArray["US_Password"])) . "'";
        $result = mysqli_query($con, $this->SQL);
        $row = mysqli_fetch_object($result);
        mysqli_free_result($result);
        return $this->UserDetails = $row;
    }

    function SaveLoginTime() {
        GLOBAL $con;
        $this->SQL = "INSERT INTO activity_history ( " . implode(', ', array_keys($this->activityArray)) . ") VALUES (" . "'" . implode("','", array_values($this->activityArray)) . "'" . ")";

        $result = mysqli_query($con, $this->SQL);
        return $this->ACID = mysqli_insert_id($con);
    }

    function UpdateLogInTime($USID, $loginTime) {
        GLOBAL $con;
        $this->SQL = "UPDATE users SET US_LastLoginTime='" . $loginTime . "',US_LogoutStatus='0' WHERE 1 AND US_Id='" . $USID . "'";
        $result = mysqli_query($con, $this->SQL);
    }

    function UpdateLogoutStatus($USID) {
        GLOBAL $con;
        $this->SQL = "UPDATE users SET US_LogoutStatus='1' WHERE 1 AND US_Id='" . $USID . "'";
        $result = mysqli_query($con, $this->SQL);
    }

    function checkLogoutStausCheck($US_Id) {
        GLOBAL $con;
        $this->SQL = "SELECT US_LogoutStatus FROM users WHERE 1 AND US_Id='" . $US_Id . "'";
        $result = mysqli_query($con, $this->SQL);
        $row = mysqli_fetch_object($result);
        mysqli_free_result($result);
        return $this->US_LogoutStatus = $row->US_LogoutStatus;
    }

    function activityListing($where, $Limit = "") {
        GLOBAL $con;
        $this->SQL = "SELECT *  FROM activity_history WHERE 1 " . $where . " ORDER BY AC_Id DESC " . $Limit;
        $result = mysqli_query($con, $this->SQL);
        if ($result->num_rows) {
            while ($row[] = mysqli_fetch_object($result));
            mysqli_free_result($result);
            $this->Activity = array_filter($row);
        } else {
            $this->Activity = [];
        }
        return $this->Activity;
    }

    function MenuSave() {
        GLOBAL $con;
        $this->SQL = "INSERT INTO menus ( " . implode(', ', array_keys($this->menuArray)) . ") VALUES (" . "'" . implode("','", array_values($this->menuArray)) . "'" . ")";
        $result = mysqli_query($con, $this->SQL);
        return $this->MNID = mysqli_insert_id($con);
    }

    function menuListing($where, $Limit = "") {
        GLOBAL $con;
        $this->SQL = "SELECT *  FROM menus WHERE 1 " . $where . " ORDER BY MN_Id DESC " . $Limit;
        $result = mysqli_query($con, $this->SQL);
        if ($result->num_rows) {
            while ($row[] = mysqli_fetch_object($result));
            mysqli_free_result($result);
            $this->Menus = array_filter($row);
        } else {
            $this->Menus = [];
        }
        return $this->Menus;
    }

    function menuDelete($where) {
        GLOBAL $con;
        $this->SQL = "DELETE  FROM menus WHERE 1 " . $where;
        $result = mysqli_query($con, $this->SQL);
        return $this->deleteId = $result;
    }

    function menuUpdate($where) {
        GLOBAL $con;
        $menuData='';
        foreach ($this->menuArray as $key => $value) {
            $menuData = $menuData . $key . "='" . $value . "', ";
        }
        $menuData = substr($menuData, 0, -2);

        $this->SQL = "UPDATE menus SET $menuData WHERE " . $where;
        $result = mysqli_query($con, $this->SQL);
        return $this->mnId = $result;
    }

    function getMenuData($where) {
        GLOBAL $con;
        $this->SQL = "SELECT *  FROM menus WHERE 1 " . $where;
        $result = mysqli_query($con, $this->SQL);
        if ($result->num_rows) {
            while ($row[] = mysqli_fetch_object($result));
            mysqli_free_result($result);
            $this->Menus = array_filter($row);
        } else {
            $this->Menus = [];
        }
        return $this->Menus;
    }

}

?>