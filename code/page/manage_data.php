<?php
$regionList = getRegions();
$cityList = getCities();
$categoryList = getCategories();
$roomList = getRooms();
$pictureList = getAllPictures();
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div id="data">
            <button id="manage-region" type="button" class="global-button global-button-active">Spravovat regiony</button>
            <button id="manage-city" type="button" class="global-button">Spravovat města</button>
            <button id="manage-category" type="button" class="global-button">Spravovat kategorie</button>
            <button id="manage-room" type="button" class="global-button">Spravovat místnosti</button>
            <button id="manage-image" type="button" class="global-button">Spravovat fotky</button>
            <br><br>

            <div id="div-region">
                <div style="text-align: left"><a class="information-link default" href="?page=add_region">Přidat region</a><br><br></div>
                <div style="overflow-x:auto;">
                <table class='messages-table'>
                    <tr><th>Region</th><th>Editovat</th><th>Odstranit</th></tr>
                    <?php
                    if ($regionList->num_rows > 0) {
                        while ($rowRegion = $regionList->fetch_assoc()) {
                            $regionId = $rowRegion["region_id"];
                            $regionName = $rowRegion["name"];
                            echo "
                            <tr style='border-bottom: 1px solid #cccccc'><td>$regionName</td>
                            <td><a class=\"information-link\" href=\"?page=edit_region&region=$regionId\">Upravit</a></td>
                            <td><a class=\"information-link\" href=\"?page=delete_region&region=$regionId\" onclick=\"return confirm('Opravdu chcete region smazat?')\">Odstranit</a></td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
                </div>
            </div>

            <div id="div-city" style="display: none">
                <div style="text-align: left"><a class="information-link default" href="?page=add_city">Přidat město/obec</a><br><br></div>
                <div style="overflow-x:auto;">
                <table class='messages-table'>
                    <tr><th>Město/Obec</th><th>Region</th><th>Editovat</th><th>Odstranit</th></tr>
                    <?php
                    if ($cityList->num_rows > 0) {
                        while ($rowCity = $cityList->fetch_assoc()) {
                            $cityId = $rowCity["city_id"];
                            $cityName = $rowCity["city"];
                            $cityregionName = $rowCity["region"];
                            echo "
                            <tr style='border-bottom: 1px solid #cccccc'><td>$cityName</td><td>$cityregionName</td>
                            <td><a class=\"information-link\" href=\"?page=edit_city&city=$cityId\">Upravit</a></td>
                            <td><a class=\"information-link\" href=\"?page=delete_city&city=$cityId\" onclick=\"return confirm('Opravdu chcete město smazat?')\">Odstranit</a></td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
                </div>
            </div>

            <div id="div-category" style="display: none">
                <div style="text-align: left"><a class="information-link default" href="?page=add_category">Přidat kategorii</a><br><br></div>
                <div style="overflow-x:auto;">
                <table class='messages-table'>
                    <tr><th>Kategorie</th><th>Editovat</th><th>Odstranit</th></tr>
                    <?php
                    if ($categoryList->num_rows > 0) {
                        while ($rowCategory = $categoryList->fetch_assoc()) {
                            $categoryId = $rowCategory["category_id"];
                            $categoryName = $rowCategory["name"];
                            echo "
                            <tr style='border-bottom: 1px solid #cccccc'><td>$categoryName</td>
                            <td><a class=\"information-link\" href=\"?page=edit_category&category=$categoryId\">Upravit</a></td>
                            <td><a class=\"information-link\" href=\"?page=delete_category&category=$categoryId\" onclick=\"return confirm('Opravdu chcete kategorii smazat?')\">Odstranit</a></td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
                </div>
            </div>

            <div id="div-room" style="display: none">
                <div style="text-align: left"><a class="information-link default" href="?page=add_room">Přidat typ místností</a><br><br></div>
                <div style="overflow-x:auto;">
                <table class='messages-table'>
                    <tr><th>Typ místností</th><th>Editovat</th><th>Odstranit</th></tr>
                    <?php
                    if ($roomList->num_rows > 0) {
                        while ($rowRoom = $roomList->fetch_assoc()) {
                            $roomId = $rowRoom["room_id"];
                            $roomName = $rowRoom["name"];
                            echo "
                            <tr style='border-bottom: 1px solid #cccccc'><td>$roomName</td>
                            <td><a class=\"information-link\" href=\"?page=edit_room&room=$roomId\">Upravit</a></td>
                            <td><a class=\"information-link\" href=\"?page=delete_room&room=$roomId\" onclick=\"return confirm('Opravdu chcete tento typ místností smazat?')\">Odstranit</a></td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
                </div>
            </div>

            <div id="div-image" style="display: none">
                <div style="overflow-x:auto;">
                <table class='messages-table'>
                    <tr><th>Název obrázku</th><th>Cesta k souboru</th><th>Zobrazit</th><th>Editovat</th><th>Odstranit</th></tr>
                    <?php
                    if ($pictureList->num_rows > 0) {
                        while ($rowPicture = $pictureList->fetch_assoc()) {
                            $pictureId = $rowPicture["image_id"];
                            $pictureName = $rowPicture["name"];
                            $picturePath = $rowPicture["path"];
                            echo "
                            <tr style='border-bottom: 1px solid #cccccc'><td>$pictureName</td><td>$picturePath</td>
                            <td><a class=\"information-link\" href=\"?page=view_picture&picture=$pictureId\">Zobrazit</a></td>
                            <td><a class=\"information-link\" href=\"?page=edit_picture&picture=$pictureId\">Upravit</a></td>
                            <td><a class=\"information-link\" href=\"?page=delete_picture&picture=$pictureName\" onclick=\"return confirm('Opravdu chcete fotku smazat?')\">Odstranit</a></td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
                </div>
            </div>

            </div>
            <script>
                let divRegion = document.getElementById('div-region');
                let divCity = document.getElementById('div-city');
                let divCategory = document.getElementById('div-category');
                let divRoom = document.getElementById('div-room');
                let divImage = document.getElementById('div-image');

                let header = document.getElementById("data");
                let buttons = header.getElementsByClassName("global-button");
                for (let i = 0; i < buttons.length; i++) {
                    buttons[i].addEventListener("click", function () {
                        let current = document.getElementsByClassName("global-button-active");
                        current[0].className = current[0].className.replace(" global-button-active", "");
                        this.className += " global-button-active";
                        if (this.id === 'manage-region') {
                            divRegion.style.display = 'block'; divCity.style.display = 'none';
                            divCategory.style.display = 'none'; divRoom.style.display = 'none';
                            divImage.style.display = 'none';
                        }
                        if (this.id === 'manage-city') {
                            divRegion.style.display = 'none'; divCity.style.display = 'block';
                            divCategory.style.display = 'none'; divRoom.style.display = 'none';
                            divImage.style.display = 'none';
                        }
                        if (this.id === 'manage-category') {
                            divRegion.style.display = 'none'; divCity.style.display = 'none';
                            divCategory.style.display = 'block'; divRoom.style.display = 'none';
                            divImage.style.display = 'none';
                        }
                        if (this.id === 'manage-room') {
                            divRegion.style.display = 'none'; divCity.style.display = 'none';
                            divCategory.style.display = 'none'; divRoom.style.display = 'block';
                            divImage.style.display = 'none';
                        }
                        if (this.id === 'manage-image') {
                            divRegion.style.display = 'none'; divCity.style.display = 'none';
                            divCategory.style.display = 'none'; divRoom.style.display = 'none';
                            divImage.style.display = 'block';
                        }
                    });
                }
            </script>

            <?php
            if (isset($_GET["back"])) {
                echo"<script>document.getElementById('manage-image').click();</script>";
            }
            ?>
        </div>
    </div>
</div>


