import { gsap } from "gsap";

const DESKTOP = 980;
const TABLET = 767;
const SMALLTABLET = 575;

const init = () => {
  initTestimonial();
  initOurHistory();
  initHeroBlog();
  initArticleGallery();
  initBlogListingInline();
  initHeroHomeSlider();
};

const initHeroHomeSlider = () => {

  const $slider = $('.home-hero-slider');

  if (!$slider) {
    return;
  }

  $slider.slick({
    infinite: true,
    arrows: false,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 3000,
  })
};

const initBlogListingInline = () => {
  const $slider = $('.blog-listing-inline__list');
  if (!$slider) {
    return;
  }
  const $container = $('.blog-listing-inline');
  const $prevArrow = $('.blog-listing-inline__button-left');
  const $nextArrow = $('.blog-listing-inline__button-right');
  const $progressBar = $('.blog-listing-inline__progress-fill');

  const slides = $container.find('.card--blog');
  const hideFooterOnMobile = slides.length < 2;
  const hideFooterOnTablet = slides.length < 3;
  const hideFooterOnDesktop = slides.length < 4;

  const $sliderFooter = $container.find('.blog-listing-inline__slide-footer');
  $sliderFooter.toggleClass('blog-listing-inline__slide-footer--hide-mobile', hideFooterOnMobile);
  $sliderFooter.toggleClass('blog-listing-inline__slide-footer--hide-tablet', hideFooterOnTablet);
  $sliderFooter.toggleClass('blog-listing-inline__slide-footer--hide-desktop', hideFooterOnDesktop);

  $slider.on("init", function(event, slick) {
    const nextSlide = 0;
    const percentage = ( (nextSlide + slick.options.slidesToShow) / (slick.slideCount) ) * 100;

    $progressBar.css('width', percentage + '%');
  });
  $slider.slick({
    arrows: true,
    dots: false,
    infinite: false,
    slidesToScroll: 1,
    slidesToShow: 3,
    prevArrow: $prevArrow,
    nextArrow: $nextArrow,
    responsive: [
      {
        breakpoint: DESKTOP,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: SMALLTABLET,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
  $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
    const percentage = ( (nextSlide + slick.options.slidesToShow) / (slick.slideCount) ) * 100;

    $progressBar.css('width', percentage + '%');
  });
};

const initArticleGallery = () => {
  const $slider = $('.blog-content__image-slider');
  if (!$slider) {
    return;
  }
  const $prevArrow = $('.blog-content__button--prev');
  const $nextArrow = $('.blog-content__button--next');
  const $pageIndicator = $('.blog-content__page-indicator');
  const $slides = $('.blog-content__image');

  const $progressBar = $('.blog-content__progress-fill');
  $slider.on("init", function(event, slick) {
    const nextSlide = 0;
    const percentage = ( (nextSlide + slick.options.slidesToShow) / (slick.slideCount) ) * 100;

    $progressBar.css('width', percentage + '%');
  });

  $slider.on('beforeChange', function(event, slick, prevSlide, nextSlide) {
    const percentage = ( (nextSlide + slick.options.slidesToShow) / (slick.slideCount) ) * 100;

    $progressBar.css('width', percentage + '%');

    const newText = `${nextSlide + 1} de ${$slides.length}`;
    $pageIndicator.text(newText);
  });
  $slider.slick({
    arrows: true,
    dots: false,
    infinite: true,
    slidesToScroll: 1,
    slidesToShow: 1,
    prevArrow: $prevArrow,
    nextArrow: $nextArrow,
  });
};

const initHeroBlog = () => {
  const $slider = $('.hero-blog__slider');
  if (!$slider) {
    return;
  }
  const $container = $('.hero-blog__highlighted-posts');
  const $prevArrow = $('.hero-blog__button--prev');
  const $nextArrow = $('.hero-blog__button--next');
  const $pageIndicator = $('.hero-blog__page-indicator');
  const $slides = $('.hero-blog__post');
  const slidesCount = $slides.length;
  $slider.on('init', function() {
    const tl = gsap.timeline();
    // Fade-in
    tl.fromTo(
      $container[0],
      { opacity: 0, y: 5 },
      { opacity: 1, y: 0, duration: 0.8 }
    );
  });
  $slider.on('beforeChange', function(event, slick, prevSlide, nextSlide) {
    const newText = `${nextSlide + 1} de ${slidesCount}`;
    $pageIndicator.text(newText);
  });
  $slider.slick({
    arrows: true,
    dots: false,
    infinite: true,
    slidesToScroll: 1,
    slidesToShow: 1,
    prevArrow: $prevArrow,
    nextArrow: $nextArrow
  });
};

const initOurHistory = () => {
  const $slider = $('.our-history__slider');
  if (!$slider.length) {
    return;
  }

  let currentIndex = 0;
  const minIndex = 0;
  const maxIndex = $slider.children().length - 1;

  let minPageIndex = 0;
  let maxPageIndex = 2;

  const $prevButton = $('.our-history__slider-button--prev');
  const $nextButton = $('.our-history__slider-button--next');
  const $prevButtonMobile = $('.our-history__slider-mobile-button--prev');
  const $nextButtonMobile = $('.our-history__slider-mobile-button--next');
  const $pagination = $('.our-history__slider-indicators');
  const $slides = $('.our-history__slide');

  const $progressBar = $('.our-history__progress-fill');
  $slider.on("init", function(event, slick) {
    const nextSlide = 0;
    const percentage = ( (nextSlide + slick.options.slidesToShow) / (slick.slideCount) ) * 100;

    $progressBar.css('width', percentage + '%');
  });
  $slider.slick({
    lazyLoad: 'ondemand',
    slidesToShow: 3,
    slidesToScroll: 3,
    dots: false,
    arrows: false,
    infinite: false,
    responsive: [
      {
        breakpoint: TABLET,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          arrows: true,
          prevArrow: $prevButtonMobile,
          nextArrow: $nextButtonMobile,
        }
      },
      {
        breakpoint: SMALLTABLET,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          prevArrow: $prevButtonMobile,
          nextArrow: $nextButtonMobile,
        }
      }
    ]
  });

  // Set data-attribute to 'false' on slides with data-active attribute set to 'true'.
  function setInactive() {
    const activeElement = $('.our-history__slide[data-active="true"]');
    activeElement.attr('data-active', 'false');
  };

  function updatePagination() {
    $pagination.text(`${currentIndex+1} de ${maxIndex+1}`);
  };

  // Calculate the next slide to be highlighted and update slider bounds.
  $slider.on('beforeChange', function(event, slick, currentSlide, newSlide) {
    const percentage = ( (newSlide + slick.options.slidesToShow) / (slick.slideCount) ) * 100;

    $progressBar.css('width', percentage + '%');

    if (currentSlide === newSlide) {
      // Didn't move.
      return;
    }
    setInactive();
    const { slidesToShow } = slick.options;
    if (newSlide > currentSlide) {
      // Sliding forwards -> current index is gonna be the new slide.
      currentIndex = newSlide;
    } else {
      // Sliding backwards -> current index is gonna be the current slide minus one.
      currentIndex = currentSlide - 1;
    }
    maxPageIndex = newSlide + slidesToShow - 1;
    minPageIndex = newSlide;
    const nextElement = $(`.our-history__slide[data-index="${currentIndex}"]`);
    nextElement.attr('data-active', 'true');

    updatePagination();
  });

  // Go to next slide to be highlighted.
  // Argument newIndex is the 0-based index of the slide to be highlighted.
  const goToSlide = (newIndex) => {
    // Check whether new index is less than 0 or greater than the number of slides.
    if ((newIndex > maxIndex) || (newIndex < minIndex)) {
      return;
    }
    if (newIndex > maxPageIndex) {
      // Slide to right - slick event handler takes care of updating the slider bounds.
      $slider.slick('slickNext');
      return;
    } else if (newIndex < minPageIndex) {
      // Slide to left - slick event handler takes care of updating the slider bounds.
      $slider.slick('slickPrev');
      return;
    }

    // At this point the slide to be highlighted is within the slider bounds.
    setInactive();

    const nextElement = $(`.our-history__slide[data-index="${newIndex}"]`);
    nextElement.attr('data-active', 'true');
    currentIndex = newIndex;

    updatePagination();
  };

  $nextButton.on('click', function() {
    goToSlide(currentIndex + 1);
  });
  $prevButton.on('click', function() {
    goToSlide(currentIndex - 1);
  });

  $slides.on('click', function() {
    const $slide = $(this);
    const slideIndex = +$slide.attr('data-index'); // Cast to number.

    if (slideIndex == currentIndex) {
      return;
    }

    goToSlide(slideIndex);
  });
};

const initTestimonial = () => {
  const $slider = $('.testimonial-slider__slider');
  if (!$slider.length) {
    return;
  }
  $slider.slick({
    infinite: true,
    autoplay: true,
    autoplaySpeed: 7000,
    slidesToShow: 3,
    centerMode: true,
    focusOnSelect: true,
    dots: false,
    arrows: false,
    cssEase: 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
    responsive: [
      {
        breakpoint: DESKTOP,
        settings: {
          slidesToShow: 1
        }
      },
    ]
  });
};

export default { init };
