<?php
require_once('config.php');
require_once('Quiz.php');

$quiz = new Quiz();
$correctAnswer = $quiz->checkAnswer();

header('Content-Type: application/json; charset=UTF-8');

echo json_encode([
  'correct_answer' => $correctAnswer,
]);

