// events on DOM load
document.addEventListener('DOMContentLoaded', async e => {
  const { data: funcs } = await axios.get('/api/func');
  const { data: unitCosts } = await axios.get('/api/unit-cost');

  initPSFunctions(funcs);
  initUnitCosts(unitCosts);

  // generate new res when primary function selection is changed
  const priFuncSel = document.querySelector('#primary-function');
  if (priFuncSel) priFuncSel.addEventListener('change', e => secFuncOnChange());

  // on clear button, reset resource page
  const resetBtn = document.querySelector('#reset-res-create');
  if (resetBtn)
    resetBtn.addEventListener('click', e => {
      let resId = document.querySelector('#resource-id');
      let resName = document.querySelector('#resource-name');
      let pri_sel = document.querySelector('#primary-function');
      let sec_sel = document.querySelector('#secondary-function');
      let desc = document.querySelector('#description');
      let capInput = document.querySelector('#capabilities-input');
      let caps = document.querySelector('#capabilities');
      let capAddBtn = document.querySelector('#capabilities-add');
      let capRemoveBtn = document.querySelector('#capabilities-remove');
      let distance = document.querySelector('#distance');
      let cost = document.querySelector('#cost');
      let unitCost = document.querySelector('#unit-cost');
      let saveBtn = document.querySelector('#save');

      // enable all interaction elements
      let enableList = [
        resName,
        pri_sel,
        sec_sel,
        desc,
        capInput,
        caps,
        capAddBtn,
        capRemoveBtn,
        distance,
        cost,
        unitCost,
        saveBtn
      ];
      enableList.forEach(e => (e.disabled = false));

      // reset input values
      let valueList = [resName, capInput, desc, distance, cost];
      valueList.forEach(v => {
        v.value = '';
        v.defaultValue = '';
      });

      // reset primary and secondary functions
      pri_sel.selectedIndex = 0;
      sec_sel.selectedIndex = 0;
      secFuncOnChange();

      resId.innerHTML = '';
      caps.length = 0;
      unitCost.selectedIndex = 0;
      saveBtn.classList.remove('d-none');
    });

  // capability input key enter event
  const capInput = document.querySelector('#capabilities-input');
  if (capInput)
    capInput.addEventListener('keydown', e => {
      if (e.keyCode === 13) {
        e.preventDefault();
        addCap();
        return false;
      }
    });

  // capabilities option key delete event
  const caps = document.querySelector('#capabilities');
  if (caps)
    caps.addEventListener('keydown', e => {
      if (e.keyCode === 46) {
        e.preventDefault();
        removeCap();
        return false;
      }
    });

  // add capability
  const addCapBtn = document.querySelector('#capabilities-add');
  if (addCapBtn) addCapBtn.addEventListener('click', e => addCap());

  // remove capability
  const removeCapBtn = document.querySelector('#capabilities-remove');
  if (removeCapBtn) removeCapBtn.addEventListener('click', e => removeCap());

  // select all capabilities option before submit
  const resourceForm = document.querySelector('#res-create-form');
  if (resourceForm)
    resourceForm.addEventListener('submit', e => {
      let caps = document.querySelector('#capabilities');
      for (let i = 0; i < caps.length; ++i) caps[i].selected = true;
    });
});

// initialize primary and secondary functions selection
// @param list - functions list
function initPSFunctions(list) {
  let pri_sel = document.querySelector('#primary-function');
  let sec_sel = document.querySelector('#secondary-function');

  // add options to <select>
  add_options(pri_sel, list, 'id', 'name');
  add_options(sec_sel, list, 'id', 'name');

  // add blank option to secondary
  let option = document.createElement('option');
  option.text = '';
  sec_sel.add(option, 0);
  sec_sel.selectedIndex = 0;

  // reselect functions if there is old value
  let prev_pri_id = pri_sel.dataset.prev_id;
  if (prev_pri_id)
    document.querySelector('#primary-function').selectedIndex = prev_pri_id - 1;

  // reselect secondary functions if there is old value
  let prev_sec_id = sec_sel.dataset.prev_id;
  if (prev_sec_id)
    document.querySelector('#secondary-function').selectedIndex = prev_sec_id;

  // hide/disable secondary option from primary's selectedIndex
  secFuncOnChange();
}

// initialize unit costs selection
// @param list - unit costs list
function initUnitCosts(list) {
  let unit_sel = document.querySelector('#unit-cost');
  add_options(unit_sel, list, 'id', 'name');

  // reselect unit-cost if there is old value
  let prev_id = unit_sel.dataset.prev_id;
  if (prev_id) document.querySelector('#unit-cost').selectedIndex = prev_id - 1;
}

// reconfigure secondary selection exclusion from primary selection
function secFuncOnChange() {
  let pri_sel = document.querySelector('#primary-function');
  let sec_sel = document.querySelector('#secondary-function');
  let priValue = pri_sel.value;
  let secValue = sec_sel.value;

  // if primary select oldIndex doesn't exist, set to current selectedIndex
  if (!pri_sel.getAttribute('oldIndex'))
    pri_sel.setAttribute('oldIndex', pri_sel.selectedIndex);

  // enable secondary by oldIndex
  let oldIndex = Number(pri_sel.getAttribute('oldIndex'));
  sec_sel[oldIndex + 1].disabled = false;
  sec_sel[oldIndex + 1].classList.remove('d-none');

  // disable and hide corresponding priValue in secondary
  sec_sel[priValue].disabled = true;
  sec_sel[priValue].classList.add('d-none');

  // assign selecteIndex to 0 if primary matches secondary
  if (priValue == secValue) sec_sel.selectedIndex = 0;

  // store oldIndex for next event change
  pri_sel.setAttribute('oldIndex', pri_sel.selectedIndex);
}

// add capabilities from input to select option
function addCap() {
  let duplicate = false;
  let cap_input = document.querySelector('#capabilities-input');
  let caps = document.querySelector('#capabilities');
  let option = document.createElement('option');

  if (cap_input.value) {
    // check for duplicates
    for (let i = 0; i < caps.length; ++i) {
      if (caps[i].value == cap_input.value) {
        duplicate = true;
        break;
      }
    }

    if (!duplicate) {
      option.text = cap_input.value;
      option.selected = true;

      caps.add(option);
      caps.selectedIndex = caps.length - 1;
      cap_input.value = '';
    }
  }
  cap_input.focus();
}

// add capabilities from input to select option
function removeCap() {
  let cap_input = document.querySelector('#capabilities-input');
  let caps = document.querySelector('#capabilities');

  if (caps.selectedIndex === -1) caps.selectedIndex = caps.length - 1;

  cap_input.value = caps.value;
  caps.remove(caps.selectedIndex);
  caps.selectedIndex = caps.length - 1;

  cap_input.focus();
  cap_input.select();
}
