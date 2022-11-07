<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    if (!$conn) {
        die("Error connecting to database".mysqli_connect_error());
    }

    //check if user with this email already exist in the database
    $select = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
        echo "This username already exists";
    } else {
        $sql = "INSERT INTO students (`full_names`, `country`, `email`, `gender`, `password`) VALUES('$fullnames', '$country', '$email', '$gender', '$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<meta http-equiv="refresh" content="2; url=../forms/login.html">';
            echo "User Successfully registered";
        } else {
            echo "<script>alert('An error occured');</script>";
        }
    }
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    if (!$conn) {
        die("Error connecting to database".mysqli_connect_error());
    }
    
    //open connection to the database and check if username exist in the database
    $select = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    //if it does, check if the password is the same with what is given
    if (mysqli_num_rows($result) == 1) {
        $select = "SELECT * FROM students WHERE email = '$email' and password = '$password'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) == 1) {
            //if true then set user session for the user 
            session_start();
            $_SESSION['username'] = $email;
            //Get fullname from database
            // $query = "SELECT full_names FROM students WHERE email = '$email'";
            // $fullname = mysqli_query($conn, $query);
            // if ($fullname) {
            //     $_SESSION['username'] = $fullname;
            // }
            //Redirect to the dasbboard
            header("Location: ../dashboard.php");
            exit;
        } else {
            echo '<meta http-equiv="refresh" content="2; url=../forms/login.html">';
            echo "<center><h1><strong>Incorrect Password</strong></h1></center>";
            exit;
        }
     
    } else {
        echo '<meta http-equiv="refresh" content="4; url=../forms/login.html">';
        echo "<script>alert('Unregistered Email');</script>";
        exit;
    }
    
    
}
        

function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    //open connection to the database and check if username exist in the database
    $sql = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    //if it does, replace the password with $password given
    if (mysqli_num_rows($result) > 0) {
        $sql = "UPDATE students SET password = '$password' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<meta http-equiv="refresh" content="4; url=../forms/login.html">';
            echo "Password Successfully changed";
            exit;
        } else {
            echo "<center><h1><strong>An error occured</strong></h1></center>";
            exit;
        }
    } else {
        echo '<meta http-equiv="refresh" content="4; url=../forms/login.html">';
        echo "<center><h1><strong>User does not exist</strong></h1></center>";
        exit;
    }
    
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            #echo($data['Full_names']);
            #var_dump($data);
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['Id'] . "</td>
                <td style='width: 150px'>" . $data['Full_names'] .
                "</td> <td style='width: 150px'>" . $data['Email'] .
                "</td> <td style='width: 150px'>" . $data['Gender'] . 
                "</td> <td style='width: 150px'>" . $data['Country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['Id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     $query = "DELETE FROM students WHERE id = '$id'";
     $result = mysqli_query($conn, $query);
     if ($result) {
        // echo '<meta http-equiv="refresh" content="4; url=../forms/index.html">';
        header("Location: ../index.php");
        exit;
     }
 }
