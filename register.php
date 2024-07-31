<?php
$servername = "localhost"; 
$username = "root"; 
$password = "123"; 
$dbname = "reactlogin"; 

// Create connection
$conn = new mysqli($localhost, $root, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    
    $stmt = $conn->prepare("INSERT INTO register (username, email, password) VALUES (rusername, remail, rpassword)");
    $stmt->bind_param("sss", $user, $email, $pass);

    
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();
    $conn->close();
}
?>
