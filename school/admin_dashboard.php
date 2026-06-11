<?php
require_once 'functions.php';

if(!is_logged_in() || !is_admin()){
    header('Location: login.php');
    exit;
}

$res = db()->query(
"SELECT students.*, users.username
FROM students
JOIN users ON students.user_id = users.id"
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>

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
    background:#1e293b;
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
    background:#334155;
}

.main{
    margin-left:250px;
    padding:30px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.card h3{
    margin:0;
    color:#333;
}

.card p{
    font-size:25px;
    color:#007bff;
}

.table-container{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#007bff;
    color:white;
    padding:12px;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

.manage{
    background:#28a745;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}

.manage:hover{
    background:#218838;
}

</style>

</head>

<body>

<div class="sidebar">

<h2>
<i class="fas fa-user-shield"></i>
Admin Panel
</h2>

<a href="admin_dashboard.php">
<i class="fas fa-home"></i>
Dashboard
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

<h1>
Welcome,
<?php echo htmlspecialchars($_SESSION['username']); ?>
</h1>

<div class="cards">

<div class="card">
<h3>Total Students</h3>
<p>
<?php echo $res->num_rows; ?>
</p>
</div>

<div class="card">
<h3>System Role</h3>
<p>Admin</p>
</div>

</div>

<div class="table-container">

<h2>Registered Students</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Reg No</th>
<th>Username</th>
<th>Action</th>
</tr>

<?php while($row = $res->fetch_assoc()): ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['reg_no']); ?></td>

<td><?php echo htmlspecialchars($row['username']); ?></td>

<td>

<a class="manage"
href="manage_marks.php?student_id=<?php echo $row['id']; ?>">
<i class="fas fa-edit"></i>
Manage Marks
</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>