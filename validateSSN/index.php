<?php

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

  if(!$ssnValidator->parseSSN()) {

    // Set value to false, set error and parse response
    echo "false";

  } else {

    echo "true";

  }





?>
