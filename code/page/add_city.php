<?php
if (isset($_POST["add-city"])) {
    $city = $_POST["new-city"];
    $regionName = $_POST["region"];

    if (!existCity($city)) {
        $regionId = getRegionByName($regionName);
        if ($regionId->num_rows > 0) {
            $rowRegionId = $regionId->fetch_assoc();
        }
        addCity($city, $rowRegionId["region_id"]);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Město/obec byl přidán.</p>
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
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="message-form">
                <form action="" method="post">
                    <label>Název města/obce<input type="text" placeholder="Název nového města/obce" name="new-city" required></label>
                    <label>Vyberte region<select name="region">
                        <?php
                        $regions = getRegions();
                        if ($regions->num_rows > 0) {
                            while ($rowRegion = $regions->fetch_assoc()) {
                                $region = $rowRegion['name'];
                                ?>
                                <option <?php echo "value='$region'"?><?php
                                echo ">$region </option>";
                            }
                        }
                        ?>
                    </select></label>
                    <input type="submit" name="add-city" value="Přidat město/obec">
                </form>
            </div>
        </div>
    </div>
</div>
