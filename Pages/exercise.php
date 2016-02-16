<?php

// Connect to database and fetch questions.
require_once('db_conn.php');

// Create a query to fetch five questions from the selected module.
$query = "SELECT * FROM SB_QUESTIONS WHERE moduleID = 'givenmodule'";

// Run the query
$query_result = $dbc->query($query);

// Count the number of returned items from the database.
$num_questions_returned = $query_result->num_rows;
if ($num_questions_returned < 1){
    echo "There is no question in the database";
    exit();
}

// Create an array to hold all the returned questions.
$allQuestionsArray = array();

// Add all the questions from the result to the questions array.
while ($row = $query_result->fetch_assoc()) {
    $allQuestionsArray[] = $row;
}

// Create an array which pick 5 random entires out of the array.
$questionsArray = array_rand($allQuestionsArray, 5);

// Build the questions array from query result.
$questions = array();
foreach($questionsArray as $question) {
    $questions[$question['questionID']] = $question['questionContent'];
 }

// Create an array of answers.
foreach($questionsArray as $question) {
    $answersQueryResult = $dbc -> query("SELECT * FROM SB_ANSWERS WHERE questionID = $question['questionID']");
    $answersArray = array();
    while ($row = $answersQueryResult->fetch_assoc()) {
        $answersArray[] = $row;
    }
    $choices = array();
    foreach ($answersArray as $row) {
        $choices[$row['questionID']] = array($row['choice1'], $row['choice2'], $row ['choice3'], $row['choice4'], $row['choice5']);
}

?>
