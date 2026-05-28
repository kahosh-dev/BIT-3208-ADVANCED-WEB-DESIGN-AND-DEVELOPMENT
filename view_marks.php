<?php
require_once 'functions.php';

if(!is_logged_in()){
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = db_prepare_execute(
"SELECT * FROM students WHERE user_id=?",
'i',
[$user_id]
);

$student = $stmt->get_result()->fetch_assoc();

if(!$student){
    die("Student record not found");
}

$stmt2 = db_prepare_execute(
"SELECT * FROM marks WHERE student_id=?",
'i',
[$student['id']]
);

$marks = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>

<title>View Marks</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:90%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    color:#333;
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

.back{
    display:inline-block;
    margin-top:20px;
    text-decoration:none;
    background:#007bff;
    color:white;
    padding:10px 15px;
    border-radius:5px;
}

.back:hover{
    background:#0056b3;
}

</style>

</head>

<body>

<div class="container">

<h2>
<?php echo htmlspecialchars($student['name']); ?>
- Academic Results
</h2>

<table>

<tr>
<th>Subject</th>
<th>Marks</th>
<th>Term</th>
<th>Date</th>
</tr>

<?php while($row = $marks->fetch_assoc()): ?>

<tr>

<td><?php echo htmlspecialchars($row['subject']); ?></td>

<td><?php echo $row['marks']; ?></td>

<td><?php echo htmlspecialchars($row['term']); ?></td>

<td><?php echo $row['created_at']; ?></td>

</tr>

<?php endwhile; ?>

</table>

<a class="back" href="student_dashboard.php">
⬅ Back
</a>

</div>

</body>
</html>