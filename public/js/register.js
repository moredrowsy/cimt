// events on DOM load
document.addEventListener('DOMContentLoaded', async e => {
  // add roles
  const { data: roles } = await axios.get('/api/role');
  initRoles(roles);

  // telephone validation of format ###-###-####
  const telField = document.querySelector('#tel');
  if (telField)
    telField.addEventListener('input', e => {
      let val = (e.srcElement.value = e.srcElement.value.replace(
        /[^0-9]/g,
        ''
      ));

      switch (e.srcElement.value.length) {
        case 4:
          e.srcElement.value = val.substr(0, 3) + '-' + val.substr(3);
          break;
        case 5:
        case 6:
          e.srcElement.value = val.substr(0, 3) + '-' + val.substr(3);
          break;
        case 7:
        case 8:
        case 9:
        case 10:
        case 11:
        case 12:
          e.srcElement.value =
            val.substr(0, 3) + '-' + val.substr(3, 3) + '-' + val.substr(6);
          break;
        default:
      }
    });
});

// initialize categories selection
// @param list - category list
function initRoles(list) {
  let no_admin_list = list.filter(v => v['id'] !== 1);
  let role = document.querySelector('#role');
  add_options(role, no_admin_list, 'id', 'name');
}
