<?php

require_once 'functions.php';

header('Content-Type: application/json');

try{

    $stmt = db_prepare_execute(
        "SELECT students.name,
                students.reg_no,
                marks.subject,
                marks.marks,
                marks.term
         FROM marks
         JOIN students
         ON marks.student_id = students.id"
    );

    $result = $stmt->get_result();

    $data = [];

    while($row = $result->fetch_assoc()){

        $data[] = $row;
    }

    echo json_encode(
        $data,
        JSON_PRETTY_PRINT
    );

}catch(Exception $e){

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}

?>