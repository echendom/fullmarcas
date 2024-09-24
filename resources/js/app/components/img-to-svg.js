const init = () => {
  const $imagesToConvert = $('.img-to-svg');
  $imagesToConvert.each(async function() {
    const $img = $(this);
    const src = $img.attr('src');
    if (!src.endsWith('.svg')) {
      return;
    }
    const width = $img.attr('width');
    const height = $img.attr('height');
    const className = $img.attr('class').replaceAll('img-to-svg', '');
    try {
      const res = await fetch(src);
      const svgContent = await res.text();
      const $svgContent = $(svgContent);
      const $path = $svgContent.find('path');
      const pathStroke = $path.attr('stroke');
      const svgFill = $svgContent.attr('fill');
      const pathFill = $path.attr('fill');
      $svgContent.attr('class', className);
      if (svgFill !== 'none') {
        $svgContent.attr('fill', 'currentColor');
      }
      if (pathStroke) {
        $path.attr('stroke', 'currentColor');
      }
      if (pathFill) {
        $path.attr('fill', 'currentColor');
      }
      if (width) {
        $svgContent.attr('width', width);
      }
      if (height) {
        $svgContent.attr('height', height);
      }
      $img.replaceWith($svgContent);
    } catch(err) {
      console.log('img-to-svg error:', err);
    }
  });
};

export default { init };
