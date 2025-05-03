<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SK TETUAN | Login</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/sklogo.png">
  <link rel="stylesheet" href="../assets/global.css">
  <link rel="stylesheet" href="../assets/fonts.css">
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
  <div class="wrapper">
    <form id="loginForm" class="login" method="post">
      <h2 class="login__title">Log in</h2>
      <h3 class="login__subtitle">Explore Tetuan</h3>
      <p class="error-message" style="color: red;"></p>
      <?php session_start(); ?>
      
      <?php if (isset($_SESSION['email']) && !empty($_SESSION['email'])) : ?>
        <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" placeholder="E-mail" required>
        <?php unset($_SESSION['email']); ?>
      <?php else : ?>
        <input type="email" name="email" placeholder="E-mail" required>
      <?php endif; ?>

    
      <input type="password" name="password" id="passwordInput" placeholder="Password" required>
<label for="showPassword">
  <input type="checkbox" id="showPassword"> Show Password
</label>
      <button class="login__btn" type="submit">Log in</button>
      

      <a class="login__forgot-pass" href="../forms/forgot_password.php">Forgot password?</a>
      <p>Don't have an account? <a class="login__sign-up-here" href="#" onclick="showSignUpModal()">click here</a></p>
    </form>

    <div class="brand">
      <a href="../index.php" class="brand__logo-wrapper">
        <img class="brand__logo" src="../assets/img/sklogo.png" alt="SK Logo">
        <p class="brand__logo-abbrev"></p>
        <p class="brand__logo-name"></p>
      </a>
    </div>
  </div>

  <!-- Modal for sign-up form -->
  <div id="signupModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeSignUpModal()">&times;</span>
      <form class="login" action="../functions/signup.php" method="post" enctype="multipart/form-data">
        <!-- Include the sign-up form content here -->
        <h2 class="login__title">Fill Information</h2>
        <h3 class="login__subtitle"></h3>
        <input type="text" name="first-name" placeholder="First name" class="login__input" required>
        <input type="text" name="middle-name" placeholder="Middle name" class="login__input" required>
        <input type="text" name="last-name" placeholder="Last name" class="login__input" required>
        
        <?php if (isset($emailExistError)) : ?>
          <p class="email-exist-err"><?php echo $emailExistError; ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="E-mail" class="login__input" required>
        <input type="tel" name="phone-number" placeholder="Phone number" class="login__input" required>
        
        <label for="purok">Purok:</label>
        <select id="purok" name="purok" class="login__input" required>
          <option value="Zone 1">Zone 1</option>
          <option value="Zone 2">Zone 2</option>
          <option value="Zone 3">Zone 3</option>
          <option value="Zone 4">Zone 4</option>
          <option value="Zone 5">Zone 5</option>
          <option value="Zone 6">Zone 6</option>
        </select>

        <label for="birthday">Birthdate:</label>
        <input type="date" id="birthday" name="birthday" class="login__input" required>

        <label for="sex">Sex:</label>
        <select id="sex" name="sex" class="login__input" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>

        <label for="marital-status">Marital Status:</label>
        <select id="marital-status" name="marital-status" class="login__input" required>
          <option value="single">Single</option>
          <option value="married">Married</option>
          <option value="divorced">Divorced</option>
          <option value="widowed">Widowed</option>
        </select>

        <label>Do you have any child?</label>
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

        <!-- Checkbox for user agreement -->
        <div class="checkbox-group">
          <input type="checkbox" id="agree" name="agree" required>
          <label for="agree">I confirm that the information provided above is accurate and agree to its use by the SK organization for profile creation, content customization,and service improvement. I understand that my data will be kept secure and can withdraw consent at any time.</label>
        </div>

        <button class="submit" type="submit" disabled>Submit</button>
      </form>
    </div>
  </div>
  
  <script src="../assets/js/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#loginForm").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Get form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
          type: "POST",
          url: "functions/login.php",
          data: formData,
          dataType: "json",
          success: function(response) {
            if (response.success) {
              // Redirect to the dashboard page
              window.location.href = "../user/landing.php";
            } else {
              // Display the error message on the login form
              $(".error-message").text(response.error);
            }
          },
          error: function() {
            // Show error message if AJAX request fails
            $(".error-message").text("An error occurred. Please try again later.");
          }
        });
      });
    });
  </script>

  <script>
    function showSignUpModal() {
      var modal = document.getElementById("signupModal");
      modal.style.display = "block";
    }

    function closeSignUpModal() {
      var modal = document.getElementById("signupModal");
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      var modal = document.getElementById("signupModal");
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      var submitBtn = document.querySelector("#signupModal .submit");
      var agreeCheckbox = document.querySelector("#signupModal #agree");

      // Initially disable the submit button
      submitBtn.disabled = true;

      // Enable the submit button when the checkbox is clicked
      agreeCheckbox.addEventListener("change", function() {
        submitBtn.disabled = !this.checked;
      });
    });
  </script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var showPasswordCheckbox = document.getElementById("showPassword");
    var passwordInput = document.getElementById("passwordInput");

    showPasswordCheckbox.addEventListener("change", function() {
      if (this.checked) {
        // Change the input type to text to show the password
        passwordInput.type = "text";
      } else {
        // Change the input type back to password to hide the password
        passwordInput.type = "password";
      }
    });
  });
</script>

</body>
</html>
