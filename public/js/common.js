// add all options to select element
// @param srcSelect - source select element
// @param options - array of option
// @param value_key - key for value field
// @param text_key - key for text field
function add_options(srcSelect, options, value_key, text_key) {
  for (let i = 0; i < options.length; ++i) {
    let option = document.createElement('option');
    option.text = options[i][text_key];
    option.value = options[i][value_key];
    srcSelect.add(option);
  }
  srcSelect.selectedIndex = 0;
}
