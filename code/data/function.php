<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "Database1001";
$dbName = 'db_dev';

function getConnection() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

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

function existUsername($username) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT user_id FROM users WHERE username = '" . $username . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function existEmail($email) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT user_id FROM users WHERE email = '" . $email . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function addUser($username, $email, $passwd, $role, $description) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (user_id, role, username, email, password, created, description) VALUES
            (NULL, '$role', '$username', '$email', '$passwd', NOW(), '$description')";
    $conn->query($sql);
}

function editUser($userId, $username, $email, $role, $description) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET role = '$role', username = '$username', email = '$email', description = '$description' 
            WHERE user_id = $userId";
    $conn->query($sql);
}

function deleteUser($userId) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT item_id FROM items WHERE users_user_id = $userId";
    $items = $conn->query($sql);
    if ($items->num_rows > 0) {
        while ($rowItem = $items->fetch_assoc()) {
            $itemId = $rowItem["item_id"];

            $sql1 = "SELECT path FROM images WHERE items_item_id = $itemId";
            $images = $conn->query($sql1);
            if ($images->num_rows > 0) {
                while ($rowImages = $images->fetch_assoc()) {
                    $file = $rowImages["path"];
                    unlink($file);
                }
            }

            $sql2 = "DELETE FROM images WHERE items_item_id = $itemId";
            $conn->query($sql2);
        }
    }

    $sql3 = "DELETE FROM items WHERE users_user_id = $userId";
    $conn->query($sql3);

    $sql4 = "DELETE FROM messages_recipients WHERE users_user_id = $userId";
    $conn->query($sql4);

    $sql5 = "UPDATE messages SET USERS_sender_id = NULL WHERE USERS_sender_id = $userId";
    $conn->query($sql5);

    $sql6 = "DELETE FROM users WHERE user_id = $userId";
    $conn->query($sql6);
}

function getUsers() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users ORDER BY created DESC";
    return $conn->query($sql);
}

function getByUserEmail($email) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users where email = '$email'";
    return $conn->query($sql);
}

function getByUserId($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users where user_id = $id";
    return $conn->query($sql);
}

function getByUsername($username) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users where username = '$username'";
    return $conn->query($sql);
}

function updateUsername($userId, $username) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET username = '$username' WHERE user_id = $userId";
    $conn->query($sql);
}

function updateEmail($userId, $email) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET email = '$email' WHERE user_id = $userId";
    $conn->query($sql);
}

function updatePassword($userId, $password) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET password = '$password' WHERE user_id = $userId";
    $conn->query($sql);
}

function updateDescription($userId, $description) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET description = '$description' WHERE user_id = $userId";
    $conn->query($sql);
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

    $sql = "SELECT * FROM regions";
    return $conn->query($sql);
}

function getRegion($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM regions WHERE region_id = $id";
    return $conn->query($sql);
}

function getRegionByName($name) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM regions WHERE name = '$name'";
    return $conn->query($sql);
}

function existRegion($region) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT region_id FROM regions WHERE name = '$region'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function addRegion($region) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO regions (region_id, name) VALUES (NULL, '$region')";
    $conn->query($sql);
}

function editRegion($id, $region) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE regions SET name = '$region' WHERE region_id = $id";
    $conn->query($sql);
}

function deleteRegion($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $success = TRUE;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM regions WHERE region_id = $id";
    $conn->query($sql);

    if (mysqli_error($conn)) {
        $success = FALSE;
    }

    return $success;
}

function getCities() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT city_id, cities.name AS city, regions.name AS region FROM cities
            JOIN regions ON regions_region_id = region_id";
    return $conn->query($sql);
}

function getCity($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT city_id, cities.name AS city, regions.name AS region FROM cities
            JOIN regions ON regions_region_id = region_id
            WHERE city_id = $id";
    return $conn->query($sql);
}

function existCity($city) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT city_id FROM cities WHERE name = '$city'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function addCity($city, $regionId) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO cities (city_id, name, regions_region_id) VALUES (NULL, '$city', $regionId)";
    $conn->query($sql);
}

function editCity($cityId, $city, $regionId) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE cities SET name = '$city', regions_region_id = $regionId WHERE city_id = $cityId";
    $conn->query($sql);
}

function deleteCity($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $success = TRUE;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM cities WHERE city_id = $id";
    $conn->query($sql);

    if (mysqli_error($conn)) {
        $success = FALSE;
    }

    return $success;
}

function getCategories() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM categories";
    return $conn->query($sql);
}

function getCategory($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM categories WHERE category_id = $id";
    return $conn->query($sql);
}

function existCategory($category) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT category_id FROM categories WHERE name = '$category'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function addCategory($category) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO categories (category_id, name) VALUES (NULL, '$category')";
    $conn->query($sql);
}

function editCategory($id, $category) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE categories SET name = '$category' WHERE category_id = $id";
    $conn->query($sql);
}

function deleteCategory($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $success = TRUE;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM categories WHERE category_id = $id";
    $conn->query($sql);

    if (mysqli_error($conn)) {
        $success = FALSE;
    }

    return $success;
}

function getRooms() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM rooms";
    return $conn->query($sql);
}

function getRoom($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM rooms WHERE room_id = $id";
    return $conn->query($sql);
}

function existRoom($room) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $exist = FALSE;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT room_id FROM rooms WHERE name = '$room'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function addRoom($room) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO rooms (room_id, name) VALUES (NULL, '$room')";
    $conn->query($sql);
}

function editRoom($id, $room) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE rooms SET name = '$room' WHERE room_id = $id";
    $conn->query($sql);
}

function deleteRoom($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $success = TRUE;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM rooms WHERE room_id = $id";
    $conn->query($sql);

    if (mysqli_error($conn)) {
        $success = FALSE;
    }

    return $success;
}

function getAllUsersItems() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT item_id, publication_date, modification_date, price, area, users.username,categories.name AS category,
       title, items.description, cities.name AS city, regions.name AS region, rooms.name AS room, type FROM items
                JOIN users ON items.USERS_user_id=user_id
                JOIN categories ON items.categories_category_id = categories.category_id
                JOIN cities ON items.cities_city_id = cities.city_id
                JOIN regions on cities.regions_region_id = region_id
                LEFT JOIN rooms on items.ROOMS_room_id = room_id
                ORDER BY publication_date DESC";

    return $conn->query($sql);
}

function getAllItems($type) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT item_id, publication_date, modification_date, price, area, users.username,categories.name AS category,
       title, items.description, cities.name AS city, regions.name AS region, rooms.name AS room, type FROM items
                JOIN users ON items.USERS_user_id=user_id
                JOIN categories ON items.categories_category_id = categories.category_id
                JOIN cities ON items.cities_city_id = cities.city_id
                JOIN regions on cities.regions_region_id = region_id
                LEFT JOIN rooms on items.ROOMS_room_id = room_id
                WHERE type = '$type'
                ORDER BY modification_date DESC";

    return $conn->query($sql);
}

function getItems($typeValue, $cityValue, $regionValue, $categoryValue, $roomsValues,
                  $priceFrom, $priceTo, $areaFrom, $areaTo) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!empty($roomsValues)) {
        $stringRoomsValues = "'" . implode("','", $roomsValues) . "'";
    } else {
        $stringRoomsValues = '';
    }

    $sql = "SELECT item_id, publication_date, modification_date, price, area, users.username,categories.name AS category,
        title, items.description, cities.name AS city, regions.name AS region, rooms.name AS room, type FROM items               
            JOIN users ON items.users_user_id=user_id
            JOIN categories ON items.categories_category_id = categories.category_id
            JOIN cities ON items.cities_city_id = cities.city_id
            JOIN regions on cities.regions_region_id = region_id
            LEFT JOIN rooms on items.rooms_room_id = room_id
            WHERE
                type = '$typeValue'";
            if (!empty($cityValue)) {$sql = $sql."AND cities.name = '$cityValue'";}
            if (!empty($regionValue) && $regionValue != 'Celá ČR') {$sql = $sql."AND regions.name = '$regionValue'";}
            if (!empty($categoryValue)) {$sql = $sql."AND categories.name = '$categoryValue'";}
            if (!empty($stringRoomsValues)) {$sql = $sql."AND rooms.name IN ($stringRoomsValues)";}
            if (!empty($priceFrom) && empty($priceTo)) {$sql = $sql."AND price >= $priceFrom ";}
            if (empty($priceFrom) && !empty($priceTo)) {$sql = $sql."AND price <= $priceTo ";}
            if (!empty($priceFrom) && !empty($priceTo)) {$sql = $sql."AND (price BETWEEN $priceFrom AND $priceTo)";}
            if (!empty($areaFrom) && empty($areaTo)) {$sql = $sql."AND area >= $areaFrom ";}
            if (empty($areaFrom) && !empty($areaTo)) {$sql = $sql."AND area <= $areaTo ";}
            if (!empty($areaFrom) && !empty($areaTo)) {$sql = $sql."AND (area BETWEEN $areaFrom AND $areaTo)";}
            $sql = $sql."ORDER BY modification_date DESC";
    return $conn->query($sql);
}

function getItem($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT item_id, publication_date, modification_date, price, area, users.username,users.email, categories.name AS category,
       title, items.description, cities.name AS city, regions.name AS region, rooms.name AS room, type FROM items               
                JOIN users ON items.USERS_user_id=user_id
                JOIN categories ON items.categories_category_id = categories.category_id
                JOIN cities ON items.cities_city_id = cities.city_id
                JOIN regions on cities.regions_region_id = region_id
                LEFT JOIN rooms on items.ROOMS_room_id = room_id
                WHERE item_id = $id";

    return $conn->query($sql);
}

function getItemsByUserId($userId) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT item_id, publication_date, modification_date, price, area, users.username,users.email, categories.name AS category,
       title, items.description, cities.name AS city, regions.name AS region, rooms.name AS room, type FROM items               
                JOIN users ON items.USERS_user_id=user_id
                JOIN categories ON items.categories_category_id = categories.category_id
                JOIN cities ON items.cities_city_id = cities.city_id
                JOIN regions on cities.regions_region_id = region_id
                LEFT JOIN rooms on items.ROOMS_room_id = room_id
                WHERE users_user_id = $userId
                ORDER BY modification_date DESC";

    return $conn->query($sql);
}

function getPictures($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM images WHERE items_item_id = $id";

    return $conn->query($sql);
}

function insertMessage($recipientEmail, $senderEmail, $username, $message) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO messages(message_id, message, publication_date, sender_name, sender_email, readed) 
             VALUES (NULL, '$message', NOW(), '$username', '$senderEmail', 0)";
    $conn->query($sql);

    $user = getByUserEmail($recipientEmail);
    if ($user->num_rows > 0) {
        $rowUser = $user->fetch_assoc();
        $recipientId = $rowUser["user_id"];
        $sql1 = "INSERT INTO messages_recipients(messages_message_id, users_user_id) 
             VALUES (LAST_INSERT_ID(), $recipientId)";
        $conn->query($sql1);
    }
}

function insertMessageExistingUser($recipientEmail, $senderEmail, $username, $message, $senderId) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO messages(message_id, message, publication_date, USERS_sender_id, sender_name, sender_email, readed) 
             VALUES (NULL, '$message', NOW(), $senderId, '$username', '$senderEmail', 0)";
    $conn->query($sql);

    $user = getByUserEmail($recipientEmail);
    if ($user->num_rows > 0) {
        $rowUser = $user->fetch_assoc();
        $recipientId = $rowUser["user_id"];
        $sql1 = "INSERT INTO messages_recipients(messages_message_id, users_user_id) 
             VALUES (LAST_INSERT_ID(), $recipientId)";
        $conn->query($sql1);
    }
}

function insertUserMessage($recipientsUsernames, $userMessageSenderId, $userMessage) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = getByUserId($userMessageSenderId);
    $username = '';
    $senderEmail = '';
    if ($user->num_rows > 0) {
        while ($rowUser = $user->fetch_assoc()) {
            $username = $rowUser["username"];
            $senderEmail = $rowUser["email"];
        }
    }

    $sql = "INSERT INTO messages(message_id, message, publication_date, USERS_sender_id, sender_name, sender_email, readed) 
             VALUES (NULL, '$userMessage', NOW(), $userMessageSenderId, '$username', '$senderEmail', 0)";
    $conn->query($sql);

    $names = explode (",", $recipientsUsernames);
    foreach ($names as $name){
        $userId = getByUsername($name);
        if ($userId->num_rows > 0) {
            $rowUserId = $userId->fetch_assoc();
            $recipientId = $rowUserId["user_id"];
            $sql1 = "INSERT INTO messages_recipients(messages_message_id, users_user_id) 
             VALUES (LAST_INSERT_ID(), $recipientId)";
            $conn->query($sql1);
        }
    }
}

function getMessagesIds($userId) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT messages_message_id, messages.publication_date FROM messages_recipients 
            JOIN messages ON messages_message_id = messages.message_id
            WHERE users_user_id = $userId
            ORDER BY publication_date DESC";

    return $conn->query($sql);
}

function getMessages($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM messages WHERE message_id = $id ORDER BY publication_date DESC";

    return $conn->query($sql);
}

function getUserMessages($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM messages WHERE USERS_sender_id = $id ORDER BY publication_date DESC";

    return $conn->query($sql);
}

function getRecipients($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT messages_message_id, users_user_id, users.username AS username, users.email AS email 
            FROM messages_recipients 
            JOIN users ON users_user_id = user_id
            WHERE messages_message_id = $id ORDER BY users.username";

    return $conn->query($sql);
}

function markReaded($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE messages set readed = 1 where message_id = $id";
    $conn->query($sql);
}

function deleteItem($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT path FROM images WHERE items_item_id = $id";
    $images = $conn->query($sql);
    if ($images->num_rows > 0) {
        while ($rowImages = $images->fetch_assoc()) {
            $file = $rowImages["path"];
            unlink($file);
        }
    }

    $sql1 = "DELETE FROM images WHERE items_item_id = $id";
    $conn->query($sql1);

    $sql2 = "DELETE FROM items WHERE item_id = $id";
    $conn->query($sql2);
}

function getPicturesById($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM images WHERE image_id = $id";

    return $conn->query($sql);
}

function getAllPictures() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM images";

    return $conn->query($sql);
}

function editPicture($pictureId, $pictureName, $picturePath) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE images SET name = '$pictureName', path = '$picturePath' WHERE image_id = $pictureId";

    return $conn->query($sql);
}

function deleteImage($imageName) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT path, items_item_id FROM images WHERE name = '$imageName'";
    $images = $conn->query($sql);

    $itemId = 0;
    if ($images->num_rows > 0) {
        while ($rowImages = $images->fetch_assoc()) {
            $file = $rowImages["path"];
            $itemId = $rowImages["items_item_id"];
            unlink($file);
        }
    }

    $sql1 = "DELETE FROM images WHERE name = '$imageName'";
    $conn->query($sql1);

    return $itemId;
}