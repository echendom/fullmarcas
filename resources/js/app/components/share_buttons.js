let timeout;

const init = () => {
  const $copyBtn = $('.blog-content__share-button--copy');
  if (!$copyBtn.length) {
    return;
  }

  const $copyTxt = $copyBtn.find('.blog-content__share-text');
  const initialText = $copyTxt.text();

  $copyBtn.on('click', function() {
    clearTimeout(timeout);

    let url = $copyBtn.attr('data-url');
    if (url) {
      if (!url.startsWith('http')) {
        url = `${location.protocol}//${location.host}${url}`;
      }
    } else {
      url = window.location.href;
    }

    const $temp = $("<input>");
    $("body").append($temp);

    $temp.val(url).select();
    document.execCommand("copy");
    $temp.remove();

    $copyTxt.text('Enlace copiado');

    timeout = setTimeout(() => {
      $copyTxt.text(initialText);
    }, 3000);
  });
};

export default { init };
