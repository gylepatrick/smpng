<?php
  include 'db.php';

  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

      $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

      $result = $conn->query($sql);

if ($result->num_rows == 1) {
    // User exists, login successful
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    header('Location: ../home.php');
} else {
    // if the username and password are invalid it will sesion an error message
    header('Location: ../index.php');
    $_SESSION['error_login']="Username/Password Incorrect. Please double check your credentials!";
}

// Close database connection
$conn->close();
}
?>