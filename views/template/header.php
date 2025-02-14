<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FakeBook</title>
  <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
  <header class="w1 fix">
    <div class="con ac h1 jb">
      <a href="/" class="hov logo round"><h1>FakeBook</h1></a>
      <?php if (ss()) { ?>
        <div class="fx g1">
          <a href="/calendar" class="fb btn sign hov">Calendar</a>
          <a href="/mypage" class="fb btn sign hov">My Page</a>
          <a href="/logout" class="fb btn sign hov">Sign Out</a>
        </div>
        <?php } else { ?>
          <div class="fx g1">
            <a href="/login" class="fb btn sign hov">Sign In</a>
            <a href="/signup" class="fb btn sign hov">Sign Up</a>
        </div>
      <?php } ?>
    </div>
  </header>
  <div class="header-space"></div>
  <script src="/js/common.js"></script>