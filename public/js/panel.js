/**
 * Panel – Auto-submit de filtros select
 */
window.onload = function () {
    var selects = document.querySelectorAll('.filters-bar select');

    for (var i = 0; i < selects.length; i++) {
        selects[i].onchange = function () {
            this.closest('form').submit();
        };
    }
};
