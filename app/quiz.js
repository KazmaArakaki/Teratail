$(function () {
  $('.answer').on('click', function () {
    var $selected = $(this);
    var answer = $selected.text();

    $.post('/_answer.php', {}).done(function (res) {
      alert(res.correct_answer);
    });
  });
});

