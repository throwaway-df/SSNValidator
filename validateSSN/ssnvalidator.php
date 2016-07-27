<?php

class SSNValidator {

  public function __construct($ssn) {
    $this->ssn = $ssn;
  }

  public function parseSSN() {

    $uppercaseSSN = strtoupper($this->ssn);

    $pattern = "/^\d{6}[-A]\d{3}[A-Z0-9]$/";

    if(!preg_match($pattern, $uppercaseSSN)) {

      return false;

    }

    $this->ssnDay = substr($uppercaseSSN, 0, 2);

    $this->ssnMonth = substr($uppercaseSSN, 2, 2);

    $this->ssnYear = substr($uppercaseSSN, 4, 2);

    $this->ssnSeparator = substr($uppercaseSSN, 5, 1);

    $this->ssnUnique = substr($uppercaseSSN, 6, 3);

    $this->ssnHash = substr($uppercaseSSN, -1);

    return true;

  }

}

?>
