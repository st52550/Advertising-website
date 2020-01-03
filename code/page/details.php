<?php
if (isset($_GET["item"])) {
    $idItem = $_GET["item"];
    $item = getItem($idItem);
    if ($item->num_rows > 0) {
        $row = $item->fetch_assoc();
    }

    try {
        $itemPublicationDate = date_format(new DateTime($row["publication_date"]), "d.m.Y H:i:s");
        $itemModificationDate = date_format(new DateTime($row["modification_date"]), "d.m.Y H:i:s");
    } catch (Exception $e){echo 'Message: ' .$e->getMessage();}
    $itemPrice = number_format($row["price"], 0, '.', ' ');
    $itemUser = $row["username"];
    $itemUserMail = $row["email"];
    $itemCategory = $row["category"];
    $itemTitle = $row["title"];
    $itemDescription = $row["description"];
    $itemCity = $row["city"];
    $itemRegion = $row["region"];
    $itemRoom = $row["room"];
    $itemArea = $row["area"];
    $itemType = $row["type"];

    $pictures = getPictures($idItem);

    $actualUserMail = '';
    if (isset($_SESSION["user_email"])) {
        $actualUserMail = $_SESSION["user_email"];
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <h2>Detaily inzerátu</h2>

            <?php
                echo "
                    <h3>$itemTitle</h3>
                    <table>
                        <tr><td>Přidán:</td><td>$itemPublicationDate</td></tr>
                        <tr><td>Poslední aktualizace:</td><td>$itemModificationDate</td></tr>
                        <tr><td><br></td></tr>
                        <tr><td>Typ:</td><td>$itemType</td></tr>
                        <tr><td>Kategorie:</td><td>$itemCategory</td></tr>
                        <tr><td><br></td></tr>
                        <tr><td>Místo:</td><td>$itemCity</td></tr>
                        <tr><td>Kraj:</td><td>$itemRegion</td></tr>
                        <tr><td><br></td></tr>
                        <tr><td>Počet místností:</td><td>$itemRoom</td></tr>
                        <tr><td>Plocha:</td><td>$itemArea m<sup>2</sup></td></tr>
                        <tr><td><br></td></tr>
                        ";
                        if ($itemType == 'Pronájem'){
                            echo "<tr><td>Cena:</td><td><b>$itemPrice Kč/měsíc</b></td></tr>";
                        } else if ($itemType == 'Prodej') {
                            echo "<tr><td>Cena:</td><td><b>$itemPrice Kč</b></td></tr>";
                        }
                        echo "                       
                    </table>
                    <p>Inzerent: <b>$itemUser</b></p>
                    <div class='item-description'>
                        <h3>Popis</h3>
                        $itemDescription
                    </div>                   
                    <h3>Fotky</h3>      
                    <div class='item-image-container'>             
                    ";

                if ($pictures->num_rows > 0) {
                    $imageCount = $pictures->num_rows;
                    while ($rowPicture = $pictures->fetch_assoc()) {
                        $pictureId = $rowPicture["image_id"];
                        $pictureName = $rowPicture["name"];
                        $picturePath = $rowPicture["path"];
                        echo "<img class='item-image-slider' src= '$picturePath' alt='$pictureName'>";
                    }
                    echo "                       
                    </div>
                    <button class=\"slide-button\" onclick=\"plusDivs(-1)\">&#10094; Předchozí</button>                                  
                    ";
                    for ($x = 1; $x <= $imageCount; $x++) {
                        echo "<button class=\"slide-button mark\" onclick=\"currentDiv('$x')\">$x</button> ";
                    }
                    echo "
                        <button class=\"slide-button\" onclick=\"plusDivs(1)\">Další &#10095;</button>
 
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
                    echo "<img src= './img/no-image.PNG' alt='no-image'></div>";
                }
                if ($itemUserMail != $actualUserMail) {
                    echo "     
                    <h3 style='margin-top: 30px'>Kontaktovat</h3>
                    <div class=\"message-form\">
                        <form action=\"\" method=\"post\">
                            <label>Komu:<input type=\"text\" value=\"$itemUserMail\" name=\"recipient-mail\" readonly></label>
                            <label>Vaše jméno:<input type=\"text\" placeholder=\"Vaše přezdívka\" name=\"sender-name\" required></label>
                            <label>E-mail:<input type=\"email\" placeholder=\"Váš e-mail\" name=\"sender-email\" required></label>
                            <label>Zpráva:<textarea name=\"message\" placeholder=\"Vaše zpráva...\" required></textarea></label>
                            <input type=\"submit\" name=\"send-message\" value=\"Odeslat zprávu\">
                        </form>
                    </div>
                    ";
                } else {
                    echo " 
                    <br><br><div>    
                    <a class=\"information-link\" href=\"?page=edit_ad&item=$idItem\">Upravit</a>
                    <a class=\"information-link\" href=\"?page=delete_ad&item=$idItem\" onclick=\"return confirm('Opravdu chcete inzerát smazat?')\">Odstranit</a>
                    </div>
                    ";
                }

            include 'send_message.php';
            ?>
        </div>
    </div>
</div>
