<?php
require_once "../Router.php";
get('/', function() {
  views('home');
});
get('/login', function() {
  if (ss()) return move('/');
  views('user/login', [], false, false);
});
get('/signup', function() {
  if (ss()) return move('/');
  views('user/register', [], false, false);
});
// post('/captcha', function() {
//   extract($_POST);
//   views('user/captcha', [], false, false);
// });
post('/loginCtrl', function() {
  extract($_POST);
  $user = DB::fetch("select * from user where id = '$id' and pw = '$pw'");
  if (!$user) return move('/login', "Wrong ID or PW. Try again.");
  $_SESSION['ss'] = $user;
  move('/');
});
post('/registerCtrl', function() {
  extract($_POST);
  $unique = DB::fetch("select * from user where id = '$id'");
  if ($unique) return move('/signup', 'The ID is already taken. Try again.');
  DB::exec("insert into user (id, pw, join_date) values ('$id', '$pw', curdate())");
  move('/', 'signup successful');
});
get('/logout', function() {
  session_destroy();
  move('/');
});
get('/post', function() {
  views('board/post');
});
get('/calendar', function() {
  views('calendar');
});
get('/mypage', function() {
  $data = ['fetch' => DB::fetch("select * from user where id = '$id'")];
  views('user/user', $data);
});
get('/user/{id}', function($id) {
  $data = ['fetch' => DB::fetch("select * from user where id = '$id'")];
  views('user/user', $data);
});
get('/board/{id}', function($id) {
  $data = ['fetch' => DB::fetch("select * from board where idx = '$id'")];
  views('board/boardDetail', $data);
});
post('/addBoard', function() {
  extract($_POST);
  $id = ss()->id;
  $from = $_FILES['img']['tmp_name'];
  $img = 'uploads/' . time() . $_FILES['img']['name'];
  if (move_uploaded_file($from, $img)) {
    DB::exec("insert into board (user_id, title, content, time, img) values ('$id', '$title', '$content', now(), '$img')");
  } else {
    DB::exec("insert into board (user_id, title, content, time) values ('$id', '$title', '$content', now())");
  }
  move('/');
});
post('/likePost', function() {
  extract($_POST);
  if ($_POST['action'] === 'like') {
    $id = ss()->id;
    $clicked = DB::fetch("select * from likes where board_idx = '$idx' and user_id = '$id'");
    if ($clicked) {
      DB::exec("delete from likes where board_idx = '$idx' and user_id = '$id'");
      move($_SERVER['HTTP_REFERER']);
    } else {
      DB::exec("insert into likes (board_idx, user_id) values ('$idx', '$id')");
      move($_SERVER['HTTP_REFERER']);
    }
  } else if ($_POST['action'] === 'edit') {
    $data = ['fetch' => DB::fetch("select * from board where idx = $idx")];
    views('board/edit', $data);
  } else if ($_POST['action'] === 'delete') {
    DB::exec("delete from board where idx = '$idx'");
    move('/', 'deleted');
  } else {
    move($_SERVER['HTTP_REFERER'], 'Reported');
  }
});
post('/addComment', function() {
  extract($_POST);
  $id = ss()->id;
  DB::exec("insert into comment (board_idx, user_id, content, time) values ($idx, '$id', '$comment', now())");
  move($_SERVER['HTTP_REFERER']);
});
post('/editProfile', function() {
  extract($_POST);
  $from = $_FILES['img']['tmp_name'];
  $img = 'uploads/' . time() . $_FILES['img']['name'];
  if (move_uploaded_file($from, $img)) {
    DB::exec("update user set img = '$img', description = '$description', gender = '$gender', pw = '$pw' where id = '$id'");
  } else {
    DB::exec("update user set description = '$description', gender = '$gender', pw = '$pw' where id = '$id'");
  }
  move($_SERVER['HTTP_REFERER']);
});
post('/editBoard', function() {
  extract($_POST);
  if ($_POST['action'] === "edit") {
    DB::exec("update board set img = '$img', content = '$content', title = '$title', status = 'fixed' where idx = '$idx'");
  } else {
    $from = $_FILES['img']['tmp_name'];
    $img = 'uploads/' . time() . $_FILES['img']['name'];
    move_uploaded_file($from, $img);
    DB::exec("update board set img = '$img', content = '$content', title = '$title', status = 'fixed' where idx = '$idx'");
  }
  move('/');
});
post('/addTodo', function() {
  extract($_POST);
  echo $todo;
  echo $begindate;
  echo $enddate;
  echo $content;
  $id = ss()->id;
  DB::exec("insert into todo (user_id, title, content, begindate, enddate, color) values ('$id', '$todo', '$content', '$begindate', '$enddate', '$color')");
  move($_SERVER['HTTP_REFERER']);
});
get('/todo/{id}', function($id) {
  $data = ['fetch' => DB::fetch("select * from todo where idx = '$id'")];
  views('todo', $data);
});