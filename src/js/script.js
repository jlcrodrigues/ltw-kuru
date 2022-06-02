const scroll_offset = 800;

function openProfileTab(evt, tab_id) {
  const tabs = document.getElementsByClassName("profile-section");
  for (const tab of tabs) {
    tab.style.display = "none";
  }

  const buttons = document.querySelector('#profile-tabs').children;
  for (const button of buttons) {
    button.className = button.className.replace(" active", "");
  }

  document.getElementById(tab_id).style.display = "block";
  evt.currentTarget.className += " active";
}

const profile_button = document.getElementById("profile-button");
if (profile_button) profile_button.click()

function openRestaurantTab(evt, tab_id) {
  const tabs = document.getElementsByClassName("restaurant-tab");
  for (const tab of tabs) {
    tab.style.display = "none";
  }

  const buttons = document.querySelector('#tabs').children;
  for (const button of buttons) {
    button.className = button.className.replace(" active", "");
  }

  document.getElementById(tab_id).style.display = "block";
  evt.currentTarget.className += " active";
}

const menu_button = document.getElementById("menu-button");
if (menu_button) menu_button.click()

function openFavoritesTab(evt, tab_id) {
  const tabs = document.getElementsByClassName("favorites-section");
  for (const tab of tabs) {
    tab.style.display = "none";
  }

  const buttons = document.querySelector('#favorites-tabs').children;
  for (const button of buttons) {
    button.className = button.className.replace(" active", "");
  }

  document.getElementById(tab_id).style.display = "block";
  evt.currentTarget.className += " active";
}

const favorite_button = document.getElementById("favorite-button-tab");
if (favorite_button) favorite_button.click()

function closeMessage(event) {
  console.log("df2")
  let message = event.currentTarget.parentNode
  message.style["animation"] = "fadeOut 0.5s"
  setTimeout(function() {
    message.remove()
  }, 500);
}

let scroll_amount = 0;

function sliderScrollLeft(event) {
  slider = event.currentTarget.parentNode.children[0]
  slider.scrollTo({
    top: 0,
    left: (scroll_amount -= scroll_offset),
    behavior: "smooth"
  })
  if (scroll_amount < 0) {
    scroll_amount = 0;
  }
}

function sliderScrollRight(event) {
  slider = event.currentTarget.parentNode.children[0]
  if (scroll_amount <= slider.scrollWidth - slider.clientWidth) {
    slider.scrollTo({
      top: 0,
      left: (scroll_amount += scroll_offset),
      behavior: "smooth"
    })
  }
  else {
    scroll_amount = 0
  }
}
