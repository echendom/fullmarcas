const init = () => {
  const $accordion = $('.footer__links-column--accordion');
  if (!$accordion.length) {
    return;
  }
  const isDesktop = $(window).width() >= 768;
  const isMobile = !isDesktop;
  $accordion.accordion({
    icons: false,
    header: function (accordionElement) {
      return accordionElement.find(".footer__links-heading");
    },
    collapsible: true,
    disabled: isDesktop,
    active: isMobile ? false : 0
  });
  function disableAccordion() {
    $accordion.accordion('option', 'active', 0);
    $accordion.accordion('disable');
  }
  function enableAccordion() {
    $accordion.accordion('option', 'active', false);
    $accordion.accordion('enable');
  }

  window.addEventListener('resize', function toggleAccordion() {
    if ($(window).width() >= 768) {
      disableAccordion();
    } else {
      enableAccordion();
    }
  }, true);
};

export default { init };
