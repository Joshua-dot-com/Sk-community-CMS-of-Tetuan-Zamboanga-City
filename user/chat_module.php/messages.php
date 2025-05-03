<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat - Select User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" type="image/JPG" href="../Pictures/logon.png">
<?php
include "../Connection/connection.php"; 

$admin_id = 0; 


$sqlUsers = "SELECT id, uname FROM users";
$resultUsers = $conn->query($sqlUsers);

?>

    
    <style>
        .HeaderSection {
    display: flex;
    align-items: center;
    position: fixed;
    top: 1px;
    height: 50px;
    left: 0px;
    color: white;
    width: calc(100% - 8px);
    background-color: rgba(50, 50, 50, 0.9); 


    border: 1px solid rgba(255, 248, 248, 0.24);
    border-bottom: 1.5px solid gray;
    font-weight: lighter;
    font-size: 24px; 
}


.circular-imgs {
    border-radius: 50%;
    max-width: 45px; 
    height: auto;
    margin-right: 5px; 
}


     .right {
         margin-left: auto ; 
         display: flex;
         justify-content: center; 
         align-items: center;
         margin-right: 10px;
    
     }


     .Move{
    margin-top: 70px;
        margin-left: 210px;
        margin-right: 10px;

    }

    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        nav {
            margin-top:51px;
            position: fixed;
            top: 0;
            left: 0;
            width: 200px; 
            height: 100%; 
            
            color: #fff;
           
            z-index: 2;
            font-size: 16px;
            padding-top: 10px; 
           
            border-right: 1.5px solid gray;
        }

        nav ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        nav ul li {
            display: block; 
            margin-bottom: 10px; 
        }

        nav ul li a {
            display: block; 
            text-decoration: none;
            color: #fff;
            font-weight: normal;
            transition: color 0.3s;
            padding: 15px;
            
        }
        nav i {
            
            margin-right: 10px
        }

        nav li:hover,
        nav ul li a:hover {
            color: orange;
        }
        .logout-link {
    background-color: #6f42c1;
    color: white; 
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    position: absolute;
    top: 10px;
    left: 10px;
}

.logout-link:hover {
    color: purple;
}
   
        body {
            
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
            background-blend-mode: multiply,multiply;
            
            
        }

        body::after {
            content: "";
            background-color: rgba(8, 8, 8, 0.9); 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; 
        }
        .container {
    max-width: 600px;
    margin: auto;
    background-color: #f5f5f5;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    position: absolute;
    margin-top: 70px;
    left: 50%;
    
}
.container::before {
    content: "\f007";
    font-family: "Font Awesome 5 Free";
    position: absolute;
    top: -2000px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 30px;
    color: #555;
}




        .fa-user {
            color: #00a0e4;
        }

        .fa-reply {
            color: #37bea9;
        }

        .fa-clock {
            color: #ff9900;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .sender-info {
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }

        .message-body {
            font-size: 16px;
            color: #333;
        }

        
        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: black;
            text-align: center;
        }
        .user-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: left;
            cursor: pointer;
        }
        .general {
            font-size: 16px;
            display: flex;
            justify-content: left;
            margin-bottom: 5px;
            font-weight: normal;
            margin-left: 2px

        }.settings {
            margin-top: 20px;
            font-size: 16px;
            display: flex;
            justify-content: left;
            margin-bottom: 5px;
            font-weight: normal;
            margin-left: 2px

        }
        .buttones{
       
           
       color: white;
       
  cursor: pointer;
       border: 1px solid gray;
       transition: color 0.3s, border-color 0.3s;
       margin-bottom: 10px;
}
.buttones a {
   color: white;
   
       cursor: pointer;
           
            text-decoration: none;
}
button:hover {
   color: orange;
}
.buttones a:hover {
   color: orange;
}

    </style>
</head>
<body>
<section class="HeaderSection">
         <img src="../Pictures/s.jpg" alt="logo" class="circular-imgs"> 
         <p>Goody's</p>
 
         <section class="right" style="display: flex; justify-content: center;"> <p>Welcome to Goody's Admin</p></section>
    </section>  
</section>
    <nav>
<ul>
    <h1 style =" margin-top: 10px; margin-bottom: 20px; text-align: center;">Admin</h1>
         <h1 class = "general">General</h1>
        <li><a href="dashboarddb.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="adminOrder.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="message.php"><i class="fas fa-comment"></i> Messages</a></li>

        <li><a href="adminOrdertotal.php"><i class="fas fa-file-alt"></i> Records</a></li>
        <li><a href="adminHome.php"><i class="fas fa-calendar-alt"></i> Event</a></li>
        <li><a href="adminsite.php"><i class="fas fa-users"></i> Account Users</a></li>
        <li><a href="adminProduct.php"><i class="fas fa-box-open"></i> Products</a></li>

        <h1 class = "settings"> Settings </h1>
        <li><a href="adminAcc.html"><i class="fas fa-user-tie"></i> Admin Account</a></li>
        <li><a href="admin.php"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
    </ul>
    </nav>
    
    <div class="container">
    <div class="header">
        <h1>Admin Chat - Select User</h1>
    </div>
   
    <input type="text" id="searchInput" onkeyup="filterUsers()" placeholder="Search for users...">
    <?php 
    
    echo '<div id="userList">';
    while ($row = $resultUsers->fetch_assoc()): ?>
        <form action="dragon.php" method="get">
            <button class="user-button" type="submit" name="user_id" value="<?php echo $row['id']; ?>">
                <i class="fas fa-user" style="color: blue;">&nbsp;&nbsp;&nbsp;</i> <?php echo $row['uname']; ?>
            </button>
        </form>
    <?php endwhile; 
   
    echo '</div>';
    ?>
</div>
<style>#searchInput {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}</style>
<script>
function filterUsers() {
    
    var input, filter, userList, userButtons, userName, i;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    userList = document.getElementById("userList");
    userButtons = userList.getElementsByClassName('user-button');


    for (i = 0; i < userButtons.length; i++) {
        userName = userButtons[i].innerText.toUpperCase();
        if (userName.indexOf(filter) > -1) {
            userButtons[i].style.display = "";
        } else {
            userButtons[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>
