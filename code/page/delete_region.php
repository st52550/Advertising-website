<?php
if (isset($_GET["region"])) {
    $regionId = $_GET["region"];

    if (!deleteRegion($regionId)){
        echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <br><p>Region nelze smazat, protože obsahuje města.</p>
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
                        <br><p>Region byl smazán.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=manage_data");
    }
}