<?php
if (isset($_POST["add-room"])) {
    $room = $_POST["new-room"];
    if (!existRoom($room)) {
        addRoom($room);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Typ místností byl přidán.</p>
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
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="message-form">
                <form action="" method="post">
                    <label>Nový typ místností<input type="text" placeholder="Název nového typu místností" name="new-room" required></label>
                    <input type="submit" name="add-room" value="Přidat typ místností">
                </form>
            </div>
        </div>
    </div>
</div>
