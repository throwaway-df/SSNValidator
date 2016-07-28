<?php

class SSNValidator {

  private $ssnHashes = array(
    0 => "0",
    1 => "1",
    2 => "2",
    3 => "3",
    4 => "4",
    5 => "5",
    6 => "6",
    7 => "7",
    8 => "8",
    9 => "9",
    10 => "A",
    11 => "B",
    12 => "C",
    13 => "D",
    14 => "E",
    16 => "F",
    17 => "H",
    15 => "J",
    18 => "K",
    19 => "L",
    20 => "M",
    21 => "N",
    22 => "P",
    23 => "R",
    24 => "S",
    25 => "T",
    26 => "U",
    27 => "V",
    28 => "W",
    29 => "X",
    30 => "Y"
  );

  private $daysInMonths = array(
    1 => "31",
    2 => "28",
    3 => "31",
    4 => "30",
    5 => "31",
    6 => "30",
    7 => "31",
    8 => "31",
    9 => "30",
    10 => "31",
    11 => "30",
    12 => "31"
  );

  public function __construct($ssn) {
    $this->ssn = $ssn;
  }

  public function validateSSN() {

    if(!$this->parseSSN() || !$this->validateSSNDate() || !$this->validateSSNUnique() || !$this->validateSSNHash()) {
      return false;
    }

    return true;
  }

  private function parseSSN() {

    $decodedSSN = urldecode($this->ssn);

    $uppercaseSSN = strtoupper($decodedSSN);

    // Finnish SSN regex
      // Date ddmmyy
      // Separator (+, - or A)
      // Unique identifier (002-899)
      // Hash (calculated by appending the unique identifier to the date, dividing by 31 and comparing the remainder to a precalculated array of values)
    $pattern = "/^\d{6}[-A\+]\d{3}[A-Z0-9]$/";

    if(!preg_match($pattern, $uppercaseSSN)) {

      return false;

    }

    // Parse different parts of the SSN for further validation
    $this->ssnDay = substr($uppercaseSSN, 0, 2);

    $this->ssnMonth = substr($uppercaseSSN, 2, 2);

    $this->ssnYear = substr($uppercaseSSN, 4, 2);

    $this->ssnSeparator = substr($uppercaseSSN, 6, 1);

    $this->ssnUnique = substr($uppercaseSSN, 7, 3);

    $this->ssnHash = substr($uppercaseSSN, -1);

    return true;

  }

  private function validateSSNDate() {


    // Ignore leading zeroes
    $ssnDay = (int)$this->ssnDay;

    // Ignore leading zeroes
    $ssnMonth = (int)$this->ssnMonth;

    // Ignore leading zeroes
    $ssnYear = (int)$this->ssnYear;

    // Month validation
    if($ssnMonth < 1 || $ssnMonth > 12) {
      return false;
    }

    // Day validation
    if($ssnMonth == "2" && $ssnDay == "29") { // Leap day rules

      // Assemble full year based on separator
      switch($this->ssnSeparator) {

        case "+":
          $ssnFullYear = "18" . $ssnYear;
          break;

        case "-":
          $ssnFullYear = "19" . $ssnYear;
          break;

        case "A":
          $ssnFullYear = "20" . $ssnYear;
          break;

      }

      // Check for leap year
      if(!date('L', mktime(0, 0, 0, 1, 1, $ssnFullYear))) {
        return false;
      }

    } else { // Normal day rules

      if($ssnDay < 1 || $ssnDay > $this->daysInMonths[$ssnMonth]) {
        return false;
      }

    }

    return true;

  }

  private function validateSSNUnique() {

    // Ignore leading zeroes
    $ssnUniqueInt = (int)$this->ssnUnique;

    // Finnish SSN has an unique identifier between 002 and 899
    if($ssnUniqueInt < 2 || $ssnUniqueInt > 899) {
      return false;
    }

    return true;
  }

  private function validateSSNHash() {

    // Hash (calculated by appending the unique identifier to the date, dividing by 31 and comparing the remainder to a precalculated array of values)
    $ssnHashParts = $this->ssnDay . $this->ssnMonth . $this->ssnYear . $this->ssnUnique;

    $ssnHashPartsInt = (int)$ssnHashParts;

    $remainder = $ssnHashPartsInt % 31;

    // Compare SSN hash to the precalculated remainder value hash
    if($this->ssnHash != $this->ssnHashes[$remainder]) {
      return false;
    }

    return true;
  }

}

?>
