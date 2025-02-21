<main class="con posting">
  <h1 class="section-title capz">Post</h1>
  <section>
    <form action="/addBoard" method="post" class="fc post-form" enctype="multipart/form-data">
      <input type="text" name="title" id="board-title" placeholder="Title" autofocus required>
      <input type="file" name="img" id="img" hidden />
      <label class="w1 fxc ov cp post-insert-img" for="img"><i>Click here to add an image (optional)</i></label>
      <br>
      <textarea name="content" id="board-content" placeholder="content" required></textarea>
      <button class="btn abs board-post">Post</button>
    </form>
  </section>
</main>

<script>
  $('#img').oninput = (e) => imgFileLoader(e, '.post-insert-img');
</script>