'use strict';

/**
 * navbar variables
 */

const navOpenBtn = document.querySelector("[data-menu-open-btn]");
const navCloseBtn = document.querySelector("[data-menu-close-btn]");
const navbar = document.querySelector("[data-navbar]");
const overlay = document.querySelector("[data-overlay]");

const navElemArr = [navOpenBtn, navCloseBtn, overlay];

for (let i = 0; i < navElemArr.length; i++) {

  navElemArr[i].addEventListener("click", function () {

    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
    document.body.classList.toggle("active");

  });

}
<<<<<<< HEAD



/**
 * header sticky
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {

  window.scrollY >= 10 ? header.classList.add("active") : header.classList.remove("active");

});



/**
 * go top
 */

const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {

  window.scrollY >= 500 ? goTopBtn.classList.add("active") : goTopBtn.classList.remove("active");

});

/**
 * script.js
*/

$(document).ready(function() {
  $('.clear-btn').on('click', function() {
      $.ajax({
          type: 'POST',
          url: '../models/userHistory.php',
          data: { clearHistory: true },
          success: function() {
              // clear the list view from the page
              $('.clear-list').empty();
          }
      });
  });
});
=======
>>>>>>> 8049074 (refactor: Update section padding in style.css, fix broken link in header.php, and improve Movie model)
