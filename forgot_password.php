<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: rgb(0, 255, 190);
            --primary-hover: rgb(0, 200, 150);
            --bg-gradient: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            --card-gradient: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(71, 95, 81, 0.8) 100%);
            --sidebar-hover: radial-gradient(circle, rgb(126, 142, 158) 30%, rgba(74, 173, 114, 0.8) 100%);
            --error-color: #e74c3c;
            --success-color: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            line-height: 1.6;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Sidebar */
        .leftsidebar {
            position: fixed;
            background: var(--bg-gradient);
            height: 100vh;
            width: 250px;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style-type: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: var(--sidebar-hover);
            border-left: 3px solid var(--primary-color);
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .password-card {
            background: var(--card-gradient);
            border-radius: 10px;
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .password-card h2 {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 500;
            display: none;
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.5);
            color: var(--success-color);
        }

        .alert-error {
            background-color: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.5);
            color: var(--error-color);
        }

        .password-requirements {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .password-requirements h3 {
            font-size: 1rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .password-requirements ul {
            padding-left: 20px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .password-requirements li {
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            color: white;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(0, 255, 190, 0.2);
        }

        .error {
            color: var(--error-color);
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            width: 100%;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #333;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Password strength meter */
        .password-strength {
            height: 5px;
            margin-top: 8px;
            border-radius: 3px;
            transition: all 0.3s;
            background: #ddd;
        }

        .strength-weak {
            width: 25%;
            background: #e74c3c;
        }

        .strength-medium {
            width: 50%;
            background: #f39c12;
        }

        .strength-strong {
            width: 75%;
            background: #3498db;
        }

        .strength-very-strong {
            width: 100%;
            background: #2ecc71;
        }

        .strength-text {
            font-size: 0.8rem;
            margin-top: 5px;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .leftsidebar {
                transform: translateX(-100%);
            }

            .leftsidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .menu-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 200;
                background: var(--primary-color);
                color: #333;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            }

            .password-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Mobile Menu Toggle -->
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>

        <!-- Left Sidebar -->
        <div class="leftsidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Dashboard</h3>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>   
                    <li><a href="forgot_password.php" class="active"><i class="fas fa-key"></i> Change Password</a></li>
                    <li><a href="setting.php"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="contactus.html"><i class="fas fa-envelope"></i> Contact Us</a></li>
                    <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Change Password</h1>
                <p>Update your password to keep your account secure</p>
            </div>

            <div class="password-card">
                <h2>Change Your Password</h2>
                
                <div id="alertMessage" class="alert"></div>

                <div class="password-requirements">
                    <h3>Password Requirements</h3>
                    <ul>
                        <li>At least 6 characters long</li>
                        <li>Include at least one uppercase letter</li>
                        <li>Include at least one number</li>
                        <li>Include at least one special character</li>
                    </ul>
                </div>

                <form id="passwordForm" method="post" action="change_pass.php" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                        <span class="error" id="currentPasswordError"></span>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required onkeyup="checkPasswordStrength()">
                        <div class="password-strength" id="passwordStrength"></div>
                        <div class="strength-text" id="strengthText"></div>
                        <span class="error" id="newPasswordError"></span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        <span class="error" id="confirmPasswordError"></span>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </form>

                <div class="login-link">
                    <a href="profile.php">Return to Profile</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Password strength checker
        function checkPasswordStrength() {
            const password = document.getElementById('new_password').value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            
            // Remove all classes
            strengthBar.className = 'password-strength';
            
            if (password === '') {
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
                return;
            }
            
            let strength = 0;
            
            // Length check
            if (password.length >= 6) strength += 1;
            if (password.length >= 10) strength += 1;
            
            // Character type checks
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Update strength bar and text
            switch (strength) {
                case 0:
                case 1:
                    strengthBar.classList.add('strength-weak');
                    strengthText.textContent = 'Weak';
                    strengthText.style.color = '#e74c3c';
                    break;
                case 2:
                case 3:
                    strengthBar.classList.add('strength-medium');
                    strengthText.textContent = 'Medium';
                    strengthText.style.color = '#f39c12';
                    break;
                case 4:
                    strengthBar.classList.add('strength-strong');
                    strengthText.textContent = 'Strong';
                    strengthText.style.color = '#3498db';
                    break;
                case 5:
                    strengthBar.classList.add('strength-very-strong');
                    strengthText.textContent = 'Very Strong';
                    strengthText.style.color = '#2ecc71';
                    break;
            }
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Reset error messages
            document.getElementById('currentPasswordError').textContent = '';
            document.getElementById('newPasswordError').textContent = '';
            document.getElementById('confirmPasswordError').textContent = '';
            
            // Validate current password
            if (currentPassword === '') {
                document.getElementById('currentPasswordError').textContent = 'Current password is required';
                isValid = false;
            }
            
            // Validate new password
            if (newPassword === '') {
                document.getElementById('newPasswordError').textContent = 'New password is required';
                isValid = false;
            } else if (newPassword.length < 6) {
                document.getElementById('newPasswordError').textContent = 'Password must be at least 6 characters long';
                isValid = false;
            } else if (!/[A-Z]/.test(newPassword)) {
                document.getElementById('newPasswordError').textContent = 'Password must include at least one uppercase letter';
                isValid = false;
            } else if (!/[0-9]/.test(newPassword)) {
                document.getElementById('newPasswordError').textContent = 'Password must include at least one number';
                isValid = false;
            } else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(newPassword)) {
                document.getElementById('newPasswordError').textContent = 'Password must include at least one special character';
                isValid = false;
            }
            
            // Validate confirm password
            if (confirmPassword === '') {
                document.getElementById('confirmPasswordError').textContent = 'Please confirm your new password';
                isValid = false;
            } else if (newPassword !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                isValid = false;
            }
            
            return isValid;
        }
    </script>
    <script src="logout.js"></script>
</body>
</html>