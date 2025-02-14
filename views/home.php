<?php
  $board = DB::fetchAll("select * from board order by time");
?>
<main class="main-board con">
  <section class="board-list">
    <?php foreach ($board as $b) {  ?>
      <a href="/board">
        <article class="w1 board-item jb ac">
          <div class="board-user-info fx">
            <img src="" alt="profile" />
            <p class="user-id"><?= $b->user_id ?></p>
          </div>
          <h2 class="board-title"><?= $b->title ?></h2>
          <p class="time"><?= $b->time ?></p>
        </article>
      </a>
    <?php } ?>
  </section>
  <?php if (ss()) { ?>
    <a href="/post" class="btn fb hov abs post">✏️Post</a>
  <?php } ?>
</main>