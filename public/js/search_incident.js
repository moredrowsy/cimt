// events on DOM load
document.addEventListener('DOMContentLoaded', async e => {
  const { data: categories } = await axios.get('/api/category');

  initCategories(categories);

  // on clear button, reset resource page
  const resetBtn = document.querySelector('#reset-inc-search');
  if (resetBtn)
    resetBtn.addEventListener('click', e => {
      let cats = document.querySelector('#category');
      let date = document.querySelector('#date');

      document.querySelector('#keyword').value = '';
      document.querySelector('#keyword').defaultValue = '';
      cats.selectedIndex = 0;
      date.defaultValue = '';
      date.value = '';
      document.querySelector('#inc-search-results').innerHTML = '';
    });
});

// initialize categories selection
// @param list - category list
function initCategories(list) {
  let cats = document.querySelector('#category');

  // add options to <select>
  cats.add(document.createElement('option'));
  add_options(cats, list, 'id', 'name');

  // reselect functions if there is old value
  let prev_cat_id = cats.dataset.prev_id;
  if (prev_cat_id)
    document.querySelector('#category').selectedIndex = prev_cat_id;
}
