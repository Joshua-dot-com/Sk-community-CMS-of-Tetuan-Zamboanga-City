<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Chat</title>
    <link rel="shortcut icon" type="image/JPG" href="../Pictures/logon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<?php
session_start();
include "..\..\db_conn.php";


function sendMessage($sender_id, $receiver_id, $message, $conn) {
    $timestamp = date("Y-m-d H:i:s");
    $sqlInsertMessage = "INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsertMessage);
    $stmt->bind_param("iiss", $sender_id, $receiver_id, $message, $timestamp);
    if (!$stmt->execute()) {
        return false;
    }
    return true;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"]) && !empty($_POST["message"])) {
    $user_id = $_SESSION['id'];
    $admin_id = 0; 
    $message = $_POST["message"];
    if (sendMessage($user_id, $admin_id, $message, $conn)) {
        echo "Message sent successfully";
    } else {
        echo "Error: Failed to send message";
    }
    exit();
}


function fetchMessages($sender_id, $receiver_id, $conn) {
    $sqlMessages = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp";
    $stmt = $conn->prepare($sqlMessages);
    $stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
    $stmt->execute();
    $resultMessages = $stmt->get_result();
    $messages = [];
    while ($chat = $resultMessages->fetch_assoc()) {
        $messages[] = $chat;
    }
    return $messages;
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["fetch"])) {
    $user_id = $_SESSION['id'];
    $admin_id = 0; 
    $messages = fetchMessages($user_id, $admin_id, $conn);
    header('Content-Type: application/json');
    echo json_encode($messages);
    exit();
}
?>


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
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
            border: 3px solid black;
            box-shadow: 2px 2;
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
            padding: 10px 20px;
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
<div class="back-link">
    <a href="../User-homepage/Userhomepage.php">
        <i class="fas fa-chevron-circle-left" style="margin-top: 5px; margin-left: 5px; color: black; font-size: 30px;"></i>
    </a>
</div>
<div class="container">
    <div class="header">
        <h1>Chat with Admin</h1>
    </div>
    <div class="chat-box" id="chat-box">
        
    </div>

    <div class="input-box">
        <form id="message-form">
            <textarea name="message" rows="1" placeholder="Type your message"></textarea>
            <button type="submit"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>

<script>
    function sendMessage(message) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "user_chat.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                console.log(xhr.responseText);e
            }
        };
        xhr.send("message=" + message);
    }

    function fetchMessages() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "user_chat.php?fetch=true", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            var messages = JSON.parse(xhr.responseText);
            var chatBox = document.getElementById("chat-box");
            var isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 1; 
            chatBox.innerHTML = "";
            messages.forEach(function(message) {
                var sender = (message.sender_id == <?php echo $_SESSION['id']; ?>) ? 'You' : 'Admin';
                var messageClass = (message.sender_id == <?php echo $_SESSION['id']; ?>) ? 'sent' : 'received';
                chatBox.innerHTML += '<div class="message ' + messageClass + '">' +
                    '<p>' + message.message + '</p>' +
                    '<div class="meta">' +
                    '<span class="sender-name">' + sender + '</span>' +
                    '<span class="timestamp">' + message.timestamp + '</span>' +
                    '</div>' +
                    '</div>';
            });
            if (isScrolledToBottom) {
                chatBox.scrollTop = chatBox.scrollHeight; 
            }
        }
    };
    xhr.send();
}



setInterval(fetchMessages, 2000);


    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("message-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            var messageInput = document.querySelector("textarea[name='message']");
            var message = messageInput.value.trim();
            if (message !== "") {
                sendMessage(message);
                messageInput.value = ""; 
            } else {
                alert("Message cannot be empty");
            }
        });
    });
</script>
</body>
</html>