<?php
if (isset($_GET["picture"])) {
    $pictureId = $_GET["picture"];
    $picture = getPicturesById($pictureId);

    if ($picture->num_rows > 0) {
        $rowPicture = $picture->fetch_assoc();
        $pictureName = $rowPicture["name"];
        $picturePath = $rowPicture["path"];
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <button type="button" name="back" class="global-button" onclick="location.href='?page=manage_data&back'">&larr; Zpět</button>

            <div class='item-image-container'>
                <?php echo "<img class='item-image-slider' src= '$picturePath' alt='$pictureName'>"; ?>
            </div>
        </div>
    </div>
</div>
