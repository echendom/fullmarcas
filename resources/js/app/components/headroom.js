import Headroom from "headroom.js";

const init = () => {
  const navbar = document.querySelector(".site__header .header");
  // construct an instance of Headroom, passing the element
  var headroom  = new Headroom(navbar);
  // initialise
  headroom.init();
}

export default { init };
