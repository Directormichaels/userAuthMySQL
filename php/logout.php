<?php
session_start();


logout();

function logout(){
    /*
Check if the existing user has a session
if it does
destroy the session and redirect to login page
*/
    if (isset($_SESSION["username"])) {
        session_destroy();
        header("Location: ../index.php");
        exit;
    }
}