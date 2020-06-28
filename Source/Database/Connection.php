<?php

require_once './Source/Model/User.php';
require_once './Source/Controller/Redirect.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connection
 *
 * @author admin
 */
class Connection {

//put your code here
    private $DB_SERVER = 'localhost';
    private $DB_NAME = 'todolistvsoumaya';
    private $DB_USER = 'root';
    private $DB_PASSWORD = '';
    private $Connection;

    public function __construct() {
        try {
            $DSN = "mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_NAME;
            $this->Connection = new PDO($DSN, $this->DB_USER, $this->DB_PASSWORD);
            $this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo 'Connected Successfully :)';
        } catch (PDOException $exception) {
            die('Oop\'s Something wrong when we trying connecting the app to the database :(' . $exception->getMessage());
        }
    }

//    Methods
//    Function to Create New User
    public function register($Fullname, $Username, $Email, $Password) {
        $SQL1 = "SELECT Username, Email FROM `user` WHERE Username='" . $Username . "' OR Email = '" . $Email . "'";
        $stmt = $this->Connection->prepare($SQL1);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        $rows = $stmt->fetch();

        if ($num_rows >= 1) {
            if ($rows['Username'] == $Username) {
//                echo 'Username Already exist';
                $_SESSION["ErrorMessage"] = "Username Already exist";
                redirectTo("Auth.php");
            } elseif ($rows['Email'] == $Email) {
//                echo 'Email Already exist';
                $_SESSION["ErrorMessage"] = "Email Already exist";
                redirectTo("Auth.php");
            }
        } else {
            $user = new User($Fullname, $Username, $Email, $Password);
            $SQL2 = "INSERT INTO `user` (Fullname, Username, Email, Password) "
                    . "VALUES('" . $user->getFullname($Fullname) . "', '" . $user->getUsername($Username) . "', '" . $user->getEmail() . "', '" . $user->getPassword() . "')";
            $stmt = $this->Connection->prepare($SQL2);
            $result = $stmt->execute();
//            var_dump($SQL2);
            if ($result) {
//                echo 'data inserted ';
                $_SESSION["SuccessMessage"] = "User with ID:" . $this->Connection->lastInsertId() . " Created Successfuly";
                redirectTo("Auth.php");
            } else {
//                echo 'data was not inserted';
                $_SESSION["ErrorMessage"] = "Something Wrong";
                redirectTo("Auth.php");
            }
        }
    }

    public function Login($Email, $Password) {
        $SQL1 = "SELECT id, Email, Password FROM `user` WHERE Email='" . $Email . "'";
        $stmt = $this->Connection->prepare($SQL1);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        $rows = $stmt->fetch();

//        si l'email existe dans la base de donnees
        if ($num_rows >= 1) {
//             verification du mot de passe le cas d'un mot de passe valide
            if (password_verify($Password, $rows['Password'])) {
//                CREATING NEW SESSION
                $_SESSION['Userid'] = $rows['id'];
                $_SESSION['Email'] = $rows['Email'];
                $_SESSION["last_login_timestamp"] = time();
//                la redirection ver la page dashboard
//                header('Location: Dashboard.php');
                redirectTo('Dashboard.php');
//                le mot de passe  n'a pas valide
            } else {
                $_SESSION["ErrorMessage"] = "Oop's Wrong Password";
                redirectTo("Auth.php");
            }
//            le cas d'email qui n'existe pas dans la base de donnees
        } else {
            $_SESSION["ErrorMessage"] = "Username  Not Found";
            redirectTo("Auth.php");
        }
    }

    public function addTDL($Name, $Color, $dateTime, $CreatedBy) {
        $sql = "INSERT INTO tdl (name, color, date, createdby) "
                . "VALUES('" . $Name . "', '" . $Color . "', '" . $dateTime . "', '" . $CreatedBy . "')";
        $stmt = $this->Connection->prepare($sql);
        $res = $stmt->execute();
        if ($res) {
            $_SESSION["SuccessMessage"] = "ToDoList with ID:" . $this->Connection->lastInsertId() . " Created Successfuly";
            redirectTo("Dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something Wrong";
            redirectTo("Dashboard.php");
        }
    }

    public function getTDL() {

        $SQL = "SELECT * FROM tdl ";
        $stmt = $this->Connection->prepare($SQL);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    public function deletetdl($Id){
        $SQL = "DELETE FROM tdl WHERE idtdl='" . $Id . "'";
        $stmt = $this->Connection->prepare($SQL);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION["SuccessMessage"] = "To Do List Deleted Successfully";
            redirectTo("Dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something Wrong When we trying to Deleted TDL";
            redirectTo("Dashboard.php");
        }
    }
    

}
