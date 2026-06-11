<?php
require_once 'functions.php';

global $mysqli;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $username = sanitize_string($_POST['username']);
        $password = $_POST['password'];

        if(empty($username) || empty($password)){
            throw new Exception("All fields are required");
        }

        if(strlen($password) < 6){
            throw new Exception("Password must be at least 6 characters");
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        db_prepare_execute(
            "INSERT INTO users(username,password,role)
             VALUES(?,?, 'admin')",
            'ss',
            [$username,$hash]
        );

        header('Location: login.php');
        exit;

    } catch(Exception $e){
        $err = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Registration</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(to right,#007bff,#00c6ff);
}

.container{
    width:400px;
    margin:60px auto;
    background:white;
    padding:35px;
    border-radius:12px;
    box-shadow:0 0 20px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    color:#007bff;
    margin-bottom:25px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#0056b3;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:15px;
}

.back{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    color:#007bff;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<h2>
<i class="fas fa-user-shield"></i>
Admin Registration
</h2>

<?php if(!empty($err)) echo "<div class='error'>$err</div>"; ?>

<form method="post">

<input type="text"
name="username"
placeholder="Enter Username"
required>

<input type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit">
<i class="fas fa-user-plus"></i>
Register Admin
</button>

</form>

<a class="back" href="main_dashboard.php">
<i class="fas fa-arrow-left"></i>
Back
</a>

</div>

</body>
</html>