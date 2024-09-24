/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./app/main");

require("./vue/main");

import slick from "./app/components/slick";
import headroom from "./app/components/headroom";
import faq from "./app/components/faq";
import video from "./app/components/video";
import share_buttons from "./app/components/share_buttons";
import help_center from "./app/components/help_center";
import gsap from "./app/components/gsap";
import header from "./app/components/header";
import footer from "./app/components/footer";
import imgToSvg from "./app/components/img-to-svg";

$(function() {
  slick.init();
  headroom.init();
  faq.init();
  video.init();
  share_buttons.init();
  help_center.init();
  gsap.init();
  header.init();
  footer.init();
  imgToSvg.init();
})
