<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // CORS
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  // SSNValidator class
  require_once('ssnvalidator.php');

  $errorCode;
  $errorText;
  $value = true;

  // Handle URL parameters
  if(isset($_GET['ssn'])) {

    $ssn = $_GET['ssn'];

    $ssnValidator = new SSNValidator($ssn);

  } else {

    // Set value to false, set error and parse response
    echo "Error";

  }

  // Start SSN Validation

  if(!$ssnValidator->validateSSN()) {

    // Set value to false, set error and parse response
    echo "false";

  } else {

    echo "true";

  }





?>
