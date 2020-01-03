<?php
if (isset($_GET["city"])) {
    $cityId = $_GET["city"];

    $city = getCity($cityId);

    if ($city->num_rows > 0) {
        $rowCity = $city->fetch_assoc();
    }

    if (isset($_POST["edit-city"])) {
        $cityName = $_POST["edit-city-name"];
        $regionName = $_POST["edit-region"];

        if (!existCity($cityName)) {
            $regionId = getRegionByName($regionName);
            if ($regionId->num_rows > 0) {
                $rowRegionId = $regionId->fetch_assoc();
            }
            editCity($cityId, $cityName, $rowRegionId["region_id"]);
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Město/obec byl upraven.</p>
                    </div>    
                </div>
            </div>   
            ");
            header("Refresh:1; url=?page=manage_data");
        } else {
            echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Město/obec již existuje.</p>
                    </div>    
                </div>
            </div>   
            ");
        }
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="message-form">
                <form action="" method="post">
                    <label>Název města/obce<input type="text" placeholder="Název nového města/obce" name="edit-city-name" required value="<?php
                        echo $rowCity["city"];
                        ?>"></label>
                    <label>Vyberte region<select name="edit-region">
                            <?php
                            $regions = getRegions();
                            if ($regions->num_rows > 0) {
                                while ($rowRegion = $regions->fetch_assoc()) {
                                    $region = $rowRegion['name'];
                                    ?>
                                    <option <?php echo "value='$region'"?><?php
                                    if ($rowCity["region"] == $region) {
                                        echo " selected";
                                    }
                                    echo ">$region </option>";
                                }
                            }
                            ?>
                        </select></label>
                    <input type="submit" name="edit-city" value="Editovat město/obec">
                </form>
            </div>
        </div>
    </div>
</div>
