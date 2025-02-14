<?php
require_once "../Router.php";
get('/', function() {
  views('home');
});
get('/login', function() {
  if (ss()) return move('/');
  views('user/login', [], false);
});
get('/signup', function() {
  if (ss()) return move('/');
  views('user/register', [], false);
});
post('/loginCtrl', function() {
  extract($_POST);
  $user = DB::fetch("select * from user where id = '$id' and pw = '$pw'");
  if (!$user) return move('/login', "Wrong ID or PW. Try again.");
  $_SESSION['ss'] = $user;
  move('/', 'Login Successful!');
});
post('/registerCtrl', function() {
  extract($_POST);
  $unique = DB::fetch("select * from user where id = '$id'");
  if ($unique) return move('/signup', 'The ID is already taken. Try again.');
  DB::exec("insert into user (id, pw) values ('$id', '$pw')");
  move('/', 'Signup Successful!');
});
get('/logout', function() {
  session_destroy();
  move('/');
});