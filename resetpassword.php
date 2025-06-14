<?php
$token = $_GET['token'] ?? '';
// Verify token exists and isn't expired
?>
<form method="POST" action="set_password.php">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <label for="password">New Password:</label>
    <input type="password" name="password" required>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" required>
    <button type="submit">Update Password</button>
</form>

