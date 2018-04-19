<?php
/*
 KIBELLA 1.0
 Copyright 2016 Frank Vanden berghen
 All Right reserved.

 Kibella is not a free software. The Kibella software is NOT licensed under the "Apache License".
 If you are interested in distributing, reselling, modifying, contibuting or in general creating
 any derivative work from Kibella, please contact Frank Vanden Berghen at frank@timi.eu.
 */
namespace kibella;

require_once(__DIR__ . '/../constants.php');
require_once(__DIR__ . '/../functionsdb.php');
require_once(__DIR__ . '/../classes.php');


class UserManager {
  private $db_connection = null;

  public $error = null;
  public $success = null;

  public function __construct() {
      if (isset($_POST["register"])) {
        $this->register();
      } elseif (isset($_POST["delete"])) {
        $this->delete();
      } elseif (isset($_POST["edit"])) {
        $this->edit();
      }
  }

  public function getAll() {
    $this->db_connection = dbDBHCreate(KIBELLADB, TABLESDIR, $mode="sqlite");

    $sql = 'SELECT * FROM Users';
    
    $result_rows = dbDBHExecuteSqlQuery($this->db_connection, $sql, $mode="sqlite");

    return $result_rows;
  }

  public function getUser($id) {
    if($id) {
      $id = addslashes(htmlentities($id, ENT_QUOTES));

      $this->db_connection = dbDBHCreate(KIBELLADB, TABLESDIR, $mode="sqlite");

      $sql = 'SELECT * FROM Users WHERE id = "' . $id . '"';
      
      $result = dbDBHExecuteSqlQuery($this->db_connection, $sql, $mode="sqlite");

      if($result[0])
        return $result[0];
    }

    return false;
  }

  private function register(){
    if ($this->checkRegistrationData($edit=false)) {
      $this->db_connection = dbDBHCreate(KIBELLADB, TABLESDIR, $mode="sqlite");
      if ($this->db_connection) {
        $this->createNewUser();
      }
    }
    
    return false;
  }

  private function delete() {
    $this->db_connection = dbDBHCreate(KIBELLADB, TABLESDIR, $mode="sqlite");

    if ($this->db_connection) {
      $email = addslashes(htmlentities($_POST["delete"], ENT_QUOTES));

      $sql = 'DELETE FROM Users WHERE email = "' . $email . '" LIMIT 1';
    
      $result = dbDBHExecuteSqlQuery($this->db_connection, $sql, $mode="exec");

      if($result) {
        $this->success = $email . ' account has been deleted.';
      } else {
        $this->error = 'An error occured while deleting ' . $email . ' account.';
      }
    }
  }

  private function edit() {
    if(isset($_GET['id'])) {
      if ($this->checkRegistrationData($edit=true)) {
        $this->db_connection = dbDBHCreate(KIBELLADB, TABLESDIR, $mode="sqlite");
        if ($this->db_connection) {
          $id = addslashes(htmlentities($_GET['id'], ENT_QUOTES));
          $email = addslashes(htmlentities($_POST['email'], ENT_QUOTES));
          $password = addslashes(htmlentities($_POST['password'], ENT_QUOTES));
          $firstname = addslashes(htmlentities($_POST['firstname'], ENT_QUOTES));
          $lastname = addslashes(htmlentities($_POST['lastname'], ENT_QUOTES));

          $sql = 'UPDATE Users SET firstname = "' . $firstname . '",lastname = "' . $lastname . '",email = "' . $email . '"';

          if(!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ',password = "' . $password_hash . '"';
          }

          $sql .= ' WHERE id = "' . $id . '" LIMIT 1';

          $result = dbDBHExecuteSqlQuery($this->db_connection, $sql, $mode="exec");

          if($result) {
            $this->success = 'Account ' . $id . ' has been edited.';
          } else {
            $this->error = 'An error occured while editing account ' . $id . '.';
          }
        }
      }
    } else {
      $this->error = 'Unknown ID.';
    }
    
    return false;
  }

  private function createNewUser() {
    $user_email = addslashes(htmlentities($_POST['email'], ENT_QUOTES));
    $user_password = addslashes(htmlentities($_POST['password'], ENT_QUOTES));
    $user_firstname = addslashes(htmlentities($_POST['firstname'], ENT_QUOTES));
    $user_lastname = addslashes(htmlentities($_POST['lastname'], ENT_QUOTES));

    if(isset($_POST['is_admin']) && $_POST['is_admin'] == 'yes')
      $user_is_admin = "TRUE";
    else
      $user_is_admin = "FALSE";
    
    // crypt the user's password with the PHP's password_hash() function, results in a 60 char hash string.
    // the constant PASSWORD_DEFAULT comes from PHP 5.5
    $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
    $sql = 'SELECT * FROM Users WHERE email = "' . $user_email . '"';
    
    $result_row = dbDBHExecuteSqlQuery($this->db_connection, $sql, $mode="sqlite");
    if ($result_row) {
        $this->error = "Sorry, that email is already taken. Please choose another one.";
    } else {
        $sql = 'INSERT INTO Users (email, password, firstname, lastname, is_admin)
                VALUES("' . $user_email . '", "' . $user_password_hash . '", "' . $user_firstname . '", "' . $user_lastname . '", "' . $user_is_admin . '")';
        
        $registration_success_state = dbDBHExecuteSqlQuery($this->db_connection, $sql, $mode="exec");
        if ($registration_success_state) {
            $this->success = "User created successfully.";
            return true;
        } else {
            $this->error = "Sorry, your registration failed. Please go back and try again.";
        }
    }
    
    return false;
  }

  private function checkRegistrationData($edit=false) {
    // Validate inputs and fill error variable
    if (!empty($_POST['firstname'])
        && strlen($_POST['firstname']) <= 64
        && preg_match('/^[A-Za-z-é]{2,64}$/i', $_POST['firstname'])
        && !empty($_POST['lastname'])
        && strlen($_POST['lastname']) <= 64
        && preg_match('/^[A-Za-z-é]{2,64}$/i', $_POST['lastname'])
        && !empty($_POST['email'])
        && strlen($_POST['email']) <= 64
        && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
        && (($edit == true && empty($_POST['password'])) || (($edit == false || $edit == true && !empty($_POST['password'])) && !empty($_POST['password'])
        && strlen($_POST['password']) >= 6
        && !empty($_POST['password_repeat'])
        && ($_POST['password'] === $_POST['password_repeat'])))) {
      return true;
    } elseif (empty($_POST['firstname'])) {
      $this->error = "Empty first name.";
    } elseif (empty($_POST['lastname'])) {
      $this->error = "Empty last name.";
    } elseif ((empty($_POST['password']) || empty($_POST['password_repeat']))  && $edit == false) {
      $this->error = "Empty password.";
    } elseif ($_POST['password'] !== $_POST['password_repeat'] && ($edit == false || $edit == true && !empty($_POST['password']))) {
      $this->error = "Password and password repeat are not the same.";
    } elseif (strlen($_POST['password']) < 6 && ($edit == false || $edit == true && !empty($_POST['password']))) {
      $this->error = "Password has a minimum length of 6 characters.";
    } elseif (strlen($_POST['firstname']) > 64 || strlen($_POST['firstname']) < 2) {
      $this->error = "First name cannot be shorter than 2 or longer than 64 characters.";
    } elseif (!preg_match('/^[A-Za-z-]{2,64}$/i', $_POST['firstname'])) {
      $this->error = "First name does not fit the name scheme: only a-Z and dash are allowed, 2 to 64 characters.";
    } elseif (strlen($_POST['lastname']) > 64 || strlen($_POST['lastname']) < 2) {
      $this->error = "Last name cannot be shorter than 2 or longer than 64 characters.";
    } elseif (!preg_match('/^[A-Za-z-]{2,64}$/i', $_POST['lastname'])) {
      $this->error = "Last name does not fit the name scheme: only a-Z and dash are allowed, 2 to 64 characters.";
    } elseif (empty($_POST['email'])) {
      $this->error = "Email cannot be empty.";
    } elseif (strlen($_POST['email']) > 64) {
      $this->error = "Email cannot be longer than 64 characters.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $this->error = "Your email address is not in a valid email format.";
    } else {
      $this->error = "An unknown error occurred.";
    }
    
    return false;
  }
}