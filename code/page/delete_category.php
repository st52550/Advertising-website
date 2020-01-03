<?php
if (isset($_GET["category"])) {
    $categoryId = $_GET["category"];

    if (!deleteCategory($categoryId)){
        echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <br><p>Kategorie nelze smazat,  protože je obsažena v inzerátu.</p>
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
                        <br><p>Kategorie byla smazána.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=manage_data");
    }
}