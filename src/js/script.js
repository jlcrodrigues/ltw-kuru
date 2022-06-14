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

const redirect_login = document.querySelectorAll(".login-redirect")

for (const r of redirect_login) {
  r.addEventListener("click", function () {
      location.href = "../pages/login.php";
    }
  )
}

function createMessage(text, type) {
  let message = document.createElement('section')
  message.className = 'message ' + type;
  let p = document.createElement('p')
  p.textContent = text
  message.appendChild(p)
  let button = document.createElement('button')
  button.className = "close-message"
  button.setAttribute('onclick', 'closeMessage(event)')
  let i = document.createElement('i');
  i.className = 'material-symbols-rounded';
  i.textContent = 'close';
  button.appendChild(i)
  message.appendChild(button)
  return message
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

function sliderScrollLeft(event) {
  slider = event.currentTarget.parentNode.children[0]
  slider.scrollTo({
    top: 0,
    left: (slider.scrollLeft -= scroll_offset),
    behavior: "smooth"
  })
  if (slider.scrollLeft < 0) {
    slider.scrollLeft = 0;
  }
}

function sliderScrollRight(event) {
  slider = event.currentTarget.parentNode.children[0]
  if (slider.scrollLeft <= slider.scrollWidth - slider.clientWidth) {
    slider.scrollTo({
      top: 0,
      left: (slider.scrollLeft += scroll_offset),
      behavior: "smooth"
    })
  }
  else {
    slider.scrollLeft = 0
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

const open_add_buttons = document.querySelectorAll(".open-add-card")

for (const button of open_add_buttons) {
  if (button.nextElementSibling) {
    button.onclick = function() {
      button.nextElementSibling.style.display = "block"
    }
  }
}

const close_add_buttons = document.querySelectorAll(".close-add")

for (const button of close_add_buttons) {
  button.onclick = function() {
    button.parentElement.parentElement.style.display = "none"
  }
}

window.onclick = function(event) {
  if (event.target.className == "add-card"
      || event.target.className == "add-review-card") {
    event.target.style.display = "none";
  }
}

const cart_buttons = document.querySelectorAll(".add-to-cart")

if (cart_buttons) {
  for (const button of cart_buttons) {
    const id = button.nextElementSibling.value;
    button.addEventListener("click", function () {
      const quantity = button.previousElementSibling.previousElementSibling.value;
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idDish=" + id + "&action=add&quantity=" + quantity
      })
      .then(button.parentElement.parentElement.style.display = "none")
      document.querySelector('#messages')
        .appendChild(createMessage('Added to cart!', 'success'))
    })
  }
}

const review_buttons = document.querySelectorAll(".add-review")

if (review_buttons) {
  for (const button of review_buttons) {
    const id = button.nextElementSibling.value;
    button.addEventListener("click", function () {
      const text = button.previousElementSibling.value;
      const rating = button.previousElementSibling.previousElementSibling.value;
      const restaurant = button.nextElementSibling.value;
      console.log(text);
      fetch("../api/api_review.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idRestaurant=" + restaurant + "&rating=" + rating + "&text=" + text
      })
      .then(button.parentElement.parentElement.style.display = "none")
      document.querySelector('#messages')
        .appendChild(createMessage('Added to cart!', 'success'))
    })
  }
}

const remove_order_buttons = document.querySelectorAll(".remove-order")

if (remove_order_buttons) {
  for (const button of remove_order_buttons) {
    const id = button.parentElement.children[0].value;
    button.addEventListener("click", function () {
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idOrder=" + id + "&action=remove-order"
      })
      button.parentElement.style["animation"] = "fadeOut 0.5s"
      setTimeout(function () {
        button.parentElement.remove()
      }, 500);
    })
  }
}

const submit_order_buttons = document.querySelectorAll(".submit-order")

if (submit_order_buttons) {
  for (const button of submit_order_buttons) {
    const id = button.parentElement.parentElement.children[0].value;
    button.addEventListener("click", function () {
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idOrder=" + id + "&action=submit-order"
      })
      button.parentElement.parentElement.style["animation"] = "fadeOut 0.5s"
      setTimeout(function () {
        button.parentElement.parentElement.remove()
      }, 500);
    })
  }
}

const remove_dish_buttons = document.querySelectorAll(".remove-dish")

if (remove_dish_buttons) {
  for (const button of remove_dish_buttons) {
    const idDish = button.parentElement.children[0].value;
    const idOrder = button.parentElement.parentElement.children[0].value;
    const price = parseFloat(button.parentElement.children[3].innerHTML)
     * parseFloat(button.parentElement.children[4].innerHTML.slice(0, -1));
    button.addEventListener("click", function () {
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idOrder=" + idOrder + "&idDish=" + idDish + "&action=remove-dish"
      })
      button.parentElement.style["animation"] = "fadeOut 0.5s"
      
      total = button.parentElement.parentElement.lastElementChild.children[1]
      new_total = parseFloat(total.innerHTML.slice(0, -1)) - price
      if (new_total < 0) new_total = 0
      total.innerHTML = new_total.toFixed(2) + '€'
      setTimeout(function () {
        button.parentElement.remove()
      }, 500);
    })
  }
}

const repeat_order_buttons = document.querySelectorAll(".repeat-order")

if (repeat_order_buttons) {
  for (const button of repeat_order_buttons) {
    const id = button.parentElement.children[0].value;
    button.addEventListener("click", function () {
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idOrder=" + id + "&action=repeat-order"
      })
      document.querySelector('#messages')
        .appendChild(createMessage('Added to cart!', 'success'))
    })
  }
}

const deliver_order_buttons = document.querySelectorAll(".deliver-order")

if (deliver_order_buttons) {
  for (const button of deliver_order_buttons) {
    const id = button.parentElement.children[0].value;
    button.addEventListener("click", function () {
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idOrder=" + id + "&action=deliver-order"
      })
      button.parentElement.style["animation"] = "fadeOut 0.5s"
      setTimeout(function () {
        button.parentElement.remove()
      }, 500);
    })
  }
}
