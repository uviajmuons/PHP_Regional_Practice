<?php
$comments = DB::fetchAll("select * from comment c inner join user u on c.user_id = u.id where board_idx = $fetch->idx order by c.time desc");
$like = DB::fetchAll("select count(*) as count from likes where board_idx = $fetch->idx");
$like = $like[0]->count;
?>
<main class="con fc">
  <section>
    <h1 class="post-title"><?= $fetch->title; ?></h1>
    <div class="jb post-nav">
      <p>Post by <?= $fetch->user_id; ?></p>
      <div class="fx g1">
        <p><?= $fetch->time; ?></p>
        <?php if ($like === 1) { ?>
          <p><?= $like; ?> like</p>
        <?php } else { ?>
          <p><?= $like ?> likes</p>
        <?php } ?>
      </div>
    </div>
    <div class="post-content rel">
      <p><?= $fetch->content; ?></p>
      <form action="/likePost" method="post" class="fx abs g1 post-reaction">
        <input type="hidden" name="idx" value="<?= $fetch->idx; ?>">
        <?php if (ss()) { ?>
          <button class="btn hov" name="action" value="like" id="like">❤️ I like this post!</button>
        <?php } ?>
        <button class="btn hov" id="report">⚠️ Report</button>
      </form>
    </div>
  </section>
  <section class="comment con">
    <form action="/addComment" method="post" class="fx w1 rel">
      <input type="hidden" name="idx" value="<?= $fetch->idx; ?>">
      <input name="comment" class="f1" id="add-comment" placeholder="Add a comment to share your idea :)" />
      <button class="cp abs">Comment</button>
    </form>
    <?php foreach ($comments as $c) { ?>
      <article class="fx ac">
        <div class="comment-user fc ac">
          <?php if ($c->img) { ?>
            <img src="<?= $b->img ?>" alt="profile" class="board-user-profile" />
          <?php } else { ?>
            <div class="board-user-profile fb">NP</div>
            <?php } ?>
          <p class="user-id"><?= $c->user_id ?></p>
        </div>
        <div class="jb ac f1 comment-container">
          <div class="f1">
            <p><?= $c->content; ?></p>
          </div>
          <p><?= $c->time; ?></p>
        </div>
      </article>
    <?php } ?>
  </section>
</main>
<script>
  function generateRandomHexColor() { return `#${((r, g, b) => (r = Math.floor(Math.random() * 156) + 100, g = Math.floor(Math.random() * 156) + 100, b = Math.floor(Math.random() * 156) + 100, `${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`))(0, 0, 0)}`; }
  $$('div.board-user-profile').forEach(({ style }) => style.backgroundColor = generateRandomHexColor());
</script>