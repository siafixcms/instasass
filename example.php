<?php

// Start sessions - we are going to need them to save API calls
session_start();

// Load all required dependencies
require_once 'vendor/autoload.php';

// Use the appropriate class
use Instasass\instasassapi;

// Initialize class and connect to the service
$oInstaSass = new instasassapi('API_KEY');

// Do a test - feeding in a SASS code
var_dump($oInstaSass->sass2cssSaved(__DIR__ . '/style.scss'));
