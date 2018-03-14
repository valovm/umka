var ready = function () {


    $('input.input-phone').mask('+7(999)999-9999');


    $('#callback_form').each(function () {


        form = $(this);
        var messages = $('<div/>', {html: '', class: 'form-messages'});
        form.prepend(messages);

        var modal = form.parents('.modal');
        var modal_title = $(modal).find('.modal__title');




        form.submit(function () {
            messages.html('');
            $.ajax({
                url: '/sendmail.php',
                dataType: 'JSON',
                method: 'POST',
                data: form.serialize(),

                success: function (result) {

                    for (let i in result.errors) {
                        messages.prepend(
                            $('<div/>',
                                {
                                    class: 'form-messages__item error',
                                    html: result.errors[i],
                                }
                            )
                        );
                    }

                    if (result.send > 0) {

                        $(modal_title).html('Заявка принята');
                        form.addClass('send')


                    }
                },

                error: function (result) {

                }
            });
            return false;
        });


    });


};


$(document).ready(ready);