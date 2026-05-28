<?php
require_once 'functions.php';

if(!is_logged_in()){
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Student Dashboard</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

.sidebar{
    width:250px;
    height:100vh;
    background:#0f172a;
    position:fixed;
    left:0;
    top:0;
    color:white;
    padding-top:20px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    padding:15px 25px;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
}

.main{
    margin-left:250px;
    padding:30px;
}

.card{
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    width:350px;
}

.card h2{
    color:#333;
}

.btn{
    display:block;
    background:#007bff;
    color:white;
    text-decoration:none;
    padding:12px;
    margin-top:20px;
    text-align:center;
    border-radius:5px;
}

.btn:hover{
    background:#0056b3;
}

</style>

</head>

<body>

<div class="sidebar">

<h2>
<i class="fas fa-user-graduate"></i>
Student Panel
</h2>

<a href="student_dashboard.php">
<i class="fas fa-home"></i>
Dashboard
</a>

<a href="view_marks.php">
<i class="fas fa-book"></i>
View Marks
</a>

<a href="main_dashboard.php">
<i class="fas fa-arrow-left"></i>
Main Dashboard
</a>

<a href="logout.php">
<i class="fas fa-sign-out-alt"></i>
Logout
</a>

</div>

<div class="main">

<div class="card">

<h2>
Welcome,
<?php echo htmlspecialchars($_SESSION['username']); ?>
</h2>

<p>
Access your academic information and marks here.
</p>

<a class="btn" href="view_marks.php">
<i class="fas fa-eye"></i>
View My Marks
</a>

</div>

</div>

</body>
</html>