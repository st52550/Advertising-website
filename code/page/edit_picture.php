<?php
if (isset($_GET["picture"])) {
    $pictureId = $_GET["picture"];

    $picture = getPicturesById($pictureId);

    if ($picture->num_rows > 0) {
        $rowPicture = $picture->fetch_assoc();
    }

    if (isset($_POST["edit-image"])) {
        $pictureName = $_POST["edit-image-name"];
        $picturePath = $_POST["edit-image-path"];

        editPicture($pictureId, $pictureName, $picturePath);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Fotka byla upravena.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=manage_data");
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="message-form">
                <form action="" method="post">
                    <label>Název obrázku<input type="text" placeholder="Název obrázku" name="edit-image-name" required value="<?php
                        echo $rowPicture["name"];
                        ?>"></label>
                    <label>Cesta k souboru<input type="text" placeholder="Cesta k souboru" name="edit-image-path" required value="<?php
                        echo $rowPicture["path"];
                        ?>"></label>
                    <input type="submit" name="edit-image" value="Editovat obrázek">
                </form>
            </div>
        </div>
    </div>
</div>
