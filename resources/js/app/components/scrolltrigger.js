function scrollTrigger(selector, options = {}) {
  let els = document.querySelectorAll(selector)
  els = Array.from(els)
  els.forEach(el => {
    addObserver(el, options)
  })
}
function addObserver(el, options) {
  // Check if `IntersectionObserver` is supported
  if (!('IntersectionObserver' in window)) {
    // Simple fallback
    // The animation/callback will be called immediately so
    // the scroll animation doesn't happen on unsupported browsers
    if (options.callbackIn) {
      options.callbackIn(el)
    } else {
      entry.target.classList.add('active')
    }
    // We don't need to execute the rest of the code
    return
  }
  let observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (options.callbackIn) {
          options.callbackIn(el);
        } else {
          entry.target.classList.add('active');
        }
        if (!options.repeat) {
          observer.unobserve(entry.target);
        }
      } else {
        if (options.callbackOut) {
          options.callbackOut(el);
        }
      }
    })
  }, options);
  observer.observe(el);
}

export default scrollTrigger;

// Example usages:
/*
scrollTrigger('.intro-text')
scrollTrigger('.scroll-reveal', {
  rootMargin: '-200px',
})
scrollTrigger('.loader', {
  rootMargin: '-200px',
  callbackIn: function(el){
    el.innerText = 'Loading...'
    setTimeout(() => {
      el.innerText = 'Task Complete!'
    }, 1000)
  }
})
*/