# SSNValidator
Finnish SSN Validation API

A simple PHP API endpoint for validation Finnish SSNs.

## Prerequisites:
PHP 5.X

## Installation:

Clone the repository
  `git clone https://github.com/throwaway-df/SSNValidator.git`

OR

Download the repository as a `.zip` and extract the validateSSN folder into the location of your choice on your web server.

## Usage:

Make GET or POST requests to `http://location/validateSSN/` with URL parameter `ssn`.

e.g. http://location/validateSSN/?ssn=010101A1234

If you've made a successful request the response will either `true` to indicate a valid Finnish SSN or `false` to indicate an invalid SSN.
