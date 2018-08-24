jQuery(function ($) {
    $('#feedback-form').submit(function (event) {
        event.preventDefault();

        const $form = $(this);
        const $thanksDiv = $('#js-after-success-form-send');
        const data = $form.serialize();
        const $button = $form.find('button[type="submit"]');

        $button.prop('disabled', true);
        $.post('/api/feedback', data)
            .done(function (result) {
                result = JSON.parse(result);
                if (result && result.status) {
                    $form.fadeOut();
                    $thanksDiv.fadeIn();
                    $('.user-feedbacks').append(result.innerHtml);
                }
            })
            .fail(function () {
                alert('Something wrong, try again later...')
            })
            .always(function () {
                $button.prop('disabled', false);
            });
        return false;
    });
});
