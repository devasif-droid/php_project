<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: login.html");
    exit();
}
$user_id = $_SESSION['user_id']; 
$email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";    
$dbname = "new_form";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$sql = $conn->prepare("SELECT name, email, gender, country FROM students WHERE id=?");
$sql->bind_param("i", $user_id);
$sql->execute();
$sql->bind_result($name, $email, $gender, $country); 
$sql->fetch();
$sql->close();  

$update_message = '';
$update_status = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $new_password = $_POST['pass1'];
    $gender = $_POST['gender']; 
    $country = $_POST['country'];
    
   
    if(!empty($new_password)) {
        $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $new = $conn->prepare("UPDATE students SET name=?, email=?, password=?, gender=?, country=? WHERE id=?"); 
        $new->bind_param("sssssi", $name, $email, $password_hashed, $gender, $country, $user_id);
    } else {
      
        $new = $conn->prepare("UPDATE students SET name=?, email=?, gender=?, country=? WHERE id=?"); 
        $new->bind_param("ssssi", $name, $email, $gender, $country, $user_id);
    }

    if($new->execute() === TRUE){
        $update_message = "Profile updated successfully!";
        $update_status = "success";
        
        if($_SESSION['email'] !== $email) {
            $_SESSION['email'] = $email;
        }
    } else {
        $update_message = "Error updating profile: " . $new->error;
        $update_status = "error";
    }
    $new->close();
}

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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

        .form-card {
            background: var(--card-gradient);
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-card h2 {
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

        .form-group {
            margin-bottom: 25px;
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

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .radio-item input[type="radio"] {
            margin-right: 8px;
            cursor: pointer;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-top: 5px;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
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

            .form-card {
                padding: 20px;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
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
                    <li><a href="update_prof.php" class="active"><i class="fas fa-edit"></i> Update Profile</a></li>
                    <li><a href="forgot_password.php"><i class="fas fa-key"></i> Change Password</a></li>
                    <li><a href="setting.php"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="contactus.html"><i class="fas fa-envelope"></i> Contact Us</a></li>
                    <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Update Profile</h1>
                <p>Update your personal information and account settings</p>
            </div>

            <div class="form-card">
                <h2>Edit Your Profile</h2>
                
                <?php if(!empty($update_message)): ?>
                <div class="alert alert-<?php echo $update_status; ?>">
                    <?php echo $update_message; ?>
                </div>
                <?php endif; ?>

                <form id="updateForm" method="post" action="update_prof.php" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter your name">
                        <span class="error" id="nameError"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email">
                        <span class="error" id="emailError"></span>
                    </div>

                    <div class="form-group">
                        <label for="pass1">Password (Leave blank to keep current password)</label>
                        <input type="password" id="pass1" name="pass1" class="form-control" placeholder="Enter new password">
                        <span class="error" id="pass1Error"></span>
                    </div>

                    <div class="form-group">
                        <label for="pass2">Confirm Password</label>
                        <input type="password" id="pass2" name="pass2" class="form-control" placeholder="Confirm new password">
                        <span class="error" id="pass2Error"></span>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <div class="radio-group">
                            <label class="radio-item">
                                <input type="radio" id="male" name="gender" value="Male" <?php if($gender == "Male") echo "checked"; ?>>
                                Male
                            </label>
                            <label class="radio-item">
                                <input type="radio" id="female" name="gender" value="Female" <?php if($gender == "Female") echo "checked"; ?>>
                                Female
                            </label>
                        </div>
                        <span class="error" id="genderError"></span>
                    </div>

                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country" name="country" class="form-control">
                            <option value="">Select your country</option>
                            <option value="USA" <?php if ($country == 'USA') echo 'selected'; ?>>USA</option>
                            <option value="INDIA" <?php if ($country == 'INDIA') echo 'selected'; ?>>India</option>
                            <option value="Australia" <?php if ($country == 'Australia') echo 'selected'; ?>>Australia</option>                            
                        </select>
                        <span class="error" id="countryError"></span>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-item">
                            <input type="checkbox" id="check" name="check">
                            I accept all terms and conditions
                        </label>
                        <span class="error" id="checkError"></span>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Form validation
        function validateForm() {
            let isValid = true;
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const pass1 = document.getElementById('pass1').value;
            const pass2 = document.getElementById('pass2').value;
            const male = document.getElementById('male').checked;
            const female = document.getElementById('female').checked;
            const country = document.getElementById('country').value;
            const check = document.getElementById('check').checked;
            
            // Reset error messages
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').textContent = '';
            document.getElementById('pass1Error').textContent = '';
            document.getElementById('pass2Error').textContent = '';
            document.getElementById('genderError').textContent = '';
            document.getElementById('countryError').textContent = '';
            document.getElementById('checkError').textContent = '';
            
            // Validate name
            if (name === '') {
                document.getElementById('nameError').textContent = 'Name is required';
                isValid = false;
            } else if (name.length < 3) {
                document.getElementById('nameError').textContent = 'Name must be at least 3 characters';
                isValid = false;
            }
            
            // Validate email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                document.getElementById('emailError').textContent = 'Email is required';
                isValid = false;
            } else if (!emailPattern.test(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address';
                isValid = false;
            }
            
            // Validate password only if either password field is filled
            if (pass1 !== '' || pass2 !== '') {
                if (pass1.length < 6) {
                    document.getElementById('pass1Error').textContent = 'Password must be at least 6 characters';
                    isValid = false;
                }
                
                if (pass1 !== pass2) {
                    document.getElementById('pass2Error').textContent = 'Passwords do not match';
                    isValid = false;
                }
            }
            
            // Validate gender
            if (!male && !female) {
                document.getElementById('genderError').textContent = 'Please select your gender';
                isValid = false;
            }
            
            // Validate country
            if (country === '') {
                document.getElementById('countryError').textContent = 'Please select your country';
                isValid = false;
            }
            
            // Validate terms checkbox
            if (!check) {
                document.getElementById('checkError').textContent = 'You must accept the terms and conditions';
                isValid = false;
            }
            
            return isValid;
        }
    </script>
    <script src="logout.js"></script>
</body>
</html>

