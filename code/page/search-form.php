<div class="search-form">
    <form name="form-values" action="" method="post">
        <label><input type="radio" name="radio1" value="Pronájem" <?php
            if (isset($_POST["radio1"])){
                if ($_POST["radio1"] == 'Pronájem'){
                    echo "checked";
                }
            }
            ?> checked>Pronájem</label>
        <label><input type="radio" name="radio1" value="Prodej" <?php
            if (isset($_POST["radio1"])){
                if ($_POST["radio1"] == 'Prodej'){
                    echo "checked";
                }
            }
            ?>>Prodej</label>
        <br><br>
        <div id="choice-buttons">
            <button type="button" id="button-region" class="sidenav-button sidenav-button-active">Dle kraje</button>
            <button type="button" id="button-city" class="sidenav-button">Dle města</button>
        </div>

        <script>
                let header = document.getElementById("choice-buttons");
                let buttons = header.getElementsByClassName("sidenav-button");
                for (let i = 0; i < buttons.length; i++) {
                    buttons[i].addEventListener("click", function () {
                        let current = document.getElementsByClassName("sidenav-button-active");
                        current[0].className = current[0].className.replace(" sidenav-button-active", "");
                        this.className += " sidenav-button-active";
                        if (this.id === 'button-region') {
                            document.getElementById("cityValue").value = "";
                        }
                    });
                }
        </script>

        <br>
        <div id="search-city" style="display: none">
            <label><input id="cityValue" type="text" placeholder="Vyhledat město" name="city" value="<?php
                echo (isset($_POST["city"]))?$_POST["city"]:'';
                ?>"></label>
            <br><br>
        </div>

        <div id="search-region">
            <label><select name="region">
                <?php
                $regions = getRegions();
                $selectedRegion = '';
                if (isset($_POST["region"])){
                    $selectedRegion = $_POST["region"];
                }
                if ($regions->num_rows > 0) {
                    while ($rowRegion = $regions->fetch_assoc()) {
                        $region = $rowRegion['name'];
                        ?>
                        <option <?php
                            if ($selectedRegion == $region) {
                                echo "selected";
                            }
                        ?>
                        <?php echo ">$region</option>";
                    }
                }
                ?>
                </select></label>
            <br><br>
        </div>

        <script>
            let buttonCity = document.getElementById('button-city');
            buttonCity.onclick = function() {
                let divCity = document.getElementById('search-city');
                let divRegion = document.getElementById('search-region');
                if (divCity.style.display === 'none') {
                    divCity.style.display = 'block';
                    divRegion.style.display = 'none';
                }
            };

            let buttonRegion = document.getElementById('button-region');
            buttonRegion.onclick = function() {
                let divRegion = document.getElementById('search-region');
                let divCity = document.getElementById('search-city');
                if (divRegion.style.display === 'none') {
                    divRegion.style.display = 'block';
                    divCity.style.display = 'none';
                }
            };
        </script>

        <?php
        if (isset($_POST["city"])) {
            if (empty($_POST["city"])) {
                echo "<script>document.getElementById('button-region').click();</script>";
            } else {
                echo "<script>document.getElementById('button-city').click();</script>";
            }
        }
        ?>

        <label>Co sháním
            <select name="category" id="selectCategory" onchange="categoryChange()">
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
        </label>

        <div id="form-search-checkboxs">
            <br>
            <?php
            $rooms = getRooms();
            if ($rooms->num_rows > 0) {
                while ($rowRoom = $rooms->fetch_assoc()) {
                    $room = $rowRoom['name'];
                    echo "<label>$room
                        <input type='checkbox' name='rooms[]' value='$room'";?><?php
                        if (isset($_POST["rooms"])) {
                            foreach ($_POST["rooms"] as $selectedRoom) {
                                if ($selectedRoom == $room){ echo " checked";}
                            }
                        }
                        echo "></label>";
                }
            }
            ?>
        </div><br>

        <script>
            function categoryChange() {
                let category = document.getElementById("selectCategory").value;
                let checkboxs = document.getElementById('form-search-checkboxs');
                if(category === "Pozemek"){
                    checkboxs.style.display = 'none';
                } else{
                    checkboxs.style.display = 'block';
                }
            }
        </script>

        <label>Cena v Kč</label>
            <div class="search-from-to">
                <label><input type="text" placeholder="Od" name="priceFrom" value="<?php
                        echo (isset($_POST["priceFrom"]))?$_POST["priceFrom"]:'';
                    ?>">
                </label>
                <label><input type="text" placeholder="Do" name="priceTo" value="<?php
                    echo (isset($_POST["priceTo"]))?$_POST["priceTo"]:'';
                    ?>">
                </label>
            </div>
        <br><br>

        <label>Plocha v m<sup>2</sup></label>
            <div class="search-from-to">
                <label><input type="text" placeholder="Od" name="areaFrom" value="<?php
                    echo (isset($_POST["areaFrom"]))?$_POST["areaFrom"]:'';
                    ?>">
                </label>
                <label><input type="text" placeholder="Do" name="areaTo" value="<?php
                    echo (isset($_POST["areaTo"]))?$_POST["areaTo"]:'';
                    ?>">
                </label>
            </div>
        <br><br>
        <input type="submit" value="Vyhledat" name="search">
    </form>
</div>