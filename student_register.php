<?php
require_once 'functions.php';

global $mysqli;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $username = sanitize_string($_POST['username']);
        $password = $_POST['password'];
        $name = sanitize_string($_POST['name']);
        $reg_no = sanitize_string($_POST['reg_no']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if(empty($username) || empty($password) || empty($name) || empty($reg_no)){
            throw new Exception("Please fill all required fields");
        }

        if(strlen($password) < 6){
            throw new Exception("Password must be at least 6 characters");
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        db_prepare_execute(
            "INSERT INTO users(username,password,role,email)
             VALUES(?,?, 'student',?)",
            'sss',
            [$username,$hash,$email]
        );

        $user_id = $mysqli->insert_id;

       

    db_prepare_execute(
    "INSERT INTO students(user_id,reg_no,name)
     VALUES(?,?,?)",
    'iss',
    [$user_id,$reg_no,$name]
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

<title>Student Registration</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(to right,#28a745,#20c997);
}

.container{
    width:450px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:12px;
    box-shadow:0 0 20px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    color:#28a745;
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
    background:#28a745;
    color:white;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#218838;
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
    color:#28a745;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<h2>
<i class="fas fa-user-graduate"></i>
Student Registration
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

<input type="text"
name="name"
placeholder="Full Name"
required>

<input type="text"
name="reg_no"
placeholder="Registration Number"
required>

<input type="email"
name="email"
placeholder="Email Address">



<button type="submit">
<i class="fas fa-user-plus"></i>
Register Student
</button>

</form>

<a class="back" href="main_dashboard.php">
<i class="fas fa-arrow-left"></i>
Back
</a>

</div>

</body>
</html>