<?php 

function db_connect() {
    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "potato";
    $db_name = 'test_db';
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  return  $conn;
}

function db_disconnect($conn) {
    $conn->close();
}
?>