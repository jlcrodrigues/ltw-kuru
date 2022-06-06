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

const open_add_buttons = document.querySelectorAll(".open-add-card")

for (const button of open_add_buttons) {
  button.onclick = function() {
    button.nextElementSibling.style.display = "block"
  }
}

const close_add_buttons = document.querySelectorAll(".close-add")

for (const button of close_add_buttons) {
  button.onclick = function() {
    button.parentElement.parentElement.style.display = "none"
  }
}

window.onclick = function(event) {
  if (event.target.className == "add-card") {
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
    button.addEventListener("click", function () {
      fetch("../api/api_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: "idOrder=" + idOrder + "&idDish=" + idDish + "&action=remove-dish"
      })
      button.parentElement.style["animation"] = "fadeOut 0.5s"
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
    })
  }
}
