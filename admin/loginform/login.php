<?php
include ('../db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize user input
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Perform the query with prepared statement
    $query = "SELECT * FROM _admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password';
       
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK TETUAN | Admin login</title>
    <link rel="stylesheet" href="loginform/global.css">
    <link rel="stylesheet" href="loginform/login.css">
    <link rel="shortcut icon" href="../assets/img/sklogo.png" type="image/x-icon">
</head>

<body>
    <a class="brand" href="./">
        <div class="brand__logo-wrapper">
            <img class="brand__logo" src="../assets/img/sklogo.png" alt=" logo">
        </div>
        <div class="brand__text-wrapper">
            <p class="brand__abbrev"></p>
            <p class="brand__name"></p>
        </div>
    </a>

    <form class="login-form" method="post">
        <h1 class="login-form__title">SK Admin</h1>
        <div class="login-form__input">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-msg'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }
            ?>
            <input id="input-username" class="w-80pct" type="text" name="username" placeholder="Username" required>
            <input id="input-password" class="w-80pct" type="password" name="password" placeholder="Password" required>
            <input id="btn-login" class="login-form__btn-login" type="submit" value="Log in">
        </div>
    </form>
</body>

</html>
