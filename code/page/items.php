<?php
if (isset($_POST["search"])) {
    $typeValue = $_POST["radio1"];
    $cityValue = $_POST["city"];
    $regionValue = $_POST["region"];
    $categoryValue = $_POST["category"];
    if (isset($_POST["rooms"])) {
        $roomsValues = $_POST["rooms"];
    } else {
        $roomsValues = '';
    }
    $priceFrom = $_POST["priceFrom"];
    $priceTo = $_POST["priceTo"];
    $areaFrom = $_POST["areaFrom"];
    $areaTo = $_POST["areaTo"];

    $items = getItems($typeValue, $cityValue, $regionValue, $categoryValue, $roomsValues,
        $priceFrom, $priceTo, $areaFrom, $areaTo);
} else {
    $type ='Pronájem';
    $items = getAllItems($type);
}

if ($items->num_rows > 0) {
    while ($rowItem = $items->fetch_assoc()) {
        $itemId = $rowItem["item_id"];
        try {
            $publicationDate = date_format(new DateTime($rowItem["publication_date"]), "d.m.Y H:i:s");
            $modificationDate = date_format(new DateTime($rowItem["modification_date"]), "d.m.Y H:i:s");
        } catch (Exception $e){echo 'Message: ' .$e->getMessage();}
        $price = number_format($rowItem["price"], 0, '.', ' ');
        $area = $rowItem["area"];
        $itemUsername = $rowItem["username"];
        $category = $rowItem["category"];
        $title = $rowItem["title"];
        $description = $rowItem["description"];
        $city = $rowItem["city"];
        $region = $rowItem["region"];
        $room = $rowItem["room"];
        $type = $rowItem["type"];

        $pictures = getPictures($itemId);
        ?>

        <div class="item-row">
            <?php
            echo "
            <div class='information'>
                <span class='item-date'>$modificationDate</span><br><br>
                <span class='item-title'>$title</span><br><br>                                         
                <span><b>$city</b></span><br>
                <span>$region</span><br><br>
                <span>Počet pokojů: $room</span><br>
                <span>Plocha: $area m<sup>2</sup></span><br><br>                      
            ";
            if ($type == 'Pronájem'){
                echo "<span>Pronájem: <b>$price Kč</b>/měsíc</span>";
            } else if ($type == 'Prodej') {
                echo "<span>Prodej: <b>$price Kč</b></span>";
            }
            echo "
                &rarr; <a class=\"information-link\" href=\"?page=details&item=$itemId\">Zobrazit detaily</a>
            </div>
            ";
            if ($pictures->num_rows > 0) {
                $rowPicture = $pictures->fetch_assoc();
                $pictureId = $rowPicture["image_id"];
                $pictureName = $rowPicture["name"];
                $picturePath = $rowPicture["path"];

                echo "
                <div class='image-container'>
                    <img src= '$picturePath' alt='$pictureName'>
                </div>
                ";
            } else {
                echo "
                <div class='image-container'>
                    <img src= './img/no-image.PNG' alt='no-image'>
                </div>
                ";
            }
            ?>
        </div>
        <?php
    }
} else {
    echo "
    <div style=\"text-align: center\">
        <h4>Zadaným parametrům neodpovídá žádný inzerát.</h4>
    </div>";
}



