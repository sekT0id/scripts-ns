$(document).ready(function() {
    // Обработчик нажатия кнопки "Развернуть все"
    $('#btn-expand-all').on('click', function (e) {
        var levels = $('#select-expand-all-levels').val();
        $(tree).treeview('expandAll', { levels: levels, silent: $('#chk-expand-silent').is(':checked') });
    });

    // Обработчик нажатия кнопки "Свернуть все"
    $('#btn-collapse-all').on('click', function (e) {
        $(tree).treeview('collapseAll', { silent: $('#chk-expand-silent').is(':checked') });
    });

    // Подключаем дерево
    $('#tree').treeview({
        //data: treeData,
        enableLinks: true,
        showTags: true,
    });
});
