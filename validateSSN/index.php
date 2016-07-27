<?php

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

  }

  // Start SSN Validation

  if(!$ssnValidator->parseSSN()) {

    // Set value to false and parse response

  }





?>
