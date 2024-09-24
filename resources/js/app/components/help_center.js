import { gsap } from "gsap";

const init = () => {
  const $tabs = $('.help-center__tabs');
  if (!$tabs.length) {
    return;
  }
  const $faqTabs = $('.help-center__faq-tabs');
  $tabs.tabs({
    hide: true,
    show: true,
    heightStyle: 'content',
    create: function() {
      if (!$faqTabs.length) {
        return;
      }
      $faqTabs.tabs({
        hide: true,
        heightStyle: 'content',
        create: function() {
          const tl = gsap.timeline();
          tl.fromTo(
            '.help-center__faq-tabs',
            { opacity: 0, y: 5 },
            { opacity: 1, y: 0, duration: 0.8 }
          );
          const $questionsAccordion = $('.help-center__faq-accordion');
          if (!$questionsAccordion) {
            return;
          }
          $questionsAccordion.accordion({
            collapsible: true,
            icons: false,
            heightStyle: 'content'
          });
        }
      });
    }
  });

  const $mobileAccordion = $('.help-center__faq-mobile-accordion');
  const $header = $('.help-center__faq-mobile-accordion-header');
  const $headerText = $('.help-center__faq-mobile-accordion-text');
  const $optionsContainer = $('.help-center__faq-mobile-accordion-options');
  const $options = $('.help-center__faq-mobile-accordion-option');

  $mobileAccordion.accordion({
    icons: false,
    collapsible: true,
    active: false,
    header: function(accordionElement) {
      return accordionElement.find($header)
    },
    create: function() {
      $optionsContainer.toggleClass('hidden');
    }
  });

  $options.each(function(index, option) {
    $(option).on('click', function() {
      $mobileAccordion.accordion({
        active: false
      });
      $faqTabs.tabs({ active: index });
      const newHeaderContent = $(option).html();
      $headerText.html(newHeaderContent);
      const $activeCategory = $('.help-center__faq-mobile-accordion-option--active');
      $activeCategory.toggleClass('help-center__faq-mobile-accordion-option--active', false);
      $(option).toggleClass('help-center__faq-mobile-accordion-option--active', true);
    });
  })

  const hash = window.location.hash;
  if (!hash) {
    return;
  }
  $('a[href="'+hash+'"]').trigger('click');

}

export default { init };
