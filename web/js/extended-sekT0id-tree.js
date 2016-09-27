$(document).ready(function () {
    function init() {
        $('.easy-tree').EasyTree({
            addable: false,
            editable: false,
            deletable: false,
            selectable: false
        });
    }

    window.onload = init();
});
