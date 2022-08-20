<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//For Password Hashing..
if ( ! function_exists('passHash')) {
    function passHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

//For Password Hashing..
if ( ! function_exists('passVerify')) {
    function passVerify($password,$dbPass)
    {
        return password_verify($password, $dbPass);
        //return true;
    }
}
?>
