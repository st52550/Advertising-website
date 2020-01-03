<?php
if (isset($_GET["item"])) {
    $itemId = $_GET["item"];

    $item = getItem($itemId);
    if ($item->num_rows > 0) {
        $rowItem = $item->fetch_assoc();
    }

    $pictures = getPictures($itemId);

    if (isset($_POST["edit-ad"])) {
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
            $sql5 = "UPDATE items SET modification_date = NOW(), price = $price, categories_category_id = $categoryId,
                     title = '$title', description = '$descripton', cities_city_id = $cityId, rooms_room_id = $roomId,
                     type = '$type', area = $area WHERE item_id = $itemId";
        } else {
            $sql5 = "UPDATE items SET modification_date = NOW(), price = $price, categories_category_id = $categoryId,
                     title = '$title', description = '$descripton', cities_city_id = $cityId, type = '$type', area = $area 
                     WHERE item_id = $itemId";
        }
        $conn->query($sql5);

        $count = 0;
        if(!empty($_FILES['item-images1']['name'])) {
            $count = count(array_filter($_FILES['item-images1']['name']));
        }

        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $tempFile = $_FILES['item-images1']['tmp_name'][$x];
                $filename = $_FILES['item-images1']['name'][$x];
                $fileType = $_FILES['item-images1']['type'][$x];
                $filePath = "./pics/id-" . $itemId . "-" . $filename;
                $imageFilename = "id-" . $itemId . "-" . $filename;

                move_uploaded_file($tempFile, $filePath);
                $sql6 = "INSERT INTO images (image_id, name, path, items_item_id) VALUES
                    (NULL, '$imageFilename', '$filePath', $itemId)";
                $conn->query($sql6);
            }
        }
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="search-form">
                <form name="item-form-values" action="" method="post" enctype="multipart/form-data">
                    <b>Typ služby</b><br><br>
                    <label><input type="radio" name="radio2" value="Pronájem" <?php
                            if ($rowItem["type"] == 'Pronájem'){
                                echo "checked";
                            }
                        ?> checked>Pronájem</label>
                    <label><input type="radio" name="radio2" value="Prodej" <?php
                            if ($rowItem["type"] == 'Prodej'){
                                echo "checked";
                        }
                        ?>>Prodej</label>
                    <br><br>

                    <label><b>Titulek</b><input required id="titleValue" type="text" placeholder="Zadejte titulek" name="item-title" value="<?php
                        echo $rowItem["title"];
                        ?>"></label>
                    <br><br>

                    <label><b>Místo</b><input required id="cityValue" type="text" placeholder="Zadejte město" name="item-city" value="<?php
                        echo $rowItem["city"];
                        ?>"></label>
                    <br><br>

                    <label><b>Co nabízím</b>
                        <select name="item-category" id="selectCategory" onchange="categoryChange()">
                            <?php
                            $categories = getCategories();
                            if ($categories->num_rows > 0) {
                                while ($rowCategory = $categories->fetch_assoc()) {
                                    $category = $rowCategory['name'];
                                    ?>
                                    <option <?php echo "value=$category"?><?php
                                    if ($rowItem["category"] == $category) {
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
                                if ($rooms->num_rows > 0) {
                                    while ($rowRoom = $rooms->fetch_assoc()) {
                                        $room = $rowRoom['name'];
                                        ?>
                                        <option <?php echo "value=$room"?><?php
                                        if ($rowItem["room"] == $room) {
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

                    <?php
                    if (empty($rowItem["room"])){
                        echo "<script>categoryChange();</script>";
                    }
                    ?>

                    <label><b>Cena v Kč</b></label><br>
                    <div class="search-from-to">
                        <label><input required type="text" placeholder="Cena" name="item-price" value="<?php
                            echo $rowItem["price"];
                            ?>">
                        </label>
                    </div>
                    <br><br>

                    <label><b>Plocha v m<sup>2</sup></b></label><br>
                    <div class="search-from-to">
                        <label><input required type="text" placeholder="Plocha" name="item-area" value="<?php
                            echo $rowItem["area"];
                            ?>">
                        </label>
                    </div>
                    <br><br>

                    <label><b>Popis inzerátu</b><br>
                        <textarea required placeholder="Popis nového inzerátu..." name="item-description"><?php echo $rowItem["description"];?></textarea></label>
                    <br><br>

                    <b>Fotky</b><br>
                    <?php
                    $nameArray = array();
                    if ($pictures->num_rows > 0) {
                        echo "<div class='item-image-container'>";
                        $imageCount = $pictures->num_rows;
                        while ($rowPicture = $pictures->fetch_assoc()) {
                            $pictureId = $rowPicture["image_id"];
                            $pictureName = $rowPicture["name"];
                            $picturePath = $rowPicture["path"];
                            array_push($nameArray, $pictureName);
                            echo "<img class='item-image-slider' src= '$picturePath' alt='$pictureName'>";
                        }
                        echo "                       
                    </div>
                    <button type='button' class=\"slide-button\" onclick=\"plusDivs(-1)\">&#10094; Předchozí</button>  
                    <button type='button' class=\"slide-button\" onclick=\"plusDivs(1)\">Další &#10095;</button><br> 
                    <table>                             
                    ";
                        $arrayIndex = 0;
                        for ($x = 1; $x <= $imageCount; $x++) {
                            echo "<tr>
                                    <td><button type='button' class=\"slide-button mark\" onclick=\"currentDiv('$x')\">$x</button></td>
                                    <td>$nameArray[$arrayIndex]</td>
                                    <td><a class=\"information-link\" href=\"?page=delete_image&image=$nameArray[$arrayIndex]\" onclick=\"return confirm('Opravdu chcete fotku smazat?')\">Odstranit</a></td>
                                    </tr> ";
                            $arrayIndex++;
                        }
                        echo "                       
                    </table> 
                    <script>
                    /* Kod tohoto scriptu byl prevzat z https://www.w3schools.com/w3css/w3css_slideshow.asp */
                    let slideIndex = 1;
                        showDivs(slideIndex);
                        
                        function plusDivs(n) {
                          showDivs(slideIndex += n);
                        }
                        
                        function currentDiv(n) {
                          showDivs(slideIndex = n);
                        }
                        
                        function showDivs(n) {
                          let i;
                          let x = document.getElementsByClassName(\"item-image-slider\");
                          let dots = document.getElementsByClassName(\"mark\");
                          if (n > x.length) {slideIndex = 1}    
                          if (n < 1) {slideIndex = x.length}
                          for (i = 0; i < x.length; i++) {
                            x[i].style.display = \"none\";  
                          }
                          for (i = 0; i < dots.length; i++) {
                            dots[i].className = dots[i].className.replace(\" slide-button-active\", \"\");
                          }
                          x[slideIndex-1].style.display = \"block\";  
                          dots[slideIndex-1].className += \" slide-button-active\";
                        }
                    </script>
                    ";
                    } else {
                        echo "Fotky nebyly přidány.<br><br>";
                    }
                    ?>

                    <br>
                    <b>Přidat fotky</b><br><br>
                        <input type="file" name="item-images1[]" multiple>
                        <br><br>
                        <input type="submit" value="Upravit inzerát" name="edit-ad">
                </form>
            </div>
        </div>
    </div>
</div>