import { gsap, Sine } from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

function random(min, max) {
  const delta = max - min;
  return (direction = 1) => (min + delta * Math.random()) * direction;
}

const randomX = random(1, 200);
const randomY = random(1, 400);
const randomDelay = random(0, 15);
const randomTime = random(30, 35);
const randomTime2 = random(45, 50);
const randomAngle = random(-180, 180);

function getRndInteger(min, max) {
  return (Math.random() * (max - min) ) + min;
}

function rotate(target, direction) {
  gsap.to(target, randomTime2(), {
    rotation: randomAngle(direction),
    delay: randomDelay(),
    ease: Sine.easeInOut,
    onComplete: rotate,
    onCompleteParams: [target, direction * -1]
  });
}

function moveX(target, direction) {
  gsap.to(target, randomTime(), {
    x: randomX(direction),
    ease: Sine.easeInOut,
    onComplete: moveX,
    onCompleteParams: [target, direction * -1]
  });
}

function moveY(target, direction) {
  gsap.to(target, randomTime(), {
    y: randomY(direction),
    ease: Sine.easeInOut,
    onComplete: moveY,
    onCompleteParams: [target, direction * -1]
  });
}

const init = () => {
  initHeroHome();
  initAnimatedBackgrounds();
  initVerticalScrollReveal();
  initHorizontalScrollReveal();
};

const initVerticalScrollReveal = () => {
  const $containers = $('.gsap-animate');
  $containers.each(function() {
    const $items = $(this).find('.gsap-scrollreveal');
    $items.each(function(index, item) {
      let delay = 0;
      let start = 'top bottom-=150px';
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start,
          invalidateOnRefresh: true
        }
      });
      tl.fromTo(
        item,
        { opacity: 0, y: 5 },
        { opacity: 1, y: 0, duration: 0.8 },
        delay
      );
    })
  });
};

const initHorizontalScrollReveal = () => {
  const $containers = $('.gsap-animate');
  $containers.each(function() {
    const $items = $(this).find('.gsap-scrollreveal--horizontal');
    $items.each(function(index, item) {
      let delay = 0.5 + (0.2 * index);
      let start = 'top bottom-=100px';
      if ($(window).width() < 768) {
        delay = 0;
        start = 'top bottom-=200px';
      }
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start,
          invalidateOnRefresh: true
        }
      });
      tl.fromTo(
        item,
        { opacity: 0, y: 5 },
        { opacity: 1, y: 0, duration: 0.8 },
        delay
      );
    })
  });
};

const initAnimatedBackgrounds = () => {
  const blueLockSillouettes = gsap.utils.toArray('.animated-background__blue-lock');
  blueLockSillouettes.forEach(lockSillouette => {
    const tl = gsap.timeline();
    // Fade-in
    tl.fromTo(
      lockSillouette,
      { opacity: 0, y: 5 },
      { opacity: 1, y: 0, duration: 0.8 }
    );

    gsap.set(lockSillouette, {
      x: randomX(-1),
      y: randomX(1),
      rotation: randomAngle(-1)
    });

    moveX(lockSillouette, 1);
    moveY(lockSillouette, -1);
    rotate(lockSillouette, 1);
  });

  const whiteLockSillouettes = gsap.utils.toArray('.animated-background__white-lock');
  whiteLockSillouettes.forEach((lockSillouette, index) => {
    const tl = gsap.timeline();
    // Fade-in
    tl.fromTo(
      lockSillouette,
      { opacity: 0, y: 5 },
      { opacity: 1, y: 0, duration: 0.8 }
    );

    gsap.set(lockSillouette, {
      x: randomX(-1),
      y: randomX(1),
      rotation: randomAngle(-index)
    });

    moveX(lockSillouette, 1);
    moveY(lockSillouette, -1);
    rotate(lockSillouette, 1);
  });
};

const initHeroHome = () => {
  const $features = $('.hero-home__feature');
  if (!$features.length) {
    return;
  }
  $features.each(function(index) {
    const tl = gsap.timeline();
    const delay = 0.5 + (0.9 * index);
    tl.fromTo(
      `.hero-home__feature--${index + 1}`,
      { opacity: 0, y: 5 },
      { opacity: 1, y: 0, duration: 0.8 },
      delay
    );
  });
  const tlImage = gsap.timeline();
  tlImage.fromTo(
    `.hero-home__image`,
    { opacity: 0, y: 5 },
    { opacity: 1, y: 0, duration: 0.8 }
  );
  const tlBackground = gsap.timeline();
  tlBackground.fromTo(
    `.hero-home__decor-lock-filled`,
    { opacity: 0, y: 5 },
    { opacity: 1, y: 0, duration: 0.8 }
  );
};

export default { init };
