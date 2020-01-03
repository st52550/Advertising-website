<?php
if (isset($_GET["region"])) {
    $regionId = $_GET["region"];

    $region = getRegion($regionId);

    if ($region->num_rows > 0) {
        $rowRegion = $region->fetch_assoc();
    }

    if (isset($_POST["edit-region"])) {
        $regionName = $_POST["edit-region-name"];
        if (!existRegion($regionName)) {
            editRegion($regionId, $regionName);
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Region byl upraven.</p>
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
                        <p>Region již existuje.</p>
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
                    <label>Název kraje<input type="text" placeholder="Název nového kraje" name="edit-region-name" required value="<?php
                        echo $rowRegion["name"];
                        ?>"></label>
                    <input type="submit" name="edit-region" value="Editovat kraj">
                </form>
            </div>
        </div>
    </div>
</div>
