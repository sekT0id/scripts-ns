$(document).ready(function () {
    $(".table-modal tr").click(function () {
        $("tr").removeClass("btn-default");
        $(this).toggleClass("btn-default");
        $("#form-clientid").val($(this).attr("id"));
        $("button[type='submit']").removeAttr("disabled");
    });


    $(".item-modal a").click(function () {
        var id = $(this).attr("data-set");

        $(".item-modal").removeClass("btn-default");
        $("#item-" + id).toggleClass("btn-default");
        $("#form-id").val(id);
        $("#link-submit").removeAttr("disabled");
    });

    $(".add-link").click(function () {
        var id = $(this).attr("data-set");

        $('#form-parentid').val(id);

        $('.item-modal').removeClass('btn-default');
        $('.item-modal').removeClass('btn-info');
        $('.item-modal a').removeClass('hidden');

        $('.item-modal p').remove();

        $('#link-submit').attr('disabled', 'disabled');

        $("#item-" + id).addClass("btn-info");
        $("#item-" + id + " a").addClass("hidden");
        $("#item-" + id).append("<p>" + $("#item-" + id + " a").text() + "</p>");
    });

    $(".btn-start").click(function () {
        $("tr").removeClass("btn-default");
        $("button[type='submit']").attr('disabled', 'disabled');
    });
});
