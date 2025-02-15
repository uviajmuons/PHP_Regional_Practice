<?php

function ss() {
  return $_SESSION['ss'] ?? false;
}

function script($script) {
  echo "<script>$script</script>";
}

function move($uri, $msg = null) {
  if ($msg) script("alert('$msg');");
  script("location.replace('$uri');");
}

function views($page, $data = [], $banner = true, $footer = true) {
  extract($data);
  require_once("../views/template/header.php");
  if ($banner) require_once("../views/template/banner.php");
  require_once("../views/$page.php"); 
  if ($footer) require_once("../views/template/footer.php");
}