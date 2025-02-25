<?php
  $id = ss()->id;
?>
<div class="todo-modal fix ts rel">
  <form action="/addTodo" method="post" class="fc h1 todo-form">
    <input type="text" name="todo" id="todo" placeholder="Add your to-do" required />
    <input type="date" name="begindate" id="begindate" required>
    <input type="hidden" name="color" id="color">
    <input type="date" name="enddate" id="enddate" required>
    <textarea name="content" id="content" placeholder="add detail(optional)"></textarea>
    <div class="fx todo-form-ctrl g1 abs">
      <button class="todo-modal-ctrl fxc cp hov capz" id="add">Add</button>
      <button class="todo-modal-ctrl fxc cp hov capz" id="close">close</button>
    </div>
  </form>
</div>
<main class="con fc">
  <h1 class="section-title post-title">Calendar</h1>
  <section class="calendar fc ac">
    <div class="calendar-head fx ac">
      <div class="month-ctrl round btn hov" id="last-month">&lt;</div>
      <h1 class="calendar-month fc ac"></h1>
      <div class="month-ctrl round btn hov" id="next-month">&gt;</div>
    </div>
    <div class="calendar-content w1"></div>
    <div class="add-todo gradient hov fxc cp abs">Add To-do</div>
  </section>
</main>

<script>
  function generateRandomHexColor() { return `${((r, g, b) => (r = Math.floor(Math.random() * 116) + 140, g = Math.floor(Math.random() * 116) + 140, b = Math.floor(Math.random() * 116) + 140, `${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`))(0, 0, 0)}`; }
  $('#color').value = generateRandomHexColor();
  console.log(generateRandomHexColor());
  const $data = <?= json_encode(DB::fetchAll("select * from todo where user_id = '$id' order by begindate")); ?>;
  console.log($data);
  const today = new Date();
  const baseDate = new Date(today.getFullYear(), today.getMonth(), 1);
  const dateCompare = (strDate, date) => {
    const [y, m, d] = strDate.split('-').map(Number);
    return new Date(y, m - 1, d).toString() === new Date(date.getFullYear(),date.getMonth(),date.getDate()).toString();
  }
  const weekdays = `
    <div class="fx w1 weekdays">
      <div class="f1 upc fb fxc sun">sun</div>
      <div class="f1 upc fb fxc">mon</div>
      <div class="f1 upc fb fxc">tue</div>
      <div class="f1 upc fb fxc">wed</div>
      <div class="f1 upc fb fxc">thu</div>
      <div class="f1 upc fb fxc">fri</div>
      <div class="f1 upc fb fxc sat">sat</div>
    </div>
  `;
  function render() {
    const firstDayThisMonth = new Date(baseDate.getFullYear(), baseDate.getMonth(), 1);
    const lastDayThisMonth = new Date(baseDate.getFullYear(), baseDate.getMonth() + 1, 0);
    $('.calendar-month').innerHTML = firstDayThisMonth.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    $('.calendar-content').innerHTML = `
      ${weekdays}
      <div class="grid calendar-grid">
        ${`<div class="day"></div>`.repeat(firstDayThisMonth.getDay())}
        ${[...Array(lastDayThisMonth.getDate())].fill(0).reduce((html, _, i) => {
          const day = i + 1;
          const thisDate = new Date(baseDate.getFullYear(), baseDate.getMonth(), day);
          const todo = $data.filter(({ begindate, enddate }) => {
            const beginDate = new Date(begindate);
            beginDate.setDate(beginDate.getDate() - 1);
            const endDate = new Date(enddate);
            return thisDate >= beginDate && thisDate <= endDate;
          });

          return html + `<div class="d ac fb fc">
            <p style="margin-bottom: .5rem;">${day}</p>
            ${todo.reduce((html, {title, content, color}) => html + `<div class="fc w1 ac" style="color: #000; padding-top: .5rem; background-color: #${color};">
              <p>${title}</p>
              <!-- <small>${content}</small> -->
            </div>`, '')}          
          </div>`;
        }, '')}
      </div>
    `;
  }
  render();
  $('#last-month').onclick = () => { baseDate.setMonth(baseDate.getMonth() - 1); render(); }
  $('#next-month').onclick = () => { baseDate.setMonth(baseDate.getMonth() + 1); render(); }
  const endDate = new Date();
  endDate.setDate(endDate.getDate() + 7);

  function modalHandler() { $('.todo-modal').classList.toggle('on'); }
  $('.add-todo').onclick = () => modalHandler();
  $('#close').onclick = () => modalHandler();
  $('#begindate').value = new Date().toISOString().slice(0, 10);
  $('#enddate').value = endDate.toISOString().slice(0, 10);
</script>