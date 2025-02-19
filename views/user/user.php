<?php
  $id = $fetch->id;
  $user = DB::fetch("select * from user where id = '$id'");
  if (!$user) return move('/', 'No user found');
  $isMypage = ss() && $id === ss()->id;
  $board = DB::fetchAll("select * from board b inner join user u on b.user_id = u.id where b.user_id = '$id' order by time desc");
  $boardNum = DB::fetchAll("select count(*) as count from board b inner join user u on b.user_id = u.id where b.user_id = '$id' order by time desc");
  $boardNum = $boardNum[0]->count;
  $likes = DB::fetchAll("select count(*) as count from likes where user_id = '$id'");
  $likes = $likes[0]->count;
?>
<main class="con">
  <?php if ($isMypage) { ?>
    <h1 class="section-title upc mt">my page</h1>
  <?php } else { ?>
    <h1 class="section-title upc mt">user page</h1>
  <?php } ?>
  <form action="/editProfile" class="fc jb ac" method="post" enctype="multipart/form-data">
    <section class="mypage-top jb w1 ac">
      <div class="fc ac">
        <?php if ($isMypage) { ?> 
          <?php if ($user->img) { ?>
            <input type="file" name="img" id="img" hidden>
            <label for="img" class="ov mypage-profile rel">
              <img src="" alt="profile" class="abs w1 h1" />
              <p>Click here to upload profile</p>
            </label>
          <?php } else { ?>
            <input type="file" name="img" id="img" hidden>
            <label for="img" class="mypage-profile fc fxc g2">
              <h1>NP</h1>
              <p>Click here to upload profile</p>
            </label>
          <?php } ?>
        <?php } else { ?>
          <?php if ($user->img) { ?>
            <label for="img" class="ov mypage-profile rel">
              <img src="" alt="profile" class="abs w1 h1" />
            </label>
          <?php } else { ?>
            <label for="img" class="mypage-profile fc fxc g2">
              <h1>NP</h1>
            </label>
          <?php } ?>
        <?php } ?>
        <h1 class="mypage-user-id"><?= $user->id; ?></h1>
        <?php if ($isMypage) { ?>
          <?php if ($user->description) { ?>
            <input type="text" name="description" id="description" value="<?= $user->description; ?>" />
          <?php } else { ?>
            <input type="text" name="description" id="description" placeholder="Description" autofocus />
          <?php } ?>
        <?php } else { ?>
          <?php if ($user->description) { ?>
            <input type="text" class="description-not-mypage" name="description" id="description" value="<?= $user->description; ?>" readonly />
          <?php } else { ?>
            <input type="text" class="description-not-mypage" name="description" id="description" value="No Description" readonly />
          <?php } ?>
        <?php } ?>
      </div>
      <div class="user-detail fc jb jc">
        <div class="fx f1 ac" id="my-joined-date">
          <p><b>Joined Fakebook</b> on <?= $user->join_date; ?></p>
        </div>
        <div class="jb fx f1 ac" id="my-posts">
          <?php if ($boardNum === 1) { ?>
            <b>Number of post posted</b>
          <?php } else { ?>
            <b>Number of posts posted</b>
          <?php } ?>
          <p><?= $boardNum; ?></p>
        </div>
        <div class="jb fx f1 ac" id="my-likes">
          <b>Number of likes <?= $id ?> got</b>
          <p><?= $likes; ?></p>
        </div>
        <?php if ($isMypage) { ?>
          <div class="jb fx f1 ac" id="my-gender">
            <b>Gender</b>
            <select name="gender" id="gender">
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="jb fx f1 ac" id="my-pw">
            <b>Password</b>
            <input type="text" name="pw" id="pw-change" value="<?= $user->pw; ?>">
          </div>
        <?php } else { ?>
          <div class="jb fx f1 ac" id="my-gender">
            <b>Gender</b>
            <p><?= $user->gender; ?></p>
          </div>
        <?php } ?>
      </div>
    </section>
    <?php if ($isMypage) { ?>
        <button class="btn hov edit-profile gradient">✏️ Edit Profile</button>
      <?php } ?>
    <section class="user-board-list mypage-bottom">
      <?php foreach ($board as $b) {  ?>
        <?php $b->likes = DB::fetchAll("select count(*) as count from likes where board_idx = $b->idx"); ?>
        <?php $b->comments = DB::fetchAll("select count(*) as count from comment where board_idx = $b->idx"); ?>
        <div class="rel">
          <a href="/board/<?= $b->idx; ?>" class="board-item-container">
            <article class="w1 board-item jb ac">
              <h2 class="board-title"><?= $b->title ?></h2>
              <div class="fx ac">
                <p class="time"><?= $b->time ?></p>
                <p class="likes"><b>❤️</b>&nbsp;<?= $b->likes[0]->count; ?></p>
                <p class="comments"><b>💬</b>&nbsp;<?= $b->comments[0]->count; ?></p>
              </div>
            </article>
          </a>
          <a href="<?= $b->user_id; ?>" class="board-user-info abs fc ac">
            <?php if ($b->img) { ?>
              <img src="<?= $b->img ?>" alt="profile" class="board-user-profile" />
            <?php } else { ?>
              <div class="board-user-profile fb">NP</div>
            <?php } ?>
            <p class="user-id"><?= $b->user_id ?></p>
          </a>
        </div>
      <?php } ?>
    </section>
  </form>
</main>

<script>
  function generateRandomHexColor() { return `#${((r, g, b) => (r = Math.floor(Math.random() * 156) + 100, g = Math.floor(Math.random() * 156) + 100, b = Math.floor(Math.random() * 156) + 100, `${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`))(0, 0, 0)}`; }
  $('.mypage-profile').style.backgroundColor = generateRandomHexColor();
  $$('div.board-user-profile').forEach(({ style }) => style.backgroundColor = generateRandomHexColor());
</script>