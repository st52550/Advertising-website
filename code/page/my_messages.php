<?php
$actualUserId = '';
if (isset($_SESSION["user_id"])) {
    $actualUserId = $_SESSION["user_id"];
}

$messagesIds = getMessagesIds($actualUserId);
$messagesPosition = 1;
include 'send_message.php';
?>
<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <button id="new" type="button" class="global-button">Nová zpráva</button>
            <button id="delivered" class="global-button global-button-active">Doručené zprávy</button>
            <button id="sent" class="global-button">Odeslané zprávy</button>
            <br><br>
        <div id="divs">
            <div id="delivered-messages">
                <?php
                if ($messagesIds->num_rows > 0) {
                    while ($rowMessageId = $messagesIds->fetch_assoc()) {
                        $messages = getMessages($rowMessageId["messages_message_id"]);
                        if ($messages->num_rows > 0) {
                            while ($rowMessage = $messages->fetch_assoc()) {
                                $id = $rowMessage["message_id"];
                                $senderName = $rowMessage["sender_name"];
                                $senderEmail = $rowMessage["sender_email"];
                                try {
                                    $publicationDate = date_format(new DateTime($rowMessage["publication_date"]), "d.m.Y H:i:s");
                                } catch (Exception $e){echo 'Message: ' .$e->getMessage();}
                                $message = $rowMessage["message"];
                                $readed = $rowMessage["readed"];

                                echo "
                                <table class='messages-table'>
                                <tr>
                                <td><b>$senderName</b></td>
                                <td>$senderEmail</td>
                                <td>$publicationDate</td>
                                <td><button id='pos $messagesPosition' type='button' class='pos global-button' onclick='showHideMessage(this.id)'>Zobrazit/skrýt zprávu</button></td>                           
                                </tr>
                                </table>
                                ";

                                if ($readed == 0) {
                                    echo "
                                    <div class='pos $messagesPosition' style='display: block'>
                                        <div id='message-text'>
                                            $message;
                                        </div>
                                    </div>
                                    ";
                                    markReaded($id);
                                } else {
                                    echo "
                                    <div class='pos $messagesPosition' style='display: none'>
                                        <div id='message-text'>
                                            $message;
                                        </div>
                                    </div>
                                    ";
                                }
                                $messagesPosition++;
                            }
                        }
                    }
                } else {
                    echo "<b>Žádné doručené zprávy</b>";
                }
                ?>
            </div>

            <div id="new-message" style="display: none">
                <div class="message-form">
                    <form action="" method="post">
                        <label>Komu:<input type="text" placeholder="Uživatelské jméno (více adresátů oddělujte čárkou)" name="recipients" required></label>
                        <label>Zpráva:<textarea name="user-message" placeholder="Vaše zpráva..." required></textarea></label>
                        <input type="submit" name="send-user-message" value="Odeslat zprávu">
                    </form>
                </div>
            </div>

            <div id="sent-messages" style="display: none">
                <?php
                $messages = getUserMessages($actualUserId);
                if ($messages->num_rows > 0) {
                    while ($rowMessage = $messages->fetch_assoc()) {
                        $id = $rowMessage["message_id"];
                        try {
                            $publicationDate = date_format(new DateTime($rowMessage["publication_date"]), "d.m.Y H:i:s");
                        } catch (Exception $e){echo 'Message: ' .$e->getMessage();}
                        $message = $rowMessage["message"];
                        $readed = $rowMessage["readed"];
                        $readedMessage = '';
                        if ($readed == 0){
                            $readedMessage = 'NE';
                        } else {
                            $readedMessage = 'ANO';
                        }

                        $recipients = getRecipients($id);
                        $recipientsNames = '';
                        $recipientsMails = '';
                        if ($recipients->num_rows > 0) {
                            while ($rowRecipient = $recipients->fetch_assoc()) {
                                $recipientsNames = $recipientsNames." ".$rowRecipient["username"].", ";
                                $recipientsMails = $recipientsMails." ".$rowRecipient["email"].", ";
                            }
                        }

                        echo "
                        <table class='messages-table'>
                        <tr>
                        <td><b>$recipientsNames</b></td>
                        <td>$recipientsMails</td>
                        <td>$publicationDate</td>
                        <td>Přečteno: $readedMessage</td>
                        <td><button id='pos $messagesPosition' type='button' class='pos global-button' onclick='showHideMessage(this.id)'>Zobrazit/skrýt zprávu</button></td>                        
                        </tr>
                        </table>
                        
                        <div class='pos $messagesPosition' style='display: none'>
                            <div id='message-text'>
                                $message;
                            </div>
                        </div>
                        ";
                        $messagesPosition++;
                    }
                } else {
                    echo "<b>Žádné odeslané zprávy</b>";
                }
                ?>
            </div>
        </div>
            <script>
                function showHideMessage(button_id) {
                    let header = document.getElementById("divs");
                    let divsMessages = header.getElementsByClassName("pos");
                    for (let i = 1; i <= divsMessages.length; i++) {
                        if (button_id === divsMessages[i].className) {
                            if (divsMessages[i].style.display === 'none') {
                                divsMessages[i].style.display = 'block';
                            } else {
                                divsMessages[i].style.display = 'none';
                            }
                        }
                    }
                }

                let buttonNew = document.getElementById('new');
                let buttonDelivered = document.getElementById('delivered');
                let buttonSent = document.getElementById('sent');
                let divNew = document.getElementById('new-message');
                let divDelivered = document.getElementById('delivered-messages');
                let divSent = document.getElementById('sent-messages');

                buttonNew.onclick = function() {
                    divNew.style.display = 'block';
                    divDelivered.style.display = 'none';
                    divSent.style.display = 'none';
                    this.className = 'global-button global-button-active';
                    buttonDelivered.className = 'global-button';
                    buttonSent.className = 'global-button';
                };
                buttonDelivered.onclick = function() {
                    divNew.style.display = 'none';
                    divDelivered.style.display = 'block';
                    divSent.style.display = 'none';
                    this.className = 'global-button global-button-active';
                    buttonNew.className = 'global-button';
                    buttonSent.className = 'global-button';
                };
                buttonSent.onclick = function() {
                    divNew.style.display = 'none';
                    divDelivered.style.display = 'none';
                    divSent.style.display = 'block';
                    this.className = 'global-button global-button-active';
                    buttonNew.className = 'global-button';
                    buttonDelivered.className = 'global-button';
                };
            </script>
        </div>
    </div>
</div>
