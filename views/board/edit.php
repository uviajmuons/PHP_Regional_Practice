<?= $fetch->content; ?>
<main class="con fc">
  <h1 class="section-title post-title upc">edit post</h1>
  <section>
    <form action="/editBoard" method="post" class="fc post-form" enctype="multipart/form-data">
      <input type="text" name="title" id="board-title" value="<?= $fetch->title; ?>">
      <input type="hidden" name="idx" id="idx" value="<?= $fetch->idx; ?>">
      <input type="file" name="img" id="img" hidden />
        <?php if ($fetch->img) { ?>
          <label class="w1 fxc ov cp post-insert-img" for="img">
            <img src="/<?= $fetch->img; ?>" alt="img" class="w1 h1">
          </label>
          <?php } else { ?>
          <label class="w1 fxc ov cp post-insert-img" for="img"><i>Click here to add an image (optional)</i></label>
        <?php } ?>
      <br>
      <textarea name="content" id="board-content" required><?= $fetch->content; ?></textarea>
      <?php if ($fetch->img) { ?>
        <button class="btn abs board-post" name="action" value="edit" id="edit">Edit</button>
      <?php } else { ?>
        <button class="btn abs board-post" name="action" value="upload" id="upload">Edit</button>
      <?php } ?>
    </form>
  </section>
</main>

<script>
  $('#img').oninput = (e) => imgFileLoader(e, '.post-insert-img');
</script>