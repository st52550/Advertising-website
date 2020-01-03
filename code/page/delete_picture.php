<?php
if (isset($_GET["picture"])) {
    $imageName = $_GET["picture"];

    deleteImage($imageName);

    echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Fotka byla smazána.</p>
                    </div>    
                </div>
            </div>   
            ");
    header("Refresh:1; url=?page=manage_data");
}