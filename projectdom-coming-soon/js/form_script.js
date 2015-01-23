/*
 *Your Ajax Server Here if it was not defined in html site-config element, 
 * use internal url (such as './ajaxserver/server.php') or 
 * external URL such as:  url: 'http://www.example.com/avenir/ajaxserver/server.php'
 * depending to your requirements
 */
var email_server_url = './ajaxserver/server.php';
var message_server_url = './ajaxserver/server.php';
//Check if action attribute (which indicates server) of form tag is set, then choose it (low priority)
if($('.send_email_form').attr('action') && ($('.send_email_form').attr('action')) != ''){
    email_server_url = $('.send_email_form').attr('action');
}
if($('.send_message_form').attr('action') && ($('.send_message_form').attr('action') != '')){
    message_server_url = $('.send_message_form').attr('action');
}

//Check if server is set in site-config param (max priority)
if($('.site-config').attr('data-subscription-server') && ($('.site-config').attr('data-subscription-server')) != ''){
    email_server_url = $('.site-config').attr('data-subscription-server');
}
if($('.site-config').attr('data-message-server') && ($('.site-config').attr('data-message-server') != '')){
    message_server_url = $('.site-config').attr('data-message-server');
}

$(function () {

    var $ajax = {
        sendEmail: function (p) {
            var form_fill = $(p);

            // Get the form data.
            var form_inputs = form_fill.find(':input');
            var form_data = {};
            form_inputs.each(function () {
                form_data[this.name] = $(this).val(); 
            });
            console.log(form_data);
//            var form_data = $(form_fill).serialize();
//            form_data['email'] = $('#email-sub').val(); 
            $.ajax(
                {
                    /*
                     *Your Ajax Server Here, 
                     * use internal url (such as './ajaxserver/server.php') or 
                     * external URL such as:  url: 'http://www.example.com/avenir/ajaxserver/server.php'
                     * depending to your requirements
                     */
                    url: email_server_url,
                    // url: $('.send_email_form').attr('action'),
                    type: 'get',
                    data: form_data,
                    dataType: 'json',

                    /* CALLBACK FOR SENDING EMAIL GOEAS HERE */
                    success: function (data) {
                        //Ajax connexion was a success, now handle response
                        if (data && !data.error) {
                            // Hide for if no error
                            $('.subscribe-btn p').html($('.hidden-response').text());
                            $('.subscribe-btn').addClass('email-sent');
                        }
                        // Else the login credentials were invalid.
                        else {
                           //Ajax connexion reject an error a success, now handle response
                            console.log('Could not process AJAX request to server');
                        }
                    },
                    /* show error message */
                    error: function (jqXHR, textStatus, errorThrown) {
                        //ajax error
                        console.log('ajax error');
                        
                    }
                    /* END EMAIL SENDING CALLBACK */
                });
        },
        sendMessage: function (p) {
            var form_fill = $(p);

            // Get the form data.
            var form_inputs = form_fill.find(':input');
            var form_data = {};
            form_inputs.each(function () {
                form_data[this.name] = $(this).val();
            });

            //alert(JSON.stringify(form_data));

            $.ajax(
                {
                    /*
                     *Your Ajax Server Here, 
                     * use internal url (such as './ajaxserver/server.php') or 
                     * external URL such as:  url: 'http://www.example.com/avenir/ajaxserver/server.php'
                     * depending to your requirements
                     */
                    url: message_server_url,
                    // url: $('.send_message_form').attr('action'),
                    type: 'get',
                    data: form_data,
                    dataType: 'json',

                    /* CALLBACK FOR SENDING EMAIL GOEAS HERE */
                    success: function (data) {

                        // If the returned login value successful.
                        if (data && !data.error) {

                            // Hide any error message that may be showing.
                            //Close Dialog
                            $(".dialog-container").addClass("invisible");
                            $(".dialog-container").removeClass("visible");

                            $(".dialog-grid").addClass("invisible");
                            $(".dialog-grid").removeClass("visible");
                            dialogopen = false;
                        }
                        // Else the login credentials were invalid.
                        else {
                            /* show validation error */
                            $('.message').html(data.error);
                        }
                    },
                    /* show error message */
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('.message').html('Error when sending email.');
                    }
                    /* END EMAIL SENDING CALLBACK */
                });
        }
    };

    /* delegate submit event via ajax */
    $('.send_email_form').submit(function (event) {
        event.preventDefault();
        console.log('email should be sent');
        $ajax.sendEmail(this);
    });
    $('.send_message_form').submit(function (event) {
        event.preventDefault();
        console.log('message should be sent');
        $ajax.sendMessage(this);
    });
});

