import Plyr from 'plyr';
import 'plyr/dist/plyr.css';

const init = () => {
  const $videos = $('.js-player');
  $videos.each(function() {
    new Plyr(this);
  });
};

export default { init };
