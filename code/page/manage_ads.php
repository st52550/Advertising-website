<?php
$itemsAll = getAllUsersItems();
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div id="user-items-list">
                <?php
                if ($itemsAll->num_rows > 0) {
                    while ($rowUserItems = $itemsAll->fetch_assoc()) {
                        $itemId = $rowUserItems["item_id"];
                        try {
                            $publicationDate = date_format(new DateTime($rowUserItems["publication_date"]), "d.m.Y H:i:s");
                            $modificationDate = date_format(new DateTime($rowUserItems["modification_date"]), "d.m.Y H:i:s");
                        } catch (Exception $e){echo 'Message: ' .$e->getMessage();}
                        $price = number_format($rowUserItems["price"], 0, '.', ' ');
                        $area = $rowUserItems["area"];
                        $itemUsername = $rowUserItems["username"];
                        $category = $rowUserItems["category"];
                        $title = $rowUserItems["title"];
                        $description = $rowUserItems["description"];
                        $city = $rowUserItems["city"];
                        $region = $rowUserItems["region"];
                        $room = $rowUserItems["room"];
                        $type = $rowUserItems["type"];

                        $pictures = getPictures($itemId);
                        ?>
                        <div class="user-item-row">
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
                            <a class=\"information-link\" href=\"?page=edit_ad&item=$itemId\">Upravit</a>
                            <a class=\"information-link\" href=\"?page=delete_ad&item=$itemId\" onclick=\"return confirm('Opravdu chcete inzerát smazat?')\">Odstranit</a>
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
                    echo "<b>Žádné inzeráty k dispozici.</b>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
