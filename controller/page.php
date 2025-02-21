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
  print_r($_POST['action']);
  if ($_POST['action'] === 'like') {
    extract($_POST);
    $id = ss()->id;
    $clicked = DB::fetch("select * from likes where board_idx = '$idx' and user_id = '$id'");
    print_r($clicked);
    if ($clicked) {
      DB::exec("delete from likes where board_idx = '$idx' and user_id = '$id'");
      move($_SERVER['HTTP_REFERER']);
    } else {
      DB::exec("insert into likes (board_idx, user_id) values ('$idx', '$id')");
      move($_SERVER['HTTP_REFERER']);
    }
  } else if ($_POST['action'] === 'edit') {
    extract($_POST);
    move('board/edit');
  } else if ($_POST['action'] === 'delete') {
    extract($_POST);
    DB::exec("delete from board where idx = '$idx'");
    move('/', 'deleted');
  } else {
    move($_SERVER['HTTP_REFERER'], 'Reported');
  }
});
post('/addComment', function() {
  extract($_POST);
  $id = ss()->id;
  echo $idx;
  echo $id;
  echo $comment;
  DB::exec("insert into comment (board_idx, user_id, content, time) values ($idx, '$id', '$comment', now())");
  move($_SERVER['HTTP_REFERER']);
});
post('/editProfile', function() {
  extract($_POST);
  echo $description;
  $from = $_FILES['img']['tmp_name'];
  $img = 'uploads/' . time() . $_FILES['img']['name'];
  if (move_uploaded_file($from, $img)) {
    DB::exec("update user set img = '$img', description = '$description', gender = '$gender', pw = '$pw' where id = '$id'");
  } else {
    DB::exec("update user set description = '$description', gender = '$gender', pw = '$pw' where id = '$id'");
  }
  move($_SERVER['HTTP_REFERER']);
});