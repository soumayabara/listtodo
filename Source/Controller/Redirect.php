<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function redirectTo($newLocation) {
    header('Location:' . $newLocation);
    exit();
}

function confirmLogin() {
    if ($_SESSION["Email"]) {
        if ((time() - $_SESSION["last_login_timestamp"]) > 1200) {
            redirectTo("logout.php");
        } else {
            $_SESSION["last_login_timestamp"] = time();
        }
        return true;
    } else {
        $_SESSION["ErrorMessage"] = "Login Required";
        redirectTo("Auth.php");
    }
}