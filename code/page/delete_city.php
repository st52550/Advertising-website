<?php
if (isset($_GET["city"])) {
    $cityId = $_GET["city"];

    if (!deleteCity($cityId)){
        echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <br><p>Město/obec nelze smazat, protože je obsaženo v inzerátu.</p>
                    </div> 
                    <br><br>   
                </div>
            </div>   
        ");
        header("Refresh:4; url=?page=manage_data");
    } else {
        echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Město/obec byl smazán.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=manage_data");
    }
}