<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // CORS
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');

  // SSNValidator class
  require_once('ssnvalidator.php');

  $errorText = "";
  $errorCode = 0;
  $valid = true;
  $ssnFound = false;

  // Handle URL parameters
  if(isset($_GET) || isset($_POST)) {

    if(isset($_GET) && count($_GET) > 0) {

      foreach ($_GET as $key => $value)  {

        if($key == 'ssn') {

          $ssn = $_GET['ssn'];

          $ssnFound = true;

        } else {

          // Set valid to false, set error and parse response
          $valid = false;
          $errorCode = 400; // Bad Request
          $errorText = "Faulty parameters: only 'ssn' allowed";
          break;

        }

      }

    } else if(isset($_POST) && count($_POST) > 0) {

      foreach ($_POST as $key => $value)  {

        if($key == 'ssn') {

          $ssn = $_POST['ssn'];

          $ssnFound = true;

        } else {

          // Set valid to false, set error and parse response
          $valid = false;
          $errorCode = 400; // Bad Request
          $errorText = "Faulty parameters: only 'ssn' allowed";
          break;

        }

      }

    }

  } else {

    // Set valid to false, set error and parse response
    $valid = false;
    $errorCode = 400; // Bad Request
    $errorText = "Faulty parameters: parameter 'ssn' has to be supplied";

  }

  if($ssnFound == false) {
    // Set valid to false, set error and parse response
    $valid = false;
    $errorCode = 400; // Bad Request
    $errorText = "Faulty parameters: parameter 'ssn' has to be supplied";
  }

  // Continue to validation if URL parameters were correct
  if($valid != false) {

    // Start SSN Validation

    $ssnValidator = new SSNValidator($ssn);

    if(!$ssnValidator->validateSSN()) {

      $valid = false;

    }

  }

  header('Content-Type: text/plain');

  if($errorCode != 0) {
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . ' ' . $errorCode . ' ' . $errorText);
  } else {
    echo var_export($valid, true);
  }

?>
