<?php
$actualUserId = '';
if (isset($_SESSION["user_id"])) {
    $actualUserId = $_SESSION["user_id"];
}

if (isset($_POST["create-ad"])) {
    $conn = getConnection();

    $price = $_POST["item-price"];
    $area = $_POST["item-area"];
    $category = $_POST["item-category"];
    $descripton = $_POST["item-description"];
    $title = $_POST["item-title"];
    $city = $_POST["item-city"];
    $room = $_POST["item-rooms"];
    $type = $_POST["radio2"];

    $data = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyAmmxigt72w01fnXt4HUVVmiqQgkNrLjeQ&address=$city&sensor=false&language=cs");
    $data = json_decode($data);
    $resultArray  = $data->results;
    $resultArray = $resultArray[0];
    $resultArray = $resultArray->address_components;
    $region = "Not found";
    foreach ($resultArray as $key) {
        if($key->types[0] == 'administrative_area_level_1')
        {
            $region = $key->long_name;
        }
    }

    $sql = "SELECT category_id FROM categories WHERE name = '$category'";
    $result = $conn->query($sql);
    $categoryId = -1;
    if ($result->num_rows > 0) {
        $resultRow = $result->fetch_assoc();
        $categoryId = $resultRow["category_id"];
    }

    $sql1 = "SELECT region_id FROM regions WHERE name = '$region'";
    $result1 = $conn->query($sql1);
    $regionId = -1;
    if ($result1->num_rows > 0) {
        $resultRow1 = $result1->fetch_assoc();
        $regionId = $resultRow1["region_id"];
    }

    $sql2 = "SELECT * FROM cities WHERE name = '$city'";
    $result2 = $conn->query($sql2);
    $cityId = -1;
    if ($result2->num_rows > 0) {
        $resultRow2 = $result2->fetch_assoc();
        $cityId = $resultRow2["city_id"];
    } else {
        $sql3 = "INSERT INTO cities (city_id, name, regions_region_id) VALUES 
                 (NULL, '$city', $regionId)";
        $conn->query($sql3);
        $cityId = mysqli_insert_id($conn);
    }

    $sql4 = "SELECT * FROM rooms WHERE name = '$room'";
    $result4 = $conn->query($sql4);
    $roomId = -1;
    if ($result4->num_rows > 0) {
        $resultRow4 = $result4->fetch_assoc();
        $roomId = $resultRow4["room_id"];
    }

    $sql5 = '';
    if ($category != 'Pozemek') {
        $sql5 = "INSERT INTO items (item_id, publication_date, modification_date, price, users_user_id, categories_category_id,
                     title, description, cities_city_id, rooms_room_id, type, area) VALUES
                (NULL, NOW(), NOW(), $price, $actualUserId, $categoryId, '$title', '$descripton', $cityId, $roomId, '$type', $area)";
    } else {
        $sql5 = "INSERT INTO items (item_id, publication_date, modification_date, price, users_user_id, categories_category_id,
                     title, description, cities_city_id, rooms_room_id, type, area) VALUES
                (NULL, NOW(), NOW(), $price, $actualUserId, $categoryId, '$title', '$descripton', $cityId, NULL, '$type', $area)";
    }
    $conn->query($sql5);

    $count = 0;
    if(!empty($_FILES['item-images']['name'])) {
        $count = count(array_filter($_FILES['item-images']['name']));
    }

    $itemId = mysqli_insert_id($conn);
    if ($count > 0) {
        for ($x = 0; $x < $count; $x++) {
            $tempFile = $_FILES['item-images']['tmp_name'][$x];
            $filename = $_FILES['item-images']['name'][$x];
            $fileType = $_FILES['item-images']['type'][$x];
            $filePath = "./pics/id-" . $itemId . "-" . $filename;
            $imageFilename = "id-" . $itemId . "-" . $filename;

            move_uploaded_file($tempFile, $filePath);

            $sql6 = "INSERT INTO images (image_id, name, path, items_item_id) VALUES
                    (NULL, '$imageFilename', '$filePath', $itemId)";
            $conn->query($sql6);
        }
    }
}
?>

<div class="search-form">
<form name="item-form-values" action="" method="post" enctype="multipart/form-data">
    <b>Typ služby</b><br><br>
    <label><input type="radio" name="radio2" value="Pronájem" <?php
        if (isset($_POST["radio2"])){
            if ($_POST["radio2"] == 'Pronájem'){
                echo "checked";
            }
        }
        ?> checked>Pronájem</label>
    <label><input type="radio" name="radio2" value="Prodej" <?php
        if (isset($_POST["radio2"])){
            if ($_POST["radio2"] == 'Prodej'){
                echo "checked";
            }
        }
        ?>>Prodej</label>
    <br><br>

    <label><b>Titulek</b><input required id="titleValue" type="text" placeholder="Zadejte titulek" name="item-title" value="<?php
        echo (isset($_POST["city"]))?$_POST["city"]:'';
        ?>"></label>
    <br><br>

    <label><b>Místo</b><input required id="cityValue" type="text" placeholder="Zadejte město" name="item-city" value="<?php
        echo (isset($_POST["city"]))?$_POST["city"]:'';
        ?>"></label>
    <br><br>

    <label><b>Co nabízím</b>
        <select name="item-category" id="selectCategory" onchange="categoryChange()">
            <?php
            $categories = getCategories();
            $selectedCategory = '';
            if (isset($_POST["category"])){
                $selectedCategory = $_POST["category"];
            }
            if ($categories->num_rows > 0) {
                while ($rowCategory = $categories->fetch_assoc()) {
                    $category = $rowCategory['name'];
                    ?>
                    <option <?php echo "value=$category"?><?php
                    if ($selectedCategory == $category) {
                        echo " selected";
                    }
                    echo ">$category </option>";
                }
            }
            ?>
        </select>
        <br>
    </label><br>

    <div id="selectRooms">
        <label><b>Počet místností</b>
            <select name="item-rooms">
            <?php
            $rooms = getRooms();
            $selectedRoom = '';
            if (isset($_POST["rooms"])){
                $selectedRoom = $_POST["rooms"];
            }
            if ($rooms->num_rows > 0) {
                while ($rowRoom = $rooms->fetch_assoc()) {
                    $room = $rowRoom['name'];
                    ?>
                    <option <?php echo "value=$room"?><?php
                    if ($selectedRoom == $room) {
                        echo " selected";
                    }
                    echo ">$room </option>";
                }
            }
            ?>
            </select>
        </label>
    </div>
    <br>

    <script>
        function categoryChange() {
            let category = document.getElementById("selectCategory").value;
            let rooms = document.getElementById('selectRooms');
            if(category === "Pozemek"){
                rooms.style.display = 'none';
            } else{
                rooms.style.display = 'block';
            }
        }
    </script>

    <label><b>Cena v Kč</b></label><br>
    <div class="search-from-to">
        <label><input required type="text" placeholder="Cena" name="item-price" value="<?php
            echo (isset($_POST["priceFrom"]))?$_POST["priceFrom"]:'';
            ?>">
        </label>
    </div>
    <br><br>

    <label><b>Plocha v m<sup>2</sup></b></label><br>
    <div class="search-from-to">
        <label><input required type="text" placeholder="Plocha" name="item-area" value="<?php
            echo (isset($_POST["areaFrom"]))?$_POST["areaFrom"]:'';
            ?>">
        </label>
    </div>
    <br><br>

    <label><b>Popis inzerátu</b><br>
    <textarea required placeholder="Popis nového inzerátu..." name="item-description"></textarea></label>
    <br><br>

    <b>Nahrát obrázky</b><br><br>
        <input type="file" name="item-images[]" multiple>
        <br><br>
    <input type="submit" value="Vytvořit inzerát" name="create-ad">
</form>
</div>
