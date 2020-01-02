<?php
if (isset($_POST["send-message"])) {
    $recipientEmail = $_POST["recipient-mail"];
    $senderEmail = $_POST["sender-email"];
    $username = $_POST["sender-name"];
    $message = $_POST["message"];

    if (isset($_SESSION["user_email"])) {
        $user = getByUserEmail($_SESSION["user_email"]);
        if ($user->num_rows > 0) {
            $rowUser = $user->fetch_assoc();
            $senderId = $rowUser["user_id"];
            insertMessageExistingUser($recipientEmail, $senderEmail, $username, $message, $senderId);
            echo "
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"message-form-alert\">
                        <p>Zpráva byla úspěšně odeslána.</p>
                    </div>
                </div>
            </div>
            ";
        }
    } else {
        insertMessage($recipientEmail, $senderEmail, $username, $message);
        echo "
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"message-form-alert\">
                        <p>Zpráva byla úspěšně odeslána.</p>
                    </div>
                </div>
            </div>
            ";
    }

}

if (isset($_POST["send-user-message"])) {
    $recipientsUsernames = $_POST["recipients"];
    $userMessage = $_POST["user-message"];

    if (isset($_SESSION["user_email"])) {
        $userMessageUser = getByUserEmail($_SESSION["user_email"]);
        if ($userMessageUser->num_rows > 0) {
            $rowUserMessageUser = $userMessageUser->fetch_assoc();
            $userMessageSenderId = $rowUserMessageUser["user_id"];
            insertUserMessage($recipientsUsernames, $userMessageSenderId, $userMessage);
            echo "
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"message-form-alert\">
                        <p>Zpráva byla úspěšně odeslána.</p>
                    </div>
                </div>
            </div>
            ";
        }
    }
}
