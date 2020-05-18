// events on DOM load
document.addEventListener('DOMContentLoaded', async e => {
  const { data: categories } = await axios.get('/api/category');

  initCategories(categories);

  // on clear button, reset incident page
  const resetBtn = document.querySelector('#reset-inc-create');
  if (resetBtn)
    resetBtn.addEventListener('click', e => {
      let incidentId = document.querySelector('#incident-id');
      let cats = document.querySelector('#category');
      let date = document.querySelector('#date');
      let desc = document.querySelector('#description');
      let saveBtn = document.querySelector('#save');

      // enable all interaction elements
      let enableList = [cats, date, desc, saveBtn];
      enableList.forEach(e => (e.disabled = false));

      let valueList = [date, desc];
      valueList.forEach(v => {
        v.value = '';
        v.defaultValue = '';
      });

      // reset date to today
      setTodayDate(date);

      incidentId.innerHTML = '';
      cats.selectedIndex = 0;
      saveBtn.classList.remove('d-none');
    });
});

// initialize categories selection
// @param list - category list
function initCategories(list) {
  let cats = document.querySelector('#category');
  let date = document.querySelector('#date');

  // add options to <select>
  add_options(cats, list, 'id', 'name');

  // reselect category if there is old value
  let prev_id = cats.dataset.prev_id;
  if (prev_id) document.querySelector('#category').selectedIndex = prev_id - 1;

  // set today's date
  if (!date.value) setTodayDate(date);
}

// set date element to today's date
// @param date - input element of type date
function setTodayDate(date) {
  let today = new Date();
  date.value = `${today.getFullYear()}-${today.getMonth()}-${today.getDate()}`;
}
