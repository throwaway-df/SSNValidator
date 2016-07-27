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

    return true;

  }

}

?>
