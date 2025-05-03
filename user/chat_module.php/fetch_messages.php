<?php
include "../db_conn.php"; 

$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;

if ($user_id !== null) {
    $admin_id = 0; 
    $sqlMessages = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp";
    $stmt = $conn->prepare($sqlMessages);
    $stmt->bind_param("iiii", $admin_id, $user_id, $user_id, $admin_id);
    $stmt->execute();
    $resultMessages = $stmt->get_result();
    $stmt->close();

    
    $selected_user_name = '';
    $sqlSelectedUser = "SELECT uname FROM users WHERE id = ?";
    $stmt = $conn->prepare($sqlSelectedUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($uname);
    if ($stmt->fetch()) {
        $selected_user_name = $uname;
    }
    $stmt->close();

    while ($chat = $resultMessages->fetch_assoc()) {
        echo '<div class="message ' . (($chat['sender_id'] == $admin_id) ? 'sent' : 'received') . '">';
        echo '<p>' . $chat['message'] . '</p>';
        echo '<div class="meta">';
        if ($chat['sender_id'] == $admin_id) {
            echo '<span class="sender">Admin</span>';
        } else {
            echo '<span class="sender">' . $selected_user_name . '</span>';
        }
        echo '<span class="timestamp">' . $chat['timestamp'] . '</span>';
        echo '</div>';
        echo '</div>';
    }
}
?>
