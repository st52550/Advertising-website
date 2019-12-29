<?php
if (isset($_POST["search"])) {
    echo "jo";
} else {
    $items = getAllItems();
    if ($items->num_rows > 0) {
        while ($rowItem = $items->fetch_assoc()) {
            $itemId = $rowItem["item_id"];
            $publicationDate = $rowItem["publication_date"];
            $price = $rowItem["price"];
            $itemUsername = $rowItem["username"];
            $category = $rowItem["category"];
            $title = $rowItem["title"];
            $description = $rowItem["description"];
            $city = $rowItem["city"];
            $region = $rowItem["region"];
            $room = $rowItem["room"];
            $type = $rowItem["type"];

            echo $itemId;
            echo $publicationDate;
            echo $price;
            echo $itemUsername;
            echo $category;
            echo $title;
            echo $description;
            echo $city;
            echo $region;
            echo $room;
            echo $type;
            ?>

            <div class="item-row">
                <?php
                echo "
                    <span class='item-title'>$title</span>
                    <span class='item-date'>$publicationDate</span>
                    "
                ?>
            </div>
        <?php
        }
    }
}

