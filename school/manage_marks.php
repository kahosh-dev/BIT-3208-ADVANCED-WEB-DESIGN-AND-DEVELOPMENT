<?php
require_once 'functions.php';

if(!is_logged_in() || !is_admin()){
    header('Location: login.php');
    exit;
}

$student_id = $_GET['student_id'] ?? 0;

/* ADD MARK */
if(isset($_POST['add_mark'])){

    $subject = sanitize_string($_POST['subject']);
    $marks = (int)$_POST['marks'];
    $term = sanitize_string($_POST['term']);

    db_prepare_execute(
        "INSERT INTO marks(student_id,subject,marks,term)
         VALUES(?,?,?,?)",
        'isis',
        [$student_id,$subject,$marks,$term]
    );

    header("Location: manage_marks.php?student_id=$student_id");
    exit;
}

/* UPDATE MARK */
if(isset($_POST['update_mark'])){

    $mark_id = (int)$_POST['mark_id'];

    $subject = sanitize_string($_POST['subject']);
    $marks = (int)$_POST['marks'];
    $term = sanitize_string($_POST['term']);

    db_prepare_execute(
        "UPDATE marks
         SET subject=?, marks=?, term=?
         WHERE id=?",
        'sisi',
        [$subject,$marks,$term,$mark_id]
    );

    header("Location: manage_marks.php?student_id=$student_id");
    exit;
}

/* DELETE MARK */
if(isset($_GET['delete'])){

    $delete_id = (int)$_GET['delete'];

    db_prepare_execute(
        "DELETE FROM marks WHERE id=?",
        'i',
        [$delete_id]
    );

    header("Location: manage_marks.php?student_id=$student_id");
    exit;
}

/* GET STUDENT */
$stmt = db_prepare_execute(
    "SELECT * FROM students WHERE id=?",
    'i',
    [$student_id]
);

$student = $stmt->get_result()->fetch_assoc();

/* GET MARKS */
$stmt2 = db_prepare_execute(
    "SELECT * FROM marks WHERE student_id=?",
    'i',
    [$student_id]
);

$marks = $stmt2->get_result();

/* EDIT */
$edit = null;

if(isset($_GET['edit'])){

    $edit_id = (int)$_GET['edit'];

    $stmt3 = db_prepare_execute(
        "SELECT * FROM marks WHERE id=?",
        'i',
        [$edit_id]
    );

    $edit = $stmt3->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Marks</title>

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
}

.sidebar a:hover{
    background:#334155;
}

.main{
    margin-left:250px;
    padding:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    margin-bottom:30px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    background:#007bff;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#0056b3;
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

.edit{
    background:orange;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}

.delete{
    background:red;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}

</style>

</head>

<body>

<div class="sidebar">

<h2>
<i class="fas fa-book"></i>
Marks Panel
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

<div class="card">

<h2>
Manage Marks -
<?php echo htmlspecialchars($student['name']); ?>
</h2>

<form method="post">

<input type="text"
name="subject"
placeholder="Subject"
value="<?php echo $edit['subject'] ?? ''; ?>"
required>

<input type="number"
name="marks"
placeholder="Marks"
value="<?php echo $edit['marks'] ?? ''; ?>"
required>

<input type="text"
name="term"
placeholder="Term"
value="<?php echo $edit['term'] ?? ''; ?>"
required>

<?php if($edit): ?>

<input type="hidden"
name="mark_id"
value="<?php echo $edit['id']; ?>">

<button type="submit" name="update_mark">
<i class="fas fa-edit"></i>
Update Mark
</button>

<?php else: ?>

<button type="submit" name="add_mark">
<i class="fas fa-plus"></i>
Add Mark
</button>

<?php endif; ?>

</form>

</div>

<div class="card">

<h2>Student Marks</h2>

<table>

<tr>
<th>ID</th>
<th>Subject</th>
<th>Marks</th>
<th>Term</th>
<th>Actions</th>
</tr>

<?php while($row = $marks->fetch_assoc()): ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['subject']); ?></td>

<td><?php echo $row['marks']; ?></td>

<td><?php echo htmlspecialchars($row['term']); ?></td>

<td>

<a class="edit"
href="manage_marks.php?student_id=<?php echo $student_id; ?>&edit=<?php echo $row['id']; ?>">
Edit
</a>

<a class="delete"
href="manage_marks.php?student_id=<?php echo $student_id; ?>&delete=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>