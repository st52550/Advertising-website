<?php
function existUser($email, $userName) {
    $exist = FALSE;
    $servername = "localhost";
    $username = "root";
    $password = "Database1001";
    $dbname = 'db_dev';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT user_id FROM users where email = '" . $email . "' or username = '" . $userName . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function getRole($id) {
    $servername = "localhost";
    $username = "root";
    $password = "Database1001";
    $dbname = 'db_dev';
    $role = null;


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT role FROM users where user_id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $role = $row["role"];
        }
    }
    return $role;
}

function getRegions() {
    $servername = "localhost";
    $username = "root";
    $password = "Database1001";
    $dbname = 'db_dev';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name FROM regions";
    /*
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $region = $row["name"];
        }
    }
    echo count($region);
    */
    return $conn->query($sql);
}
