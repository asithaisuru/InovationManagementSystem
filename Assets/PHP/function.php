<?php
global $_GlobalRole;

function setRole($role)
{
    $GLOBALS["GlobalRole"] = $role;
}

function logoutSystem()
{
    $GLOBALS["GlobalRole"] = "";
    header("Location: ../../index.php");
}

function checkRole(){
    if ($GLOBALS["GlobalRole"] == 'Innovator') {
        header("Location: ../../Assets/Pages/Innovator/innovator-dashboard.php");
    } else if ($GLOBALS["GlobalRole"] == 'Supplier') {
        header("Location: ../Pages/Supplier/supplier-dashboard.php");
    } else if ($GLOBALS["GlobalRole"] == "Admin") {
        header("Location: ../Pages/Admin/admin-dashboard.php");
    }else{
        header("Location: ../../index.php");
    }
}

