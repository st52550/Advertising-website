<?php
$actualUserId = '';
if (isset($_SESSION["user_id"])) {
    $actualUserId = $_SESSION["user_id"];
}

$userItems = getItemsByUserId($actualUserId);
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <button id="new-item" type="button" class="global-button">Nový inzerát</button>
            <button id="user-items" type="button" class="global-button global-button-active">Moje inzeráty</button>
            <br><br>

            <div id="user-items-list">
            <?php
                if (isset($_POST["create-ad"])) {
                    echo "
                    <div class=\"new-ad-form-alert\">
                        <p>Inzerát byl úspěšně vložen.</p>
                    </div><br>
                    ";
                    header("Refresh:1; url=?page=my_ads");
                }

                if ($userItems->num_rows > 0) {
                    while ($rowUserItems = $userItems->fetch_assoc()) {
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
                    echo "<b>Nemáte žádné inzeráty</b>";
                }
                ?>
            </div>

            <div id="add-new-item">
                <?php include "new_ad.php" ?>
            </div>

            <script>
                let buttonNewItem = document.getElementById('new-item');
                let buttonUserItems = document.getElementById('user-items');
                let divNewItem = document.getElementById('add-new-item');
                let divUserItems = document.getElementById('user-items-list');

                buttonNewItem.onclick = function() {
                    divNewItem.style.display = 'block';
                    divUserItems.style.display = 'none';
                    this.className = 'global-button global-button-active';
                    buttonUserItems.className = 'global-button';
                };
                buttonUserItems.onclick = function() {
                    divNewItem.style.display = 'none';
                    divUserItems.style.display = 'block';
                    this.className = 'global-button global-button-active';
                    buttonNewItem.className = 'global-button';
                };
            </script>
        </div>
    </div>
</div>
