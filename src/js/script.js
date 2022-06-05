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

const searchRestaurant = document.querySelector('#search-restaurant');
const isIndex = window.location.toString().includes('/pages/index.php');
if (searchRestaurant && !isIndex) {
  if (searchRestaurant.value) getRestaurants.call(searchRestaurant);
  searchRestaurant.addEventListener('input',getRestaurants);
}

async function getRestaurants() {
    const response = await fetch('../api/api_restaurants.php?search=' + this.value);
    const restaurants = await response.json();

    const section = document.querySelector('.restaurants-search');
    section.innerHTML = '';

    if(restaurants.length===0){
      const h = document.createElement('h3');
      h.classList.add("no-restaurants");
      h.textContent = "No matches found";
      section.appendChild(h);
    }

    for (const restaurant of restaurants) {
      const link = document.createElement('a');
      link.href = "../pages/restaurant.php?id=" + restaurant.id;
      link.classList.add("restaurant-mini");
      const img = document.createElement('img');
      img.src = "https://picsum.photos/id/101/200/200";
      img.alt = "";
      const div = document.createElement('div');
      div.classList.add("mini-text");
      const h3 = document.createElement('h3');
      h3.textContent = restaurant.name;
      const h4 = document.createElement('h4');
      h4.textContent = restaurant.address;
      div.appendChild(h3);
      div.appendChild(h4);
      link.appendChild(img);
      link.appendChild(div);
      section.appendChild(link);
    }
}
function closeMessage(event) {
  let message = event.currentTarget.parentNode
  message.style["animation"] = "fadeOut 0.5s"
  setTimeout(function () {
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

const favorite_buttons = document.querySelectorAll(".favorite-button")

if (favorite_buttons) {
  for (const button of favorite_buttons) {
    let body;
    const input1 = button.nextElementSibling;
    const input2 = input1.nextElementSibling;
    if (input2.nextElementSibling == null) {
      body = "idRestaurant=" + input1.value + "&type=restaurant"
    } else {
      body = "id=" + input1.value + "&idRestaurant=" + input2.value + "&type=dish"
    }
    button.addEventListener("click", function () {
      fetch("../api/api_favorites.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: body
      })
      .then((response) => response.text())
      .then((res) => button.className = "favorite-button " + res)
    })
  }
}
