<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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

        .settings-container {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .settings-card {
            background: var(--card-gradient);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .settings-card h2 {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
        }

        .settings-card h2 i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-info {
            flex: 1;
        }

        .setting-info h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .setting-info p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .setting-control {
            margin-left: 20px;
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:focus + .slider {
            box-shadow: 0 0 1px var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Select Dropdown */
        .select-wrapper {
            position: relative;
            width: 150px;
        }

        .select-wrapper select {
            appearance: none;
            width: 100%;
            padding: 8px 12px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            color: white;
            font-family: inherit;
            cursor: pointer;
        }

        .select-wrapper:after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .select-wrapper select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        /* Buttons */
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

        .btn-outline {
            background-color: transparent;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
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

        .save-settings {
            margin-top: 20px;
            text-align: right;
        }

        .danger-zone {
            background-color: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.3);
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
        }

        .danger-zone h3 {
            color: var(--error-color);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .danger-zone p {
            margin-bottom: 15px;
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

            .setting-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .setting-control {
                margin-left: 0;
                margin-top: 10px;
                align-self: flex-end;
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
                    <li><a href="forgot_password.php"><i class="fas fa-key"></i> Change Password</a></li>
                    <li><a href="setting.php" class="active"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="contactus.html"><i class="fas fa-envelope"></i> Contact Us</a></li>
                    <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Settings</h1>
                <p>Manage your account settings and preferences</p>
            </div>

            <div class="settings-container">
                
                <div class="settings-card">
                    <h2><i class="fas fa-user-cog"></i> Account Settings</h2>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Profile Visibility</h3>
                            <p>Control who can see your profile information</p>
                        </div>
                        <div class="setting-control">
                            <div class="select-wrapper">
                                <select id="profileVisibility">
                                    <option value="public">Public</option>
                                    <option value="friends">Friends Only</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Two-Factor Authentication</h3>
                            <p>Add an extra layer of security to your account</p>
                        </div>
                        <div class="setting-control">
                            <label class="switch">
                                <input type="checkbox" id="twoFactorAuth">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                   
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Edit Profile</h3>
                            <p>Update your personal information</p>
                        </div>
                        <div class="setting-control">
                            <button class="btn btn-primary" onclick="window.location.href='update_prof.php'">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="settings-card">
                    <h2><i class="fas fa-palette"></i> Appearance</h2>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Theme</h3>
                            <p>Choose your preferred theme</p>
                        </div>
                        <div class="setting-control">
                            <div class="select-wrapper">
                                <select id="theme">
                                    <option value="dark">Dark (Default)</option>
                                    <option value="light">Light</option>
                                    <option value="system">System Preference</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Font Size</h3>
                            <p>Adjust the text size</p>
                        </div>
                        <div class="setting-control">
                            <div class="select-wrapper">
                                <select id="fontSize">
                                    <option value="small">Small</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="large">Large</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                           
                <div class="settings-card">
                    <h2><i class="fas fa-bell"></i> Notifications</h2>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Email Notifications</h3>
                            <p>Receive notifications via email</p>
                        </div>
                        <div class="setting-control">
                            <label class="switch">
                                <input type="checkbox" id="emailNotifications" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Push Notifications</h3>
                            <p>Receive notifications on your device</p>
                        </div>
                        <div class="setting-control">
                            <label class="switch">
                                <input type="checkbox" id="pushNotifications" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Marketing Emails</h3>
                            <p>Receive promotional emails and offers</p>
                        </div>
                        <div class="setting-control">
                            <label class="switch">
                                <input type="checkbox" id="marketingEmails">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Email Digest Frequency</h3>
                            <p>How often you receive email summaries</p>
                        </div>
                        <div class="setting-control">
                            <div class="select-wrapper">
                                <select id="emailDigest">
                                    <option value="daily">Daily</option>
                                    <option value="weekly" selected>Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="never">Never</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                              
                <div class="settings-card">
                    <h2><i class="fas fa-shield-alt"></i> Privacy</h2>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Activity Status</h3>
                            <p>Show when you're active on the platform</p>
                        </div>
                        <div class="setting-control">
                            <label class="switch">
                                <input type="checkbox" id="activityStatus" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Data Sharing</h3>
                            <p>Allow us to use your data to improve our services</p>
                        </div>
                        <div class="setting-control">
                            <label class="switch">
                                <input type="checkbox" id="dataSharing" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    
                    <div class="danger-zone">
                        <h3>Danger Zone</h3>
                        <p>Once you delete your account, there is no going back. Please be certain.</p>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete Account
                        </button>
                    </div>
                </div>
                
                <div class="save-settings">
                    <button class="btn btn-primary" id="saveSettings">
                        <i class="fas fa-save"></i> Save All Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
       
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Save settings
        document.getElementById('saveSettings').addEventListener('click', function() {
           
            alert('Settings saved successfully!');
            
           
            console.log('Settings saved:', {
                profileVisibility: document.getElementById('profileVisibility').value,
                twoFactorAuth: document.getElementById('twoFactorAuth').checked,
                theme: document.getElementById('theme').value,
                fontSize: document.getElementById('fontSize').value,
                reducedMotion: document.getElementById('reducedMotion').checked,
                emailNotifications: document.getElementById('emailNotifications').checked,
                pushNotifications: document.getElementById('pushNotifications').checked,
                marketingEmails: document.getElementById('marketingEmails').checked,
                emailDigest: document.getElementById('emailDigest').value,
                activityStatus: document.getElementById('activityStatus').checked,
                dataSharing: document.getElementById('dataSharing').checked            
            });
        });
        
        
        document.querySelector('.btn-danger').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                alert('Account deletion request submitted. You will receive a confirmation email.');
            }
        });
    </script>
    <script src="logout.js"></script>
</body>
</html>