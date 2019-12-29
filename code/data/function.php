<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "Database1001";
$dbName = 'db_dev';

function existUser($email, $username) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT user_id FROM users where email = '" . $email . "' or username = '" . $username . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function getRole($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $role = "";

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
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
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name FROM regions";
    return $conn->query($sql);
}

function getCategories() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name FROM categories";
    return $conn->query($sql);
}

function getRooms() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name FROM rooms";
    return $conn->query($sql);
}

function getAllItems() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT item_id, publication_date, price, users.username,categories.name AS category,
       title, items.description, cities.name AS city, regions.name AS region, rooms.name AS room, type FROM items
                JOIN users ON items.USERS_user_id=user_id
                JOIN categories ON items.categories_category_id = categories.category_id
                JOIN cities ON items.cities_city_id = cities.city_id
                JOIN regions on cities.regions_region_id = region_id
                JOIN rooms on items.ROOMS_room_id = room_id
                ORDER BY publication_date";

    return $conn->query($sql);
}
