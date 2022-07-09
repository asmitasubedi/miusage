(($) => {

    $('form[name="miusage-refresh-form"]').on('submit', (e) => {
        e.preventDefault();

        let form = $(e.target);
        let data = form.serialize();
        let url = form.attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: (response) => {
                console.log(response);
                if (response.success) {
                    $('.miusage-refresh-challenges-response').html(response.data.message);
                    location.reload();
                } else {
                    $('.miusage-refresh-challenges-response').html(response.data.message);
                }
            },
            error: (error) => {
                console.log(error);
                $('.miusage-refresh-challenges-response').html(error.data.message);
            },
            complete: () => {
                console.log('complete');
            }
        });
    });
})(jQuery);
