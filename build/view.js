/******/ (() => { // webpackBootstrap
/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
function filterByTerm(term) {
  // Reload the page with the selected taxonomy term as a query parameter
  const urlParams = new URLSearchParams(window.location.search);
  urlParams.set("filter_term", term);
  urlParams.set("taxonomy", "<?php echo esc_js($selectedTaxonomy); ?>");
  window.location.search = urlParams.toString();
}
/******/ })()
;
//# sourceMappingURL=view.js.map