<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$conn = new mysqli('localhost', 'root', '', 'new_form');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

$stmt = $conn->prepare("SELECT id FROM students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $token = bin2hex(random_bytes(32));     
    //$expires = date("Y-m-d H:i:s", time() + 3600);
    $expires = date("Y-m-d H:i:s", time() + 86400); // 24 hour

    $del_stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $del_stmt->bind_param("s", $email);
    $del_stmt->execute();

    $ins_stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $ins_stmt->bind_param("sss", $email, $token, $expires);
    $ins_stmt->execute();

    $resetLink = "http://localhost/web/resetpassword.php?token=$token";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'asifdev0011@gmail.com';
        $mail->Password   = 'dqjeprhprvlnzvkg'; // app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('asifdev0011@gmail.com', 'php_mailer'); // app name is php_mailer
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset your password';
        $mail->Body    = "Click <a href='$resetLink'>here</a> to reset your password.";    

        $mail->send();
        echo "Password reset link has been sent to your email.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "No user found with that email address.";
}
?>

