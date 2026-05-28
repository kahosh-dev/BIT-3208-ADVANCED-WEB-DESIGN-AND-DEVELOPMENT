<?php
require_once 'functions.php';
?>

<!DOCTYPE html>
<html>
<head>

<title>Biao Wang School Management System</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

.navbar{
    background:#007bff;
    color:white;
    padding:20px;
    text-align:center;
    font-size:28px;
    font-weight:bold;
}

.hero{
    text-align:center;
    padding:50px 20px;
}

.hero h1{
    color:#333;
    margin-bottom:10px;
}

.hero p{
    color:#666;
}

.cards{
    width:90%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:30px;
    margin-top:40px;
}

.card{
    background:white;
    padding:35px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
    text-align:center;
}

.card i{
    font-size:50px;
    color:#007bff;
    margin-bottom:20px;
}

.card h2{
    margin-bottom:15px;
}

.btn{
    display:block;
    background:#007bff;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:6px;
    margin-top:15px;
}

.btn:hover{
    background:#0056b3;
}

.footer{
    text-align:center;
    margin-top:50px;
    padding:20px;
    color:#666;
}

</style>

</head>

<body>

<div class="navbar">
<i class="fas fa-school"></i>
School Management System
</div>

<div class="hero">

<h1>Welcome to Student Marks Management System</h1>

<p>
Register or Login as Student or Admin
</p>

</div>

<div class="cards">

<div class="card">

<i class="fas fa-user-graduate"></i>

<h2>Student Portal</h2>

<a class="btn" href="student_register.php">
Student Registration
</a>

<a class="btn" href="login.php">
Student Login
</a>

</div>

<div class="card">

<i class="fas fa-user-shield"></i>

<h2>Admin Portal</h2>

<a class="btn" href="admin_register.php">
Admin Registration
</a>

<a class="btn" href="login.php">
Admin Login
</a>

</div>

</div>

<div class="footer">
© <?php echo date('Y'); ?>Biao Wang School Management System
</div>

</body>
</html>