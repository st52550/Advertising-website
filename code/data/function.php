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
                JOIN rooms on items.ROOMS_room_id = room_id
                WHERE type = '$type'
                ORDER BY modification_date";

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
            JOIN users ON items.USERS_user_id=user_id
            JOIN categories ON items.categories_category_id = categories.category_id
            JOIN cities ON items.cities_city_id = cities.city_id
            JOIN regions on cities.regions_region_id = region_id
            JOIN rooms on items.ROOMS_room_id = room_id
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
            $sql = $sql."ORDER BY modification_date";
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
                JOIN rooms on items.ROOMS_room_id = room_id
                WHERE item_id = $id";

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

    $sql = "SELECT messages_message_id FROM messages_recipients WHERE users_user_id = $userId";

    return $conn->query($sql);
}

function getMessages($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM messages WHERE message_id = $id ORDER BY publication_date";

    return $conn->query($sql);
}

function getUserMessages($id) {
    global $dbServername, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM messages WHERE USERS_sender_id = $id ORDER BY publication_date";

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

    return $conn->query($sql);
}

