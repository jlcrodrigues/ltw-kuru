const button = document.getElementById("profile-button");
if (button) button.click()

function openProfileTab(evt, tab_id) {
  const tabs = document.getElementsByClassName("profile-section");
  for (const tab of tabs) {
    tab.style.display = "none";
  }

  const buttons = document.querySelector('#tabs').children;
  for (const button of buttons) {
    console.log(button.className);
    button.className = button.className.replace(" active", "");
  }

  document.getElementById(tab_id).style.display = "block";
  evt.currentTarget.className += " active";
}