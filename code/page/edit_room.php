<?php
if (isset($_GET["room"])) {
    $roomId = $_GET["room"];

    $room = getRoom($roomId);

    if ($room->num_rows > 0) {
        $rowRoom = $room->fetch_assoc();
    }

    if (isset($_POST["edit-room"])) {
        $roomName = $_POST["edit-room-name"];
        if (!existRoom($roomName)) {
            editRoom($roomId, $roomName);
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Typ místností byl upraven.</p>
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
                        <p>Tento typ místností již existuje.</p>
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
                    <label>Typ místností<input type="text" placeholder="Název nového kraje" name="edit-room-name" required value="<?php
                        echo $rowRoom["name"];
                        ?>"></label>
                    <input type="submit" name="edit-room" value="Editovat typ místností">
                </form>
            </div>
        </div>
    </div>
</div>

