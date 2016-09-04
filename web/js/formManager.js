$(document).ready(function(){
    // Событие перед отправой формы, определенное в Yii
    $('form').on('beforeSubmit', function () {
        // Заблокировать элементы формы
        $(this).css('opacity', 0.5);
        $(this).find(':submit').attr('disabled', 'disabled');
        $(this).find('button').attr('disabled', 'disabled');
        // Когда форма отправляется, предотвратить последующие отправки
        $(this).on('submit', function (e) {
            e.preventDefault();
            // Для уверенности, на всякий случай
            return false;
        });
    });
});
