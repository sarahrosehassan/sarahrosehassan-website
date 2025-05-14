document.addEventListener("DOMContentLoaded", () => {
  // NAV TOGGLE (if you need it later)
  const menuToggle = document.querySelector("#menu-toggle");
  const navMenu = document.querySelector("#site-nav");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", () => {
      navMenu.classList.toggle("open");
    });
  }

  const text = "Hi, I'm Sarah!";
  const target = document.getElementById("typewriter");
  const cursor = target?.querySelector(".cursor");
  let i = 0;

  function typeWriter() {
    if (i < text.length && target && cursor) {
      target.insertBefore(document.createTextNode(text.charAt(i)), cursor);
      i++;
      setTimeout(typeWriter, 100);
    }
  }

  typeWriter();
});
