<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author admin
 */
class User {
    //put your code here
    private $Fullname;
    private $Username;
    private $Email;
    private $Password;
    
    function __construct($Fullname, $Username, $Email, $Password) {
        $this->Fullname = $Fullname;
        $this->Username = $Username;
        $this->Email = $Email;
        $this->Password = $Password;
    }

    function getFullname() {
        return $this->Fullname;
    }

    function getUsername() {
        return $this->Username;
    }

    function getEmail() {
        return $this->Email;
    }

    function getPassword() {
        return $this->Password;
    }

    function setFullname($Fullname) {
        $this->Fullname = $Fullname;
    }

    function setUsername($Username) {
        $this->Username = $Username;
    }

    function setEmail($Email) {
        $this->Email = $Email;
    }

    function setPassword($Password) {
        $this->Password = $Password;
    }



    
    
}
