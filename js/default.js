$(function() {
    /* disable links v boxoch kym sa nespravia prelinky */
	$('.main_boxes a').bind('click', function(event) {
		event.preventDefault();
	});

	/* start singup or signout into newsletter */
    $('#newsletter_singup_link').click(function() {
        $('#newsletter_singup').fadeOut(function() {
            $('#newsletter_singout').fadeIn();
        });
    });

    $('#newsletter_singout_link').click(function() {
        $('#newsletter_singout').fadeOut(function() {
            $('#newsletter_singup').fadeIn();
        });
    });

    /* spracovanie newslettra */
    $("form#newsletter-form").submit(function() {
        var form = $(this).serialize();

        $.post(ROOT_PATH + "ajax_newsletter.php", form, function(data) {
            var newsletter_error = $("div#" + data.type + " div.newsletter_error");

            if (data.error) {
                if (newsletter_error.is(":visible")) {
                    newsletter_error.show(function() {
                        newsletter_error.html(data.message);
                        newsletter_error.hide();
                    });
                }
                else {
                    newsletter_error.html(data.message);
                    newsletter_error.show();
                }
                return false;
            }
            else {
                if (data.type == "newsletter_singup")
                    document.location.href = ROOT_PATH + "newsletter?mail_write=1&email=" + data.email;
                else
                    document.location.href = ROOT_PATH + "newsletter?mail_unsubscribe_form_sent=1&email=" + data.email;
            }
        }, 'json');

        return false;
    });
});