<?php
if (isset($_GET["room"])) {
    $roomId = $_GET["room"];

    if (!deleteRoom($roomId)){
        echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <br><p>Tento typ místností nelze smazat, protože je obsažen v inzerátu.</p>
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
                        <br><p>Typ místností byl smazán.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=manage_data");
    }
}