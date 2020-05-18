// events on DOM load
document.addEventListener('DOMContentLoaded', async e => {
  const { data: funcs } = await axios.get('/api/func');
  const { data: incidents } = await axios.get('/api/incident');

  // populate primary select and secondary select
  initPriFuncs(funcs);
  initIncidents(incidents);

  // on clear button, reset resource page
  const resetBtn = document.querySelector('#reset-res-search');
  if (resetBtn)
    resetBtn.addEventListener('click', e => {
      let pri_sel = document.querySelector('#primary-function');
      let inc_opts = document.querySelector('#incident');

      document.querySelector('#keyword').value = '';
      document.querySelector('#keyword').defaultValue = '';
      document.querySelector('#distance').value = '';
      document.querySelector('#distance').defaultValue = '';
      pri_sel.selectedIndex = 0;
      inc_opts.selectedIndex = 0;
      document.querySelector('#res-search-results').innerHTML = '';
    });
});

function initPriFuncs(list) {
  let pri_sel = document.querySelector('#primary-function');

  // add options to <select>
  pri_sel.add(document.createElement('option'));
  add_options(pri_sel, list, 'id', 'name');

  // reselect functions if there is old value
  let prev_pri_id = pri_sel.dataset.prev_id;
  if (prev_pri_id)
    document.querySelector('#primary-function').selectedIndex = prev_pri_id;
}

function initIncidents(list) {
  let incidents = document.querySelector('#incident');

  // modify list with custom name value
  for (let i = 0; i < list.length; ++i)
    list[i]['name'] = list[i]['id'] + ': ' + list[i]['description'];

  // add options to <select>
  incidents.add(document.createElement('option'));
  add_options(incidents, list, 'id', 'name');

  // reselect functions if there is old value
  let prev_inc_id = incident.dataset.prev_id;
  if (prev_inc_id)
    document.querySelector('#incident').selectedIndex = prev_inc_id;
}
