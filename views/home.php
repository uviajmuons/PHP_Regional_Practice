<?php
  $user_id;
  $board = DB::fetchAll("select * from board order by time desc");
?>

<main class="main-board con">
  <section class="board-list">
    <?php foreach ($board as $b) {  ?>
      <?php $user_id = $b->user_id; ?>
      <?php $profileImg = DB::fetch("select img from user where id = '$user_id'"); ?>
      <a href="/board" class="board-item-container">
        <article class="w1 board-item jb ac">
          <div class="board-user-info fc ac">
            <?php if ($profileImg->img) { ?>
              <img src="<?= $b->img ?>" alt="profile" class="board-user-profile" />
            <?php } else { ?>
              <div class="board-user-profile fb">NP</div>
            <?php } ?>
            <p class="user-id"><?= $b->user_id ?></p>
          </div>
          <h2 class="board-title"><?= $b->title ?></h2>
          <div class="fx ac">
            <p class="time"><?= $b->time ?></p>
            <p class="likes"><b>❤️</b>&nbsp;<?= $b->likes ?></p>
          </div>
        </article>
      </a>
    <?php } ?>
  </section>
  <?php if (ss()) { ?>
    <a href="/post" class="btn fb hov abs post">✏️Post</a>
  <?php } ?>
</main>

<script>
  function generateRandomHexColor() { return `#${((r, g, b) => (r = Math.floor(Math.random() * 156) + 100, g = Math.floor(Math.random() * 156) + 100, b = Math.floor(Math.random() * 156) + 100, `${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`))(0, 0, 0)}`; }
  $$('div.board-user-profile').forEach(({ style }) => style.backgroundColor = generateRandomHexColor());
</script>