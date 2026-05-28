<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = sanitize_string($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    try {

        $stmt = db_prepare_execute(
            'SELECT id, password, role FROM users WHERE username=?',
            's',
            [$username]
        );

        $res = $stmt->get_result();

       if ($user = $res->fetch_assoc()) {

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

        if ($remember) {
            setcookie('remember_user', $username, time()+60*60*24*30, '/');
        }

        /* REDIRECT BASED ON ROLE */

        if($user['role'] === 'admin'){

            header('Location: admin_dashboard.php');

        } else {

            header('Location: student_dashboard.php');

        }

        exit;
    }
}
        $err = "Invalid Username or Password";

    } catch(Exception $e){
        $err = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

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
    margin:80px auto;
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
<i class="fas fa-sign-in-alt"></i>
Login
</h2>

<?php if(!empty($err)) echo "<div class='error'>$err</div>"; ?>

<form method="post">

<input type="text"
name="username"
placeholder="Username"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<label>
<input type="checkbox" name="remember">
Remember Me
</label>

<br><br>

<button type="submit">
<i class="fas fa-lock-open"></i>
Login
</button>

</form>

<a class="back" href="main_dashboard.php">
<i class="fas fa-arrow-left"></i>
Back
</a>

</div>

</body>
</html>