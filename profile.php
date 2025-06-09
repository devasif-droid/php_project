    <?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";     
$dbname = "new_form";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}
$message = '';
$status = '';

// Handle profile picture upload
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_picture'])){
    $target_dir = "uploads/profile_pictures/";
    
    // Create directory if doesn't exist  
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); 
    }
    
    $file_extension = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
    $new_filename = "profile_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    $upload_ok = 1;
    
    // Check if image file is actual image
    if(isset($_POST["upload_picture"])) {
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check !== false) {
            $upload_ok = 1;
        } else {
            $message = "File is not an image.";
            $status = "error";
            $upload_ok = 0;            
        }
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["profile_picture"]["size"] > 5000000) {
        $message = "Sorry, your file is too large. Maximum size is 5MB.";
        $status = "error";
        $upload_ok = 0;
    }
    
    // Allow certain file formats
    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" ) {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $status = "error";
        $upload_ok = 0;
    }
    
    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        if(empty($message)) {
            $message = "Sorry, your file was not uploaded.";
            $status = "error";
        }
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Delete old profile picture if exists
            $old_pic_stmt = $conn->prepare("SELECT profile_picture FROM students WHERE id = ?");
            $old_pic_stmt->bind_param("i", $user_id);
            $old_pic_stmt->execute();
            $old_pic_result = $old_pic_stmt->get_result();
            
            if($old_pic_result->num_rows > 0) {
                $old_pic_data = $old_pic_result->fetch_assoc();
                if(!empty($old_pic_data['profile_picture']) && file_exists($old_pic_data['profile_picture'])) {
                    unlink($old_pic_data['profile_picture']); 
                }
            }
            $old_pic_stmt->close();
            
            // Update database with new profile picture path 
            $update_stmt = $conn->prepare("UPDATE students SET profile_picture = ? WHERE id = ?");
            $update_stmt->bind_param("si", $target_file, $user_id);
            
            if($update_stmt->execute()) {
                $message = "Profile picture updated successfully!";                
                $status = "success";                
            } else {
                $message = "Error updating profile picture in database.";
                $status = "error";        
            }
            $update_stmt->close();
        } else {
            $message = "Sorry, there was an error uploading your file.";
            $status = "error";
        }
    }
}

// Handle profile picture removal
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_picture'])){
    // Get current profile picture
    $pic_stmt = $conn->prepare("SELECT profile_picture FROM students WHERE id = ?");
    $pic_stmt->bind_param("i", $user_id);
    $pic_stmt->execute();
    $pic_result = $pic_stmt->get_result();
    
    if($pic_result->num_rows > 0) {
        $pic_data = $pic_result->fetch_assoc();
        if(!empty($pic_data['profile_picture']) && file_exists($pic_data['profile_picture'])) {
            unlink($pic_data['profile_picture']);
        }
    }
    $pic_stmt->close();
    
    // Remove from database
    $remove_stmt = $conn->prepare("UPDATE students SET profile_picture = NULL WHERE id = ?");
    $remove_stmt->bind_param("i", $user_id);
    
    if($remove_stmt->execute()) {
        $message = "Profile picture removed successfully!";
        $status = "success";
    } else {
        $message = "Error removing profile picture.";
        $status = "error";
    }
    $remove_stmt->close();
}

// Fetch user data 
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header("location: login.html");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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

        .profile-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 25px;
        }

        .profile-card {
            background: var(--card-gradient);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-picture-section {
            text-align: center;
        }

        .profile-picture-container {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .default-avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #333;
            border: 4px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .picture-overlay {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--primary-color);
            color: #333;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .picture-overlay:hover {
            background: var(--primary-hover);
            transform: scale(1.1);
        }

        .upload-section {
            margin-top: 20px;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            margin-bottom: 10px;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            background: var(--primary-color);
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
        }

        .file-input-label:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .file-input-label i {
            margin-right: 8px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin: 5px;
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

        .btn-danger {
            background-color: var(--error-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        .profile-info h2 {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
        }

        .profile-info h2 i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .info-value {
            color: rgba(255, 255, 255, 0.9);
        }

        .file-name {
            margin-top: 10px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
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

            .profile-container {
                grid-template-columns: 1fr;
            }

            .profile-picture, .default-avatar {
                width: 150px;
                height: 150px;
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
                    <li><a href="profile.php" class="active"><i class="fas fa-user"></i> Profile</a></li>
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
                <h1>My Profile</h1>
                <p>View and manage your profile information</p>
            </div>

            <?php if(!empty($message)): ?>
            <div class="alert alert-<?php echo $status; ?>">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <div class="profile-container">
                <!-- Profile Picture Section -->
                <div class="profile-card profile-picture-section">
                    <div class="profile-picture-container">
                        <?php if(!empty($user['profile_picture']) && file_exists($user['profile_picture'])): ?>
                            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
                        <?php else: ?>
                            <div class="default-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                        <div class="picture-overlay" onclick="document.getElementById('profile_picture').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>

                    <div class="upload-section">
                        <form method="post" enctype="multipart/form-data" id="uploadForm">
                            <div class="file-input-wrapper">
                                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" onchange="showFileName()">
                                <label for="profile_picture" class="file-input-label">
                                    <i class="fas fa-upload"></i> Choose Photo
                                </label>
                            </div>
                            <div class="file-name" id="fileName"></div>
                            
                            <div style="margin-top: 15px;"> 
                                <button type="submit" name="upload_picture" class="btn btn-primary" id="uploadBtn" style="display: none;">
                                    <i class="fas fa-save"></i> Upload
                                </button>
                                
                                <?php if(!empty($user['profile_picture'])): ?>
                                <button type="submit" name="remove_picture" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove your profile picture?')">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Profile Information Section -->
                <div class="profile-card profile-info">
                    <h2><i class="fas fa-user-circle"></i> Profile Information</h2>
                    
                    <div class="info-item">
                        <span class="info-label">Full Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['name'] ?? 'Not provided'); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['email'] ?? 'Not provided'); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Gender:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['gender'] ?? 'Not provided'); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Country:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['country'] ?? 'Not provided'); ?></span>
                    </div>
                                        
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="update_prof.php" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Show selected file name and upload button 
        function showFileName() {
            const input = document.getElementById('profile_picture');
            const fileName = document.getElementById('fileName');
            const uploadBtn = document.getElementById('uploadBtn');
                      
            if (input.files.length > 0) {
                fileName.textContent = 'Selected: ' + input.files[0].name;
                uploadBtn.style.display = 'inline-flex';
            } else {
                fileName.textContent = '';
                uploadBtn.style.display = 'none';
            }
        }

        // Preview image before upload
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const existingImg = document.querySelector('.profile-picture');
                    const defaultAvatar = document.querySelector('.default-avatar');
                    
                    if (existingImg) {
                        existingImg.src = e.target.result;
                    } else if (defaultAvatar) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'profile-picture';
                        img.alt = 'Profile Picture';
                        defaultAvatar.parentNode.replaceChild(img, defaultAvatar);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script src="logout.js"></script>
</body>
</html>