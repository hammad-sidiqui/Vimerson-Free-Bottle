$(window).on('load', function () {
    $('input', '#step2').addClass('ignore');
    $('input', '#step3').addClass('ignore');
    $('input', '#step4').addClass('ignore');
    $('input', '#step5').addClass('ignore');
    // $('input', '#step6').addClass('ignore');
});

var time_step_one = 0; var step_one = 0;
var time_step_two = 0; var step_two = 0;
var time_step_three = 0; var step_three = 0;
var time_step_four = 0; var step_four = 0;
/* var time_step_five = 0; var step_five = 0;
var time_step_six = 0; var step_six = 0; */
var form_id = generateRandomNumber();
var order_id = '';
var bottle_id = '';
var bottle_ids = [];
var variant_ids = [];
var shipping_details = '';
var shipping_address = '';
var customer_data = '';
var bottles_to_qualify = 0;
var user_data = null;
var highlighted_class = ''
// var order_404_error = '<p>Oops! We can’t find that order number, please check the number. You can <a href="https://www.amazon.com/gp/your-account/order-history/ref=ppx_yo2_dt_b_search?opt=ab&amp;search=vimerson" target="_blank">access your Amazon Order details here</a>  or contact our Customer Happiness  Team who will be glad to help you.  You can reach our friendly team via the chat button on the bottom right  of the screen, by calling <a href="tel:+8009103491" target="_blank">(800) 910-3491</a> or email us at<strong> </strong><a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a>.</p>';
var order_404_error = '<p>Our system cannot find that order number, please check and try again. Alternatively, please contact a member of our Customer Happiness team via the chat button below or at <a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a> and we’ll be happy to help you further.</p>';

var order_status_error = '<p>Our system shows that this order was cancelled or not yet shipped. If you think that this information is incorrect, please contact a member of our Customer Happiness team using the chat below or at <a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a> and we’ll be happy to help you further.</p>';
// var order_status_error = '<p>Our system shows that this Amazon order was cancelled. If you think that this information is incorrect, please contact a member of our Customer Happiness team at <a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a> and we’ll be happy to help you further.</p>';

var already_qualify_error = '<p>Our system shows that the free supplement for this order has already been claimed. If you think that this information is incorrect, please contact a member of our Customer Happiness team at <a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a> and we’ll be happy to help you further.</p>';

var asin_not_registered = '<p>This order does not qualify for a free product. If you think that this information is wrong, or you have any questions, please contact our Customer Happiness team via the chat button at the bottom right of this screen, calling <a href="tel:+8009103491" target="_blank">(800) 910-3491</a> or email us at<strong> </strong><a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a>.</p>';

jQuery(function ($) {

    startOne()

    var selected_star = 0;
    var user_id = null;

    /******* Step 01 *******/
    $('#stepone').click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $('.logo').hide();
        $('.free-bottle-title').hide();

        if (v.form()) {
            let url = '/api/vimerson/create/user';

            user_data = {
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                email: $('#email').val(),
                phone_number: $('#phone_number').val()
            };

            $('body').addClass('overflow');

            ajaxCall('POST', url, 'json', user_data, function (onSuccess) {
                if (onSuccess.status) user_id = onSuccess.data.id;

                // submit timetracker
                let tracker_data = {
                    user_id: user_id,
                    form_id: form_id,
                    step_one_time: time_step_one
                }

                ajaxCall('POST', '/api/vimerson/step/form/timetracker', 'json', tracker_data);
                clearInterval(step_one);

                $('input', '#step2').removeClass('ignore');
                $('#progressbar li').eq($('fieldset').index(next_fs)).addClass('active');
                $('#step1').hide();
                $('#step2').show();
                window.scrollTo(0, 0);

                startTwo()
            });
        }
    });

    $('#back1').click(function () {
        $(".logo").show();
        $(".free-bottle-title").show();

        clearInterval(step_two); startOne()

        $('input', '#step2').addClass('ignore');

        current_fs = $(this).parent();
        back_fs = $(this).parent().prev();

        $('#progressbar li').eq($('fieldset').index(current_fs)).removeClass('active');
        $('#step2').hide();
        $('#step1').show();
        window.scrollTo(0, 0);
    });

    /******* Step 02 *******/
    $('#steptwo').click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $('#stepthree').attr('disabled', false);

        if (v.form()) {

            order_id = $('#order_id').val();
            let data = { user_id: user_id, order_id: order_id }
            $('.amazon-order-error').hide();

            ajaxCall('POST', '/api/vimerson/amazon/order_details', 'json', data, function (onSuccess) {
                $('.amazon-order-error').hide();
                if (onSuccess.status) {
                    if (onSuccess.status.order_details.data.OrderStatus == 'Shipped') {
                        shipping_details = onSuccess.status.order_details.data;
                        
                        // submit timetracker
                        let tracker_data = {
                            user_id: user_id,
                            form_id: form_id,
                            step_two_time: time_step_two
                        }

                        let asin_list = [];

                        for (let i = 0; i < onSuccess.status.item_details.data.length; i++) {
                            asin_list.push(onSuccess.status.item_details.data[i]['ASIN']);
                        }

                        ajaxCall('POST', '/api/vimerson/bottle/to/qualify', 'json', data, function (onSuccess) {
                            $('.qualify-bottles-alert').html(onSuccess.message)
                            bottles_to_qualify = onSuccess.data.qualify.bottles_to_qualify;
                            total_free_bottles = onSuccess.data.qualify.total_free_bottles;
                            if(total_free_bottles == 0)  {
                                showErrorMessage(asin_not_registered);
                            } else if (bottles_to_qualify == 0) {
                                showErrorMessage(already_qualify_error);
                            } else {
                                ajaxCall('POST', '/api/vimerson/get/bottles/by/asin?type=html', 'html', { 'asin': asin_list }, function (onSuccess) {
                                    $('.free-bottles').html(onSuccess)
                                });

                                /* ajaxCall('GET', '/api/vimerson/get/featured/questionnaire?type=html', 'html', [], function (onSuccess) {
                                    $('.questionnaire-block').html(onSuccess)
                                }); */

                                ajaxCall('GET', '/api/vimerson/get/amazon/popup/status', 'json', {}, function (onSuccess) {
                                    if (onSuccess.data == 1 || onSuccess.data == 'true') {
                                        $('#popup_amazon_feedback').show();
                                        $('#stepthree').attr('disabled', true);
                                    } else $('#popup_amazon_feedback').hide();
                                });

                                ajaxCall('POST', '/api/vimerson/step/form/timetracker', 'json', tracker_data);
                                clearInterval(step_two);

                                $('input', '#step3').removeClass('ignore');
                                $('#progressbar li').eq($('fieldset').index(next_fs)).addClass('active');
                                $('#step2').hide();
                                $('#step3').show();
                                window.scrollTo(0, 0);

                                startThree();
                            }
                        });
                    } else {
                        showErrorMessage(order_status_error);
                    }
                } else {
                    showErrorMessage(order_404_error);
                }
            });
        }
    });

    $('#back2').click(function () {
        clearInterval(step_three); startTwo()

        $('input', '#step3').addClass('ignore');

        current_fs = $(this).parent();
        back_fs = $(this).parent().prev();

        $('#progressbar li').eq($('fieldset').index(current_fs)).removeClass('active');
        $('#step3').hide();
        $('#step2').show();
        window.scrollTo(0, 0);
    });

    /******* Step 03 *******/
    $('#stepthree').click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        if (v.form()) {

            let questionnaire = $('.questionnaire-block > div').length;
            let questionnaire_data = [];

            for (let index = 1; index <= questionnaire; index++) {
                questionnaire_data.push({
                    question: $.trim($('.question_' + index).clone().children().remove().end().text()),
                    answer: $('#answer_' + index).val()
                })
            }

            let url = '/api/vimerson/add/feedback';

            let data = {
                user_id: user_id,
                order_id: order_id,
                bottle_ids: bottle_ids,
                stars: selected_star,
                feedback: $('#feedback').val(),
                questionnaire: questionnaire_data
            };

            ajaxCall('POST', url, 'json', data, function (onSuccess) {
                if (onSuccess.status) {

                    // submit timetracker
                    let tracker_data = {
                        user_id: user_id,
                        form_id: form_id,
                        step_three_time: time_step_three
                    }

                    ajaxCall('POST', '/api/vimerson/step/form/timetracker', 'json', tracker_data);
                    clearInterval(step_three)

                    let step_data = { user_id: user_id, bottle_ids: bottle_ids, type: 'html' };

                    ajaxCall('POST', '/api/vimerson/step/details', 'html', step_data, function (onSuccess) {
                        $('.confirmation-details').html(onSuccess)
                    });

                    setCustomerData();
                    setShippingAddress();

                    $('#shipping_name').val(user_data.first_name ? user_data.first_name : '');
                    $('#shipping_last_name').val(user_data.last_name ? user_data.last_name : '');
                    $('#shipping_phone').val(user_data.phone_number ? user_data.phone_number : '');
                    $('#shipping_address').val(shipping_details.ShippingAddress.AddressLine1 ? shipping_details.ShippingAddress.AddressLine1 : '');
                    $('#shipping_city').val(shipping_details.ShippingAddress.City ? shipping_details.ShippingAddress.City : '');
                    $('#shipping_state').val(shipping_details.ShippingAddress.StateOrRegion ? shipping_details.ShippingAddress.StateOrRegion : '');
                    $('#shipping_zip').val(shipping_details.ShippingAddress.PostalCode.split('-')[0] ? shipping_details.ShippingAddress.PostalCode.split('-')[0] : '');

                    $('input', '#step4').removeClass('ignore');
                    $('#progressbar li').eq($('fieldset').index(next_fs)).addClass('active');
                    $('#step3').hide();
                    $('#step4').show();
                    window.scrollTo(0, 0);

                    startFour();
                }
            });
        }
    });

    $('#back3').click(function () {
        clearInterval(step_four); startThree();

        $('input', '#step4').addClass('ignore');

        current_fs = $(this).parent();
        back_fs = $(this).parent().prev();

        $('#progressbar li').eq($('fieldset').index(current_fs)).removeClass('active');
        $('#step4').hide();
        $('#step3').show();
        window.scrollTo(0, 0);
    });
    
    /******* Step 04 *******/
    $('#stepfour').click(function () {
        disableStepFourButton();
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $('#progressbar').hide();

        if (v.form()) {

            let order_details = {
                user_id: user_id,
                order_id: order_id,
                bottle: 'unknown',
                address: $('#shipping_address').val(),
                city: $('#shipping_city').val(),
                state: $('#shipping_state').val(),
                zip: $('#shipping_zip').val()
            };

            let url = 'https://app.zipcodebase.com/api/v1/search?apikey=db77c0e0-1412-11ec-b94c-d7d64df96ac4&codes=' + order_details.zip + '&country=us';
            ajaxCall('GET', url, 'json', [], function (response) {
                if (response.results[order_details.zip]) {
                    ajaxCall('POST', '/api/vimerson/create/order', 'json', order_details, function (onSuccess) {
                        if (onSuccess.status) {
                            // submit timetracker
                            let tracker_data = {
                                user_id: user_id,
                                form_id: form_id,
                                step_four_time: time_step_four
                            }

                            ajaxCall('POST', '/api/vimerson/step/form/timetracker', 'json', tracker_data);
                            clearInterval(step_four)

                            $('input', '#step5').removeClass('ignore');
                            $('#progressbar li').eq($('fieldset').index(next_fs)).addClass('active');
                            $('#step4').hide();
                            $('#step5').show();
                            window.scrollTo(0, 0);
                            
                            let qualified_bottles_data = { user_id: user_id, order_id: order_id, bottle_ids: bottle_ids };
                            ajaxCall('POST', '/api/vimerson/add/qualified/bottles', 'json', qualified_bottles_data);

                            let shop_order_data = { user_id: user_id, order_id: order_id, variant_ids: variant_ids, customer_data: customer_data, shipping_address: shipping_address };
                            ajaxCall('POST', '/api/vimerson/create/shopify/order', 'json', shop_order_data);
                            
                            /* let email_data = { user_id: user_id, bottle_ids: bottle_ids };
                            ajaxCall('POST', '/api/vimerson/send/email', 'json', email_data); */
                            // startFive();
                        }
                    });
                } else {
                    enableStepFourButton();
                    alert('Please provide a valid US zipcode')
                }
            }, false)
        } else {
            enableStepFourButton();
        }
    });

    $('#back4').click(function () {
        clearInterval(step_five); startFour();

        $('input', '#step5').addClass('ignore');

        current_fs = $(this).parent();
        back_fs = $(this).parent().prev();

        $('#progressbar li').eq($('fieldset').index(current_fs)).removeClass('active');
        $('#step5').hide();
        $('#step4').show();
        window.scrollTo(0, 0);
    });

    /******* Step 05 *******/
    /* $('#stepfive').click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        if (v.form()) {

            // submit timetracker
            let tracker_data = {
                user_id: user_id,
                form_id: form_id,
                step_five_time: time_step_five
            }
            
            ajaxCall('POST', '/api/vimerson/step/form/timetracker', 'json', tracker_data);
            clearInterval(step_five)

            $('input', '#step6').removeClass('ignore');
            $('#progressbar li').eq($('fieldset').index(next_fs)).addClass('active');
            $('#step5').hide();
            $('#step6').show();
            window.scrollTo(0, 0);

            startSix();
        }
    });

    $('#stepsix').click(function () {
        
        if (v.form()) {

            // submit timetracker
            let tracker_data = {
                user_id: user_id,
                form_id: form_id,
                step_six_time: time_step_six
            }
            
            ajaxCall('POST', '/api/vimerson/step/form/timetracker', 'json', tracker_data);
            clearInterval(step_six);
            location.reload();
        }
    });

    $('#back5').click(function () {
        startFive();

        $('input', '#step6').addClass('ignore');

        current_fs = $(this).parent();
        back_fs = $(this).parent().prev();

        $('#progressbar li').eq($('fieldset').index(current_fs)).removeClass('active');
        $('#step6').hide();
        $('#step5').show();
        window.scrollTo(0, 0);
    }); */

    /******* Rating *******/
    $('#stars li').on('mouseover', function () {
        var onStar = parseInt($(this).data('value'), 10);

        $(this).parent().children('li.star').each(function (e) {
            if (e < onStar) $(this).addClass('hover');
            else $(this).removeClass('hover');
        });
    }).on('mouseout', function () {
        $(this).parent().children('li.star').each(function (e) {
            $(this).removeClass('hover');
        });
    });

    $('#stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li.star');
        selected_star = onStar;

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
    });

    $('#popup_amazon_feedback').on('click', function () {
        let feedback = $('#feedback').val();

        if (selected_star >= 1) $('.modal-body #stars li[data-value="1"]').addClass('selected');
        if (selected_star >= 2) $('.modal-body #stars li[data-value="2"]').addClass('selected');
        if (selected_star >= 3) $('.modal-body #stars li[data-value="3"]').addClass('selected');
        if (selected_star >= 4) $('.modal-body #stars li[data-value="4"]').addClass('selected');
        if (selected_star >= 5) $('.modal-body #stars li[data-value="5"]').addClass('selected');

        if (feedback == '' || feedback.length < 50) alert('Please make your feedback longer (50 characters minimum)');
        else {
            $('#amazon_feedback').val(feedback);
            $('#popup_feedback').modal('show');
        }
    });
});

/** phone number validation in proper format */
jQuery.validator.addMethod('phoneUS', function (phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, '');
    /* return this.optional(element) || phone_number.length > 9 && */
    return phone_number.match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})?[-]?\2([0-9]{4})/);
}, 'Please enter a valid phone number');

/** email validation with proper domain */
jQuery.validator.addMethod('emailordomain', function (value, element) {
    return this.optional(element) || /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(value) || /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/.test(value);
}, 'Please enter the correct email');

// validate us zipcode
jQuery.validator.addMethod('zipcodeUS', function (value, element) {
    let url = 'https://app.zipcodebase.com/api/v1/search?apikey=db77c0e0-1412-11ec-b94c-d7d64df96ac4&codes=' + value + '&country=us';
    ajaxCall('GET', url, 'json', [], function (response) {
        return response.results[value] ? true : false
    }, false)
}, 'Please provide a valid and US zipcode.');

// validate form on keyup and submit
var v = jQuery('#form').validate({
    ignore: '.ignore',
    errorClass: 'error',
    validClass: 'valid-input',
    rules: {
        first_name: 'required',
        last_name: 'required',
        email: {
            required: true,
            emailordomain: true
        },
        phone_number: {
            required: true,
            phoneUS: true
        },
        order_id: 'required',
        feedback: {
            required: true,
            minlength: 50
        },
        shipping_name: 'required',
        shipping_last_name: 'required',
        shipping_address: 'required',
        shipping_city: 'required',
        shipping_state: 'required',
        shipping_zip: {
            required: true,
            minlength: 5,
            maxlength: 5,
            // zipcodeUS: true
        },
        shipping_phone: {
            required: true,
            required: true,
            phoneUS: true
        }
        // asinID: 'required',
    },
    messages: {
        first_name: {
            required: "Please enter first name",
        },
        last_name: {
            required: "Please enter last name",
        },
        phone_number: {
            required: "Please enter phone number",
            digits: "Please enter valid phone number",
            minlength: "Phone number field accept only 10 digits",
            maxlength: "Phone number field accept only 10 digits",
        },
        email: {
            required: "Please enter email address",
            email: "Please enter a valid email address.",
        },
    },
    submitHandler: function (form) {
        var formData = new FormData(form);
        //e.preventDefault();
        $('#loader-overlay-message').show();
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == 'success') {
                    $('#loader-overlay-message').hide();
                    $('#sucess-msg').show();
                }
                if (data == 'error') {
                    $('#loader-overlay-message').hide();
                    $('#error-msg').show();
                }

            },
            error: function () { }
        });

        //return false;  //This doesn't prevent the form from submitting.
    },
    highlight: function (element, errorClass) {
        // window.scrollTo(0, 0);        
    },
    unhighlight: function (element, errorClass) {
        //$(element).closest('.form-group').removeClass('has-error');
    },
});

/** number-only */
$('.number-only').keypress(function (e) {
    if (isNaN(this.value + "" + String.fromCharCode(e.charCode))) return false;
}).on("paste", function (e) {
    e.preventDefault();
});

$('#feedback').on('keyup', function () {
    $('#feedback-count').html(this.value.length);
});

$('#publish_to_amazon').on('click', function () {
    hidePopupAndEnableButton();
});

/** phone inputmask */
$('#phone_number').inputmask({ 'mask': '(999) 999-9999' });
$('#shipping_phone').inputmask({ 'mask': '(999) 999-9999' });

/** OrderID inputmask */
$('#order_id').inputmask({ 'mask': '999-9999999-9999999' });

/** error message */
function showErrorMessage(message) {
    $('.amazon-order-error p').html(message);
    $('.amazon-order-error').show();
}

/** disable step four button */
function disableStepFourButton() {
    $('#stepfour').attr('disabled', true);
}

/** enable step four button */
function enableStepFourButton() {
    $('#stepfour').attr('disabled', false);
}

/** genrate random number (timestamp) */
function generateRandomNumber() {
    return new Date().valueOf();
}

/** set customer data */
function setCustomerData() {
    customer_data = {
        first_name: user_data.first_name ? user_data.first_name : '',
        last_name: user_data.last_name ? user_data.last_name : '',
        email: user_data.email ? user_data.email : ''
    }
}

/** set shipping address */
function setShippingAddress() {
    let first_name = user_data.first_name ? user_data.first_name : '';
    let last_name = user_data.last_name ? user_data.last_name : '';
    let phone_number = user_data.phone_number ? user_data.phone_number : '';
    let address1 = shipping_details.ShippingAddress.AddressLine1 ? shipping_details.ShippingAddress.AddressLine1 : '';
    let city = shipping_details.ShippingAddress.AddressLine1 ? shipping_details.ShippingAddress.AddressLine1 : '';
    let zip = shipping_details.ShippingAddress.PostalCode.split('-')[0] ? shipping_details.ShippingAddress.PostalCode.split('-')[0] : '';
    let province = shipping_details.ShippingAddress.StateOrRegion ? shipping_details.ShippingAddress.StateOrRegion : '';
    let country = shipping_details.ShippingAddress.CountryCode ? shipping_details.ShippingAddress.CountryCode : '';
    let country_code = country;
    let province_code = province;

    shipping_address = {
        first_name: first_name,
        last_name: last_name,
        name: first_name + ' ' + last_name,
        phone: phone_number,
        address1: address1,
        city: city,
        zip: zip,
        province: province,
        country: country,
        country_code: country_code,
        province_code: province_code
    }
}

function ajaxCall(method, url, dataType, data = {}, successCallback, loader = true) {
    $('#error-msg').hide();
    $.ajax({
        type: method,
        url: url,
        dataType: dataType,
        data: data,
        beforeSend: function () {
            if (loader) {
                $('.loader-overlay').show();
                $('body').addClass('overflow');
            }
        },
        complete: function () {
            if (loader) {
                $('.loader-overlay').hide();
                $('body').removeClass('overflow');
            }
        },
        success: successCallback,
        error: function (error) {
            let err_msg = JSON.parse(error.responseText).message;

            if (Array.isArray(err_msg)) {
                for (let i = 0; i < err_msg.length; i++) {
                    if (err_msg[i].match(/stars field/g) || err_msg[i].match(/stars must be/g)) $('#stars-error').show(); $('#stars-error').html('Please rate your experience of using the product you bought by clicking on the stars above');
                    if (err_msg[i].match(/feedback field/g) || err_msg[i].match(/feedback must be/g)) $('#feedback-error').show(); $('#feedback-error').html(err_msg[i]);
                    if (err_msg[i].match(/bottle ids field/g)) $('#bottle-error').show(); $('#bottle-error').html('Please select which product you’d like by clicking on the image');
                    if (err_msg[i].match(/feedback longer/g)) $('#feedback-error').show(); $('#feedback-error').html('Please make your feedback longer (50 characters minimum)');
                }
            }

            $('#error-msg').show(); $('#error-msg .fs-subtitle').html(err_msg);
        }
    });
}

function startOne() {
    step_one = setInterval(function () { time_step_one++; }, 1000);
}

function startTwo() {
    step_two = setInterval(function () { time_step_two++; }, 1000);
}

function startThree() {
    step_three = setInterval(function () { time_step_three++; }, 1000);
}

function startFour() {
    step_four = setInterval(function () { time_step_four++; }, 1000);
}

/* function startFive() {
    step_five = setInterval(function() {time_step_five++;}, 1000);
}

function startSix() {
    step_six = setInterval(function() {time_step_six++;}, 1000);
} */

function hidePopupAndEnableButton() {
    let popup_interval = setInterval(function () {
        $('#popup_feedback').modal('hide');
        $('#stepthree').attr('disabled', false);
        clearInterval(popup_interval);
    },
        3000);
}

/** US States */
var usStates = [
    { name: 'Alabama', abbreviation: 'AL' },
    { name: 'Alaska', abbreviation: 'AK' },
    { name: 'Arizona', abbreviation: 'AZ' },
    { name: 'Arkansas', abbreviation: 'AR' },
    { name: 'California', abbreviation: 'CA' },
    { name: 'Colorado', abbreviation: 'CO' },
    { name: 'Connecticut', abbreviation: 'CT' },
    { name: 'Delaware', abbreviation: 'DE' },
    { name: 'Florida', abbreviation: 'FL' },
    { name: 'Georgia', abbreviation: 'GA' },
    { name: 'Hawaii', abbreviation: 'HI' },
    { name: 'Idaho', abbreviation: 'ID' },
    { name: 'Illinois', abbreviation: 'IL' },
    { name: 'Indiana', abbreviation: 'IN' },
    { name: 'Iowa', abbreviation: 'IA' },
    { name: 'Kansas', abbreviation: 'KS' },
    { name: 'Kentucky', abbreviation: 'KY' },
    { name: 'Louisiana', abbreviation: 'LA' },
    { name: 'Maine', abbreviation: 'ME' },
    { name: 'Maryland', abbreviation: 'MD' },
    { name: 'Massachusetts', abbreviation: 'MA' },
    { name: 'Michigan', abbreviation: 'MI' },
    { name: 'Minnesota', abbreviation: 'MN' },
    { name: 'Mississippi', abbreviation: 'MS' },
    { name: 'Missouri', abbreviation: 'MO' },
    { name: 'Montana', abbreviation: 'MT' },
    { name: 'Nebraska', abbreviation: 'NE' },
    { name: 'Nevada', abbreviation: 'NV' },
    { name: 'New Hampshire', abbreviation: 'NH' },
    { name: 'New Jersey', abbreviation: 'NJ' },
    { name: 'New Mexico', abbreviation: 'NM' },
    { name: 'New York', abbreviation: 'NY' },
    { name: 'North Carolina', abbreviation: 'NC' },
    { name: 'North Dakota', abbreviation: 'ND' },
    { name: 'Northern Mariana Islands', abbreviation: 'MP' },
    { name: 'Ohio', abbreviation: 'OH' },
    { name: 'Oklahoma', abbreviation: 'OK' },
    { name: 'Oregon', abbreviation: 'OR' },
    { name: 'Palau', abbreviation: 'PW' },
    { name: 'Pennsylvania', abbreviation: 'PA' },
    { name: 'Rhode Island', abbreviation: 'RI' },
    { name: 'South Carolina', abbreviation: 'SC' },
    { name: 'South Dakota', abbreviation: 'SD' },
    { name: 'Tennessee', abbreviation: 'TN' },
    { name: 'Texas', abbreviation: 'TX' },
    { name: 'Utah', abbreviation: 'UT' },
    { name: 'Vermont', abbreviation: 'VT' },
    { name: 'Virginia', abbreviation: 'VA' },
    { name: 'Washington', abbreviation: 'WA' },
    { name: 'West Virginia', abbreviation: 'WV' },
    { name: 'Wisconsin', abbreviation: 'WI' },
    { name: 'Wyoming', abbreviation: 'WY' }
];

var stateSelect = document.getElementById('shipping_state');

for (var i = 0; i < usStates.length; i++) {
    var option = document.createElement("option");
    option.text = usStates[i].name;
    option.value = usStates[i].abbreviation;
    stateSelect.add(option);
}

$(document).ready(function () {
    let show_intercom_popup = setInterval(() => {
        $('.intercom-message').show();
        clearInterval(show_intercom_popup);
    }, 1500);

    // hide intercom help after 10 seconds
    let hide_intercom_popup = setInterval(() => {
        $('.intercom-message').hide();
        clearInterval(hide_intercom_popup);
    }, 10000);

    $('.intercom-message').click(function () {
        $('.intercom-message').hide();
    })
    Intercom('trackEvent', 'invited-friend');

    Intercom('onShow', function () {
        $('.intercom-message').hide();
    });
});
