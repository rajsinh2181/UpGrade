<?php

require_once "../connection.php";

extract($_POST);

if(isset($_POST['readQ'])) {
    $test_id = $_POST['id'];
    $sql = "SELECT * FROM question WHERE test_id='$test_id';";
    $query = mysqli_query($con, $sql);

    $data = "";
    $number = 1;
    while($res = mysqli_fetch_assoc($query)) {
        $data .= '<tr class="text-center">
            <td>'.$number.'</td>
            <td>'.$res['marks'].'</td>
            <td>'.$res['statement'].'</td>
            <td>'.$res['choice_a'].'</td>
            <td>'.$res['choice_b'].'</td>
            <td>'.$res['choice_c'].'</td>
            <td>'.$res['choice_d'].'</td>
            <td>'.$res['correct_choice'].'</td>
            <td> <button class="btn btn-danger" onclick="deleteQuestion('.$res['question_id'].', this)">Delete</button> </td>
            <td> <button class="btn btn-success" onclick="getQuestionInfo('.$res['question_id'].', this)">Edit</button> </td>
            </tr>';
        $number++;
    }

    echo $data;
}

if(isset($_POST['deleteid'])) {
    $question_id = $_POST['deleteid'];
    
    $sql = "DELETE FROM question WHERE question_id='$question_id';";
    $query = mysqli_query($con, $sql);

}

if(isset($_POST['test_id']) && isset($_POST['statement']) && isset($_POST['marks']) && isset($_POST['choice_a']) && isset($_POST['choice_b']) && isset($_POST['correct_choice'])) {

    $test_id = $_POST['test_id'];
    $marks = $_POST['marks'];
    $statement = $_POST['statement'];
    $choice_a = $_POST['choice_a'];
    $choice_b = $_POST['choice_b'];
    $choice_c = $_POST['choice_c'];
    $choice_d = $_POST['choice_d'];
    $correct_choice = $_POST['correct_choice'];

    $sql = "SELECT * FROM question WHERE test_id='$test_id';";
    $query = mysqli_query($con, $sql);
    $question_no = mysqli_num_rows($query) + 1;

    $sql = "INSERT INTO question (test_id, marks, question_no, statement, choice_a, choice_b, choice_c, choice_d, correct_choice) VALUES ('$test_id', '$marks', '$question_no', '$statement', '$choice_a', '$choice_b', '$choice_c', '$choice_d', '$correct_choice');";

    $query = mysqli_query($con, $sql);

    $data = '<tr class="text-center">
            <td>'.$question_no.'</td>
            <td>'.$marks.'</td>
            <td>'.$statement.'</td>
            <td>'.$choice_a.'</td>
            <td>'.$choice_b.'</td>
            <td>'.$choice_c.'</td>
            <td>'.$choice_d.'</td>
            <td>'.$correct_choice.'</td>
            <td> <button class="btn btn-danger" onclick="deleteQuestion('.$test_id.', this)">Delete</button> </td>
            <td> <button class="btn btn-success" onclick="getQuestionInfo('.$test_id.')">Edit</button> </td>
            </tr>';
    echo $data;
}

// Get Question ID for update
if(isset($_POST['id']) && isset($_POST['id']) != "") {
    $question_id = $_POST['id'];
    $sql = "SELECT * FROM question WHERE question_id='$question_id';";

    if(!$query = mysqli_query($con, $sql)) {
        exit(mysqli_error());
    }
    else {
        $response = array();
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                $response = $row;
            }
        }
        else {
            $response['status'] = 200;
            $response['message'] = "Data Not Found";
        }
    }

    echo json_encode($response);
}

// Update Question
if(isset($_POST['hidden_question_id'])) {

    $marks = $_POST['marks'];
    $statement = $_POST['statement'];
    $choice_a = $_POST['choice_a'];
    $choice_b = $_POST['choice_b'];
    $choice_c = $_POST['choice_c'];
    $choice_d = $_POST['choice_d'];
    $correct_choice = $_POST['correct_choice'];
    $hidden_question_id = $_POST['hidden_question_id'];

      
    $sql = "UPDATE question SET marks='$marks', statement='$statement', choice_a='$choice_a', choice_b='$choice_b', choice_c='$choice_c', choice_d='$choice_d', correct_choice='$correct_choice' WHERE question_id='$hidden_question_id'; ";

    mysqli_query($con, $sql);


}

?>