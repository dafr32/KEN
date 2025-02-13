<?php
$pass = "ken";
$hashed_password = password_hash($pass, PASSWORD_ARGON2I);
echo $hashed_password;
?>