<?php

function script($script) {
  echo "<script>$script</script>";
}

function move($uri, $msg = null) {
  if ($msg) script("alert('$msg')");
  script("location.replace = $uri");
}

function views($page, $data = []) {
  extract($data);
  require_once("../views/template/header.php");
  require_once("../views/$page.php"); 
}