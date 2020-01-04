<?php
$itemsAll = getAllUsersItems();
$itemsExport = getAllUsersItems();
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div id="user-items-list">
                <?php
                if ($itemsExport->num_rows > 0) {
                    echo "
                        <div class=\"message-form\">
                            <form method='post'>
                                <input type='submit' name='export' value='Export inzerátů do XML'>
                            </form>  
                        </div>                    
                        ";

                    if (isset($_POST["export"])) {
                        $x = new XMLWriter();
                        $x->openUri('advertisements_list.xml');
                        $x->startDocument('1.0', 'UTF-8');
                        $x->startElement('advertisements');
                        while ($rowUserItems = $itemsExport->fetch_assoc()) {
                            $itemId = $rowUserItems["item_id"];
                            $publicationDate = $rowUserItems["publication_date"];
                            $modificationDate = $rowUserItems["modification_date"];
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

                            if (empty($room)) {
                                $room = 'Žádné';
                            }

                            $pictures = getPictures($itemId);
                            $picturesCount = $pictures->num_rows;

                            $x->startElement('advertisement');
                            $x->writeAttribute('id', $itemId);

                            $x->startElement('advertiser');
                            $x->text($itemUsername);
                            $x->endElement();

                            $x->startElement('title');
                            $x->text($title);
                            $x->endElement();

                            $x->startElement('publicationdate');
                            $x->text($publicationDate);
                            $x->endElement();

                            $x->startElement('modificationdate');
                            $x->text($modificationDate);
                            $x->endElement();

                            $x->startElement('type');
                            $x->text($type);
                            $x->endElement();

                            $x->startElement('category');
                            $x->text($category);
                            $x->endElement();

                            $x->startElement('city');
                            $x->text($city);
                            $x->endElement();

                            $x->startElement('region');
                            $x->text($region);
                            $x->endElement();

                            $x->startElement('design');
                            $x->text($room);
                            $x->endElement();

                            $x->startElement('area');
                            $x->text($area);
                            $x->endElement();

                            $x->startElement('description');
                            $x->text($description);
                            $x->endElement();

                            $x->endElement();
                        }

                        $x->endElement();
                        $x->endDocument();

                        $x->flush();

                        echo "
                        <div class='export-xml'>
                        <a class='information-link default' id='download' href='advertisements_list.xml' target='_blank'>Zobrazit</a>
                        <a class='information-link default' id='download' href='advertisements_list.xml' download='advertisements_list'>Stáhnout</a><br><br>
                        </div>";
                    }
                }

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
                            <span class='item-date'>$modificationDate</span>
                            <span class='item-date' style='background: #84B3E7'>$itemUsername</span><br><br>
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
