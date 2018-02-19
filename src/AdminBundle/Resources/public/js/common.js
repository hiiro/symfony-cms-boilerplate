$(function(){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $('.js-trigger-confirm').each(function () {
        $(this).click(function () {
            var message = '実行してもよろしいですか？';
            if ($(this).data('message')) {
                message = $(this).data('message');
            }
            if (window.confirm(message)) {
                return true;
            } else {
                return false;
            }
        });
    });
});