(() => {
  const {
    options: {
      selector
    }
  } = JSON.parse(window.SharedSettings && window.SharedSettings.data);
  const handleReady = () => {
    const sharebar = document.querySelector(`.shared-bar`);

    if (sharebar && selector) {
      const entryNode = document.querySelector(selector);

      if (entryNode) {
        entryNode.insertBefore(sharebar, entryNode.firstChild);
        sharebar.classList.remove('is-hidden');
      }
    }
  };

  const handleClick = (event) => {
    const sharebarToggler = event.target.closest('.shared-toggler');

    if (sharebarToggler) {
      const sharebar = sharebarToggler.closest('.shared-bar');

      if (sharebar) {
        sharebar.classList.toggle('is-open');
      }
    }
  }

  const handleScroll = (event) => {
    const sharebar = document.querySelector(`.shared-bar`);

    if (sharebar && sharebar.classList.contains('is-open')) {
      sharebar.classList.remove('is-open');
    }
  }

  document.addEventListener('DOMContentLoaded', handleReady);
  document.addEventListener('click', handleClick);

  window.addEventListener('scroll', handleScroll);
})();
