<form action="" method="post">
    <label>Pronájem<input type="radio" name="radio1" value="Radio 1" checked></label>
    <label>Prodej<input type="radio" name="radio1" value="Radio 2"></label>
    <br><br>
    <div id="choice-buttons">
        <button type="button" id="button-city" class="sidenav-button sidenav-button-active">Dle města</button>
        <button type="button" id="button-region" class="sidenav-button">Dle kraje</button>
    </div>

    <script>
        let header = document.getElementById("choice-buttons");
        let buttons = header.getElementsByClassName("sidenav-button");
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener("click", function() {
                let current = document.getElementsByClassName("sidenav-button-active");
                current[0].className = current[0].className.replace(" sidenav-button-active", "");
                this.className += " sidenav-button-active";
            });
        }
    </script>

    <br>
    <div id="search-city">
        <div class="search-form">
            <label><input type="text" placeholder="Vyhledat město" name="mesto"></label>
        </div><br>
    </div>

    <div id="search-region" style="display: none">
        <label><select>
            <?php
            $regions = getRegions();
            if ($regions->num_rows > 0) {
                while ($rowRegion = $regions->fetch_assoc()) {
                    $region = $rowRegion['name'];
                    echo "<option>$region</option>";
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

    <label>Co sháním:
        <select>
            <?php
            $categories = getCategories();
            if ($categories->num_rows > 0) {
                while ($rowCategory = $categories->fetch_assoc()) {
                    $category = $rowCategory['name'];
                    echo "<option>$category</option>";
                }
            }
            ?>
        </select>
        <br><br>
    </label>
</form>
