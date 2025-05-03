<?php
include "..\..\db_conn.php";


$admin_id = 0; 


$sqlUsers = "SELECT id, uname FROM users";
$resultUsers = $conn->query($sqlUsers);


$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;
if ($user_id !== null) {
    $sqlMessages = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp";
    $stmt = $conn->prepare($sqlMessages);
    $stmt->bind_param("iiii", $admin_id, $user_id, $user_id, $admin_id);
    $stmt->execute();
    $resultMessages = $stmt->get_result();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["receiver_id"]) && isset($_POST["message"])) {
        $receiver_id = $_POST["receiver_id"];
        $message = $_POST["message"];
        $timestamp = date("Y-m-d H:i:s");

       
        $sqlInsertMessage = "INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsertMessage);
        $stmt->bind_param("iiss", $admin_id, $receiver_id, $message, $timestamp);
        $stmt->execute();
        $stmt->close();

       
        header("Location: dragon.php?user_id=$receiver_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" type="image/JPG" href="../Pictures/logon.png">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
             background: linear-gradient(to right, hsla(34, 95%, 59%, 0.836), #eb9e5f, #c77037, #cf5d1b);
           
            background-blend-mode: multiply;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #e4a061;
            color: #fff;
            padding: 10px 20px;
            border-top-left-radius: 5px;
            border-radius: 5px;
            border-top-right-radius: 5px;
            border: 3px solid black;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .chat-box {
            padding: 20px;
            max-height: 300px;
            overflow-y: auto;
            border-radius: 15px;
            
        }
        .message {
            
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color:#e4a061;
            margin-right: 10px;
        }
        .message.sent {
            background-color: #e4a061;
            align-self: flex-end;
            text-align: right;
            color: white;
            
        }
        .message.received {
            background-color: #d8d8d8;
        }
        .message textarea {
            width: calc(100% - 60px);
            margin: 5px 0;
        }
        .message .meta {
            font-size: 12px;
            color: #666;
        }
        .message .meta .timestamp {
            margin-left: 10px;
        }
        .input-box {
           
            
            background-color: #f7f7f7;
            
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .input-box select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .input-box textarea {
            
            margin-left: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            width: 80%;
        }
        .input-box button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            margin-top:10px;
        }
    </style>
</head>
<body>
<div class="back-link" style="position: absolute; top: 20px; left: 0;">
    <a href="message.php">
        <i class="fas fa-chevron-circle-left" style="top: 23px; margin-left: 5px; color: black; font-size: 30px;"></i>
    </a>
</div>

    <div class="container">
        <div class="header">
        <?php if ($user_id !== null): ?>
                <?php
                    $selected_user_name = ''; 
                    $sqlSelectedUser = "SELECT uname FROM users WHERE id = $user_id";
                    $resultSelectedUser = $conn->query($sqlSelectedUser);
                    if ($resultSelectedUser && $resultSelectedUser->num_rows > 0) {
                        $rowSelectedUser = $resultSelectedUser->fetch_assoc();
                        $selected_user_name = $rowSelectedUser['uname'];
                    }
                ?>
                <h1>Chat with "<?php echo $selected_user_name; ?>"</h1>
            <?php else: ?>
                <h1>Admin Chat</h1>
            <?php endif; ?>
        </div>
        <div class="chat-box" id="chatBox">
    <?php if ($user_id !== null): ?>
        <?php while ($chat = $resultMessages->fetch_assoc()): ?>
            <div class="message <?php echo ($chat['sender_id'] == $admin_id) ? 'sent' : 'received'; ?>">
                <p><?php echo $chat['message']; ?></p>
                <div class="meta">
                    <?php if ($chat['sender_id'] == $admin_id): ?>
                        <span class="sender">Admin</span>
                    <?php else: ?>
                        <span class="sender"><?php echo $selected_user_name; ?></span>
                    <?php endif; ?>
                    <span class="timestamp"><?php echo $chat['timestamp']; ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<script>
   
    function fetchNewMessages() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    document.getElementById("chatBox").innerHTML = response;
                   
                    var chatBox = document.getElementById('chatBox');
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }
        };
        xhr.open("GET", "fetch_messages.php?user_id=<?php echo $user_id; ?>", true);
        xhr.send();
    }

    
    setInterval(fetchNewMessages, 2000);
</script>




        <div class="input-box">
    <form id="messageForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <select name="receiver_id" style="display: none;">
            <?php while ($row = $resultUsers->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($user_id !== null && $row['id'] == $user_id) echo " selected"; ?>><?php echo $row['uname']; ?></option>
            <?php endwhile; ?>
        </select>
        <textarea name="message" rows="1" placeholder="Type your message"></textarea>
        <button type="submit"><i class="fas fa-paper-plane"></i></button>
    </form>
</div>

    </div>
</body>
</html>
