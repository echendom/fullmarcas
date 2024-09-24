const init = () => {
  const $faqAccordions = $('.faq-accordions__accordion-item');
  if (!$faqAccordions.length) {
    return;
  }
  $faqAccordions.each(function() {
    const $item = $(this);
    $item.accordion({
      icons: false,
      heightStyle: 'content',
      collapsible: true,
      active: false,
      beforeActivate: function() {
        $('.faq-accordions__accordion-item').not($item).accordion('option', 'active', false);
      }
    });
  });
  const $accordionHeaders = $('.faq-accordions__item-heading');
  let tallestHeaderSize = 0;
  $accordionHeaders.each(function() {
    const $header = $(this);
    const headerHeight = $header.outerHeight();
    if (headerHeight > tallestHeaderSize) {
      tallestHeaderSize = headerHeight;
    }
  });
  if ($(window).width() > 767) {
    $accordionHeaders.css('height', tallestHeaderSize);
  }
};

export default { init };
