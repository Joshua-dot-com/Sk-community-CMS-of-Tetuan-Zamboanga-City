<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SK TETUAN | Sign up</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/sklogo.png">
  <link rel="stylesheet" href="../assets/global.css">
  <link rel="stylesheet" href="../assets/fonts.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .wrapper {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .login__title {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    .login__subtitle {
      margin-top: 5px;
      font-size: 16px;
      color: #666;
    }

    .login__input {
      width: calc(100% - 20px); /* Adjusted width to match the input width in login.php */
      padding: 10px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .login__btn {
      width: calc(100% - 20px); /* Adjusted width to match the button width in login.php */
      padding: 10px;
      margin-top: 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .login__btn:hover {
      background-color: #0056b3;
    }

    .radio-group {
      display: inline-block;
      margin-top: 10px;
    }

    .radio-group input[type="radio"] {
      margin-right: 5px;
    }

    .radio-group label {
      margin-right: 15px;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <form class="login" action="../functions/signup.php" method="post" enctype="multipart/form-data">
      <h2 class="login__title">Sign up</h2>
      <h3 class="login__subtitle">Explore universities around the nation</h3>
      
      <input type="text" name="first-name" placeholder="First name" class="login__input" required>
      <input type="text" name="middle-name" placeholder="Middle name" class="login__input" required>
      <input type="text" name="last-name" placeholder="Last name" class="login__input" required>
      
      <?php if (isset($emailExistError)) : ?>
        <p class="email-exist-err"><?php echo $emailExistError; ?></p>
      <?php endif; ?>

      <input type="email" name="email" placeholder="E-mail" class="login__input" required>
      <input type="tel" name="phone-number" placeholder="Phone number" class="login__input" required>
      <input type="text" name="purok" placeholder="Purok" class="login__input" required>

      <label for="birthday">Birthday:</label>
      <input type="date" id="birthday" name="birthday" class="login__input" required>

      <label for="sex">Sex:</label>
      <select id="sex" name="sex" class="login__input" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>

      <label for="marital-status">Marital Status:</label>
      <select id="marital-status" name="marital-status" class="login__input" required>
        <option value="single">Single</option>
        <option value="married">Married</option>
        <option value="divorced">Divorced</option>
        <option value="widowed">Widowed</option>
      </select>

      <label for="has-child">Do you have a child?</label>
      <div class="radio-group">
        <input type="radio" id="has-child-yes" name="has-child" value="yes">
        <label for="has-child-yes">Yes</label>
      </div>
      <div class="radio-group">
        <input type="radio" id="has-child-no" name="has-child" value="no">
        <label for="has-child-no">No</label>
      </div>

      <label for="verification-photo">Upload verification photo</label>
      <input type="file" id="verification-photo" name="verification-photo" accept="image/jpeg, image/png, image/jpg" class="login__input" required>

      <input type="password" name="password" placeholder="Password" class="login__input" required>
      <input type="password" name="confirm-password" placeholder="Confirm Password" class="login__input" required>

      <button class="login__btn" type="submit">SUBMIT</button>
    </form>
  </div>
</body>
</html>
