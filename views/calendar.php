  <main class="con fc">
    <h1 class="section-title post-title">Calendar</h1>
    <section class="calendar fc ac">
      <div class="calendar-head fx ac">
        <div class="month-ctrl round btn hov" id="last-month">&lt;</div>
        <h1 class="calendar-month fc ac"></h1>
        <div class="month-ctrl round btn hov" id="next-month">&gt;</div>
      </div>
      <div class="calendar-content w1"></div>
    </section>
  </main>
  <script>
    const $data = <?= json_encode(DB::fetchAll("select * from todo")); ?>;
    console.log($data);
    const today = new Date();
    const baseDate = new Date(today.getFullYear(), today.getMonth(), 1);
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
      console.log(firstDayThisMonth.getDay());
      $('.calendar-month').innerHTML = firstDayThisMonth.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
      $('.calendar-content').innerHTML = `
        ${weekdays}
        <div class="grid calendar-grid">
          ${`<div class="day"></div>`.repeat(firstDayThisMonth.getDay())}
          ${[...Array(lastDayThisMonth.getDate())].fill(0).reduce((html, _, i) => {
            const day = i + 1;
            const thisDate = new Date(baseDate.getFullYear(), baseDate.getMonth(), day);
            const todo = $data.filter(({ date }) => dateCompare(date, thisDate));
            return html + `<div class="d ac">
              ${day}
              ${todo.reduce((html, {title, type}) => html + `<div class="fc" style="color: #000; align-items: end; padding-top: .5rem">
                <p>${title}</p>
                <small>${content}</small>
              </div>`, '')}          
            </div>`;
          }, '')}
        </div>
      `;
    }
    render();

    $('#last-month').onclick = () => { baseDate.setMonth(baseDate.getMonth() - 1); render(); }
    $('#next-month').onclick = () => { baseDate.setMonth(baseDate.getMonth() + 1); render(); }
  </script>