import scrollTrigger from "./scrolltrigger";

const init = () => {
  const $mobileBurgerButton = $('.header__mobile-button');
  const $header = $('.header');
  if (!$mobileBurgerButton.length) {
    return;
  }
  $mobileBurgerButton.on('click', function() {
    if ($mobileBurgerButton.hasClass('active')) {
      $('body').css('overflow', 'auto');
    } else {
      $('body').css('overflow', 'hidden');
    }
    $mobileBurgerButton.toggleClass('active');
    $header.toggleClass('mobile-active');
  });

  const $mobileFixedCta = $('.header__cta-button--mobile');
  if (!$mobileFixedCta.length) {
    return;
  }
  const $formHero = $('.hero-home__form');
  if (!$formHero.length) {
    $mobileFixedCta.toggleClass('hidden', false);
    return;
  }

  scrollTrigger('.hero-home__form', {
    // rootMargin: '-200px',
    callbackIn: function(el) {
      $mobileFixedCta.toggleClass('hidden', true);
    },
    callbackOut: function(el) {
      $mobileFixedCta.toggleClass('hidden', false);
    },
    repeat: true
  })
};

export default { init };
