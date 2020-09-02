<?php
require_once('config.php');
require_once('Quiz.php');

$quiz = new Quiz();
$data = $quiz->getCurrentQuiz();

shuffle($data['a']);
?>
<h1>
  <?= h($data['q']) ?>
</h1>

<ul>
  <?php foreach ($data['a'] as $a): ?>
  <li class="answer">
    <?= h($a) ?>
  </li>
  <?php endforeach; ?>
</ul>

<div id="btn" class="disabled">
  Next Question
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="quiz.js"></script>

