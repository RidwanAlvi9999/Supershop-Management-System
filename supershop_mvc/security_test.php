<?php
require_once "core/security.php";

$name = "<script>alert('xss')</script>";
echo cleanInput($name);
