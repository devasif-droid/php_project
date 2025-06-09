<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: login.html");
    exit();
}
$user_id=$_SESSION['user_id']; 
$email=$_SESSION['email'];

$servername="localhost";
$username="root";
$password="";    
$dbname="new_form";

$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection Failed".$conn->connect_error);
}

$sql=$conn->prepare("SELECT name,email,gender,country from students WHERE id=?");
$sql->bind_param("i",$user_id);
$sql->execute();
$sql->bind_result($name,$email,$gender,$country); 
$sql->fetch();

$sql->close();
$conn->close(); 
?>  

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        h1 {
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        .box {
            margin-left: 300px;
            background: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            width: 80%;
            padding: 20px;
            min-height: 95vh;
        }

        .user-detail {
            background: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(71, 95, 81, 0.8) 100%);
            width: 300px;
            color: white;
            padding: 50px 20px;
            margin: 0 auto;
            font-size: 18px;
            border-radius: 10px;
            text-align: center;
        }

        .user-detail button {
            margin-top: 30px;
            padding: 10px 30px;
            background-color: rgb(0, 255, 190);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .user-detail button:hover {
            background-color: rgb(0, 200, 150);
            transform: scale(1.05);
        }

        .user-detail h4 {
            margin-top: 30px;
            font-size:small;
        }

        .user-detail h4 a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
            
        }

        .user-detail h4 a:hover {
            color: rgb(0, 255, 190);
        
        }

        .chng_pass {
            margin-bottom: 30px;
            color: white;
        }

        .chng_pass label {
            display: inline-block;
            width: 180px;
        }

        input[type="password"] {
            width: 200px;
            padding: 8px;
            background: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 30px;
            border: none;
            background-color: grey;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: black;
        }

        /* leftSidebar */
        .leftsidebar{
            display: flex;
            position:fixed;
            flex-direction: column;
            background: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            height: 100vh;
            padding-top: 20px;
            width: 250px;
            color: white;
            left:0;
            top:0;
            
        }
        .leftsidebar h3{
            text-align: center;
            padding-bottom: 20px;
        }
        .leftsidebar ul{
            list-style-type: none;
            padding-bottom: 20px;
        }
        .leftsidebar li a{
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .leftsidebar li a:hover{
            background: radial-gradient(circle, rgb(126, 142, 158) 30%, rgba(74, 173, 114, 0.8) 100%);
            cursor: pointer;
            color: rgb(0, 255, 190);
            font-size:large;
        }
       

        @media screen and (max-width: 768px) {
            .box {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }

            .leftsidebar {
                position: static;
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-around;
                padding: 10px 0;
            }

            .user-detail {
                width: 90%;
                font-size: 16px;
            }

            .chng_pass label {
                width: 100%;
                display: block;
                margin-bottom: 5px;
            }

            input[type="password"] {
                width: 100%; 
            }
        }
        
    </style>
</head>
<body>
    
    <div class="box">
    <h1>Welcome, <?php echo $name; ?>!</h1> 
    <div class="user-detail">
        <p ><i class="fa fa-envelope"></i> Email: <?php echo $email; ?></p> 
        <p> <i class="fa fa-user"></i> Gender: <?php echo $gender; ?></p> 
        <p> <i class="fa fa-globe" ></i> Country: <?php echo $country; ?></p>
        <button onclick="window.location.href='update_prof.php'">Update Profile</button>
        <button onclick="logout()">Logout </button>
        <h4>
            Follow:
            <a href="https://github.com/yourusername" target="_blank"><i class="fa fa-github"></i></a>
            <a href="https://linkedin.com/in/yourusername" target="_blank"><i class="fa fa-linkedin"></i></a>
            <a href="https://twitter.com/yourusername" target="_blank"><i class="fa fa-twitter"></i></a>
        </h4> 
    </div> 

    </div>

    <!-- leftside--> 
    <div class="leftsidebar">
        <h3> Dashboard </h3>
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="forgot_password.php">Change Password</a></li>
            <li><a href="setting.php">Settings</a> </li> 
            <li><a href="contactus.html">Contact-Us</a> </li>
            <li> <a onclick="logout()">Logout</a> </li>
            
        </ul> 
    </div>
    
    
</body>
<script src ="logout.js"> </script>
</html> 