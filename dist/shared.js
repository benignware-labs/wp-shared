"use strict";

(function () {
  var _JSON$parse = JSON.parse(window.SharedSettings && window.SharedSettings.data),
      selector = _JSON$parse.options.selector;

  var handleReady = function handleReady() {
    var sharebar = document.querySelector(".shared-bar");

    if (sharebar && selector) {
      var entryNode = document.querySelector(selector);

      if (entryNode) {
        entryNode.insertBefore(sharebar, entryNode.firstChild);
        sharebar.classList.remove('is-hidden');
      }
    }
  };

  var handleClick = function handleClick(event) {
    var sharebarToggler = event.target.closest('.shared-toggler');

    if (sharebarToggler) {
      var sharebar = sharebarToggler.closest('.shared-bar');

      if (sharebar) {
        sharebar.classList.toggle('is-open');
      }
    }
  };

  var handleScroll = function handleScroll(event) {
    var sharebar = document.querySelector(".shared-bar");

    if (sharebar && sharebar.classList.contains('is-open')) {
      sharebar.classList.remove('is-open');
    }
  };

  document.addEventListener('DOMContentLoaded', handleReady);
  document.addEventListener('click', handleClick);
  window.addEventListener('scroll', handleScroll);
})();
