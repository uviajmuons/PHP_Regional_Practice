<?php
  $board = DB::fetchAll("select * from board b inner join user u on b.user_id = u.id order by time desc");
?>

<main class="main-board con">
  <section class="board-list">
    <?php foreach ($board as $b) {  ?>
      <?php $b->likes = DB::fetchAll("select count(*) as count from likes where board_idx = $b->idx"); ?>
      <?php $b->comments = DB::fetchAll("select count(*) as count from comment where board_idx = $b->idx"); ?>
      <a href="/board/<?= $b->idx; ?>" class="board-item-container">
        <article class="w1 board-item jb ac">
          <div class="board-user-info fc ac">
            <?php if ($b->img) { ?>
              <img src="<?= $b->img ?>" alt="profile" class="board-user-profile" />
            <?php } else { ?>
              <div class="board-user-profile fb">NP</div>
            <?php } ?>
            <p class="user-id"><?= $b->user_id ?></p>
          </div>
          <h2 class="board-title"><?= $b->title ?></h2>
          <div class="fx ac">
            <p class="time"><?= $b->time ?></p>
            <p class="likes"><b>❤️</b>&nbsp;<?= $b->likes[0]->count; ?></p>
            <p class="comments"><b>💬</b>&nbsp;<?= $b->comments[0]->count; ?></p>
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