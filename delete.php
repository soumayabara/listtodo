<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './Source/Database/Connection.php';
require_once './Source/Controller/Session.php';
require_once './Source/Controller/Redirect.php';

if ($_GET['id']) {
    $db = new Connection();
    $db->deletetdl($_GET['id']);
}