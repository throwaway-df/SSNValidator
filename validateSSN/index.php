<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // CORS
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  // SSNValidator class
  require_once('ssnvalidator.php');

  $errorCode = 0;
  $value = true;

  // Handle URL parameters
  if(isset($_GET)) {

    foreach ($_GET as $key => $value)  {

      if($key == 'ssn') {

        $ssn = $_GET['ssn'];

      } else {

        $value = false;
        break;

      }

    }

  } else {

    // Set value to false, set error and parse response
    $value = false;
    $errorCode = 404; // Bad Request

  }

  // Continue to validation if URL parameters were correct
  if($value != false) {

    // Start SSN Validation

    $ssnValidator = new SSNValidator($ssn);

    if(!$ssnValidator->validateSSN()) {
  
      $value = false;

    }

  }

  header('Content-Type: text/plain');

  if($errorCode != 0) {
    http_response_code($errorCode);
  } else {
    echo $value;
  }

?>
