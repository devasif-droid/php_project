<?php
$conn = new mysqli('localhost', 'root', '', 'new_form');

echo "Token from POST: " . $_POST['token'] . "<br>";

$token = $_POST['token'];
$newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);


$stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($email);
$stmt->fetch(); 
echo "Checking DB for matching token...<br>";
echo "Token in query: $token<br>";

if ($stmt->num_rows === 1) {
    // Update user's password
    $stmt = $conn->prepare("UPDATE students SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);
    $stmt->execute();

    // Delete token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    echo "Password has been successfully reset.";
    
} else {
    echo "Invalid or expired token.";    
}
?>



