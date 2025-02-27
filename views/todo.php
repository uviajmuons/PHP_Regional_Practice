<main class="con fc">
  <section>
    <h1 class="section-title post-title">Todo</h1>
    <form method="post" action="/editTodo" class="w1 jb fc todo-detail rel">
      <input type="hidden" name="idx" value="<?= $fetch->idx; ?>">
      <input type="text" name="title" id="title" value="<?= $fetch->title; ?>" placeholder="To-do title" required>
      <textarea name="content" id="content" class="w1" placeholder="add detail(optional)"><?= $fetch->content; ?></textarea>
      <div class="w1 jb ac">
        <input type="date" name="begindate" id="begindate" value="<?= $fetch->begindate; ?>" required>
        <p class="fb">to</p>
        <input type="date" name="enddate" id="enddate" value="<?= $fetch->enddate; ?>" required>
      </div>
      <select name="status" id="status">
        <option value="unfinished" <?= $fetch->status == 'unfinished' ? 'selected' : ''; ?>>unfinished</option>
        <option value="finished" <?= $fetch->status == 'finished' ? 'selected' : ''; ?>>finished</option>
      </select>
      <button class="abs cp hov gradient">Edit</button>
    </form>
  </section>
</main>