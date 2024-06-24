let check_diff = [];

jQuery(document).ready(function () {

    /*---------------------------------------------------------------------
    Tooltip
    -----------------------------------------------------------------------*/
    jQuery('[data-toggle="tooltip"]').tooltip();

    /*---------------------------------------------------------------------
      dropify
    -----------------------------------------------------------------------*/
    $('.dropify').dropify();

    /*---------------------------------------------------------------------
    Fixed Nav
    -----------------------------------------------------------------------*/
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 0) {
            $('.vh-top-navbar').addClass('fixed');
        } else {
            $('.vh-top-navbar').removeClass('fixed');
        }
    });

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 0) {
            $('.white-bg-menu').addClass('sticky-menu');
        } else {
            $('.white-bg-menu').removeClass('sticky-menu');
        }
    });

    /*---------------------------------------------------------------------
    Page Menu
    -----------------------------------------------------------------------*/
    jQuery(document).on('click', '.wrapper-menu', function () {
        jQuery(this).toggleClass('open');
    });

    jQuery(document).on('click', ".wrapper-menu", function () {
        jQuery("body").toggleClass("sidebar-main");
    });

    /*---------------------------------------------------------------------
     Close  navbar Toggle
     -----------------------------------------------------------------------*/

    jQuery('.close-toggle').on('click', function () {
        jQuery('.h-collapse.navbar-collapse').collapse('hide');
    });

    /*---------------------------------------------------------------------
    Data tables
    -----------------------------------------------------------------------*/
    if ($.fn.DataTable) {
        const table = $('.data-table').DataTable({
            'lengthMenu': [25, 50, 75, 100],
            scrollY: '44.5vh',
            scrollCollapse: true,
            paging: true,
            fixedColumns: false,
            'simple': 'simple_numbers'
        });
    }


    /*---------------------------------------------------------------------
    Form Validation
    -----------------------------------------------------------------------*/

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    /*---------------------------------------------------------------------
    Scrollbar
    -----------------------------------------------------------------------*/

    jQuery('.data-scrollbar').each(function () {
        var attr = $(this).attr('data-scroll');
        if (typeof attr !== typeof undefined && attr !== false) {
            let Scrollbar = window.Scrollbar;
            var a = jQuery(this).data('scroll');
            Scrollbar.init(document.querySelector('div[data-scroll= "' + a + '"]'));
        }
    });

    /*---------------------------------------------------------------------
        dark mode
      -----------------------------------------------------------------------*/
    const urlParams = new URLSearchParams(window.location.search);
    const mode = urlParams.get('dark');
    if (mode !== null) {
        $('body').removeClass('sidebar-dark', 'sidebar-light')
        switch (mode) {
            case "true":
                $('body').addClass('dark')
                break;
            case "false":
                $('body').removeClass('sidebar-dark', 'sidebar-light')
                break;
            default:
                $('body').removeClass('sidebar-dark').removeClass('sidebar-light')
                break;
        }
    }

    const storageDark = localStorage.getItem('dark')
    if ($('body').hasClass('dark')) {
        changeMode('true');
    } else {
        changeMode('false');
    }
    if (storageDark !== 'null') {
        changeMode(storageDark)
    }
    jQuery(document).on("change", '.change-mode input[type="checkbox"]', function (e) {
        const dark = $(this).attr('data-active');
        if (dark === 'true') {
            $(this).attr('data-active', 'false')
        } else {
            $(this).attr('data-active', 'true')
        }
        changeMode(dark)
    })

    function changeMode(dark) {
        const body = jQuery('body')
        if (dark === 'true') {
            // $('[data-mode="toggle"]').find('i.a-right').removeClass('ri-sun-line');
            // $('[data-mode="toggle"]').find('i.a-left').addClass('ri-moon-clear-line');
            $('#dark-mode').prop('checked', true).attr('data-active', 'false')
            $('.darkmode-logo').removeClass('d-none')
            $('.light-logo').addClass('d-none')
            body.addClass('dark')
            dark = true
        } else {
            // $('[data-mode="toggle"]').find('i.a-left').removeClass('ri-moon-clear-line');
            // $('[data-mode="toggle"]').find('i.a-right').addClass('ri-sun-line');
            $('#dark-mode').prop('checked', false).attr('data-active', 'true');
            $('.light-logo').removeClass('d-none')
            $('.darkmode-logo').addClass('d-none')
            body.removeClass('dark')
            dark = false
        }
        updateLocalStorage(dark)
        const event = new CustomEvent("ChangeColorMode", {
            detail: {
                dark: dark
            }
        });
        document.dispatchEvent(event);
    }

    function updateLocalStorage(dark) {
        localStorage.setItem('dark', dark)
    }

    // set sidebar active class
    let highlighted_menu_class = 'active';
    let current_side = '.sidebar-' + window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
    let sidebar_li = $('.side-menu');
    sidebar_li.removeClass(highlighted_menu_class);
    sidebar_li.find(current_side).addClass(highlighted_menu_class);

    $('#bottle_ids_dropdown').select2({
        width: '100%',
        placeholder: 'Select bottles',
    })

    $('#fetch_bottle_details').click(function () {
        fetchProducInfo();
    })

    $('#bottle_ids_dropdown').on('select2:close', function (e) {
        showProducBottles()
    });

    // dragable images
    var dropIndex;
    $('.selected_bottles').sortable({
        update: function (event, ui) {
            dropIndex = ui.item.index();
            reSortSelectedBottlesValue()
        }
    });
});

/*---------------------------------------------------------------------
      Amazon Popup
-----------------------------------------------------------------------*/
jQuery(function ($) {

    $('#allow_amazon_popup').on('change', function () {
        let url = 'api/vimerson/handle/amazon/popup';
        ajaxCall('POST', url, 'json', { amazon_popup: this.checked })
    });

    /* $('#bottle_ids_dropdown').change(function () {
        console.log(this.value);
    }); */
});

function deleteBottle(id) {
    let url = '/api/vimerson/delete/bottle';
    ajaxCall('POST', url, 'json', { id: id }, function (response) {
        if (response.status) {
            alert(response.message);
            window.location = '/admin/bottle';
        } else alert(response.message);
    })
}

function deleteProduct(id) {
    let url = '/api/vimerson/delete/product';
    ajaxCall('POST', url, 'json', { id: id }, function (response) {
        if (response.status) {
            alert(response.message);
            window.location = '/admin/product';
        } else alert(response.message);
    })
}

function reSortSelectedBottlesValue() {
    let sortable_bottles = [];
    $('.selected_bottles').find('img').map(function () {
        sortable_bottles.push($(this).attr('data-id'));
    })
    if (sortable_bottles) $('input#sortable_bottles').val(sortable_bottles)
}

function fetchProducInfo(selected = false) {
    let url = '/api/vimerson/bottle/by/asin';
    let asin = $('#product_asin_number').val();
    resetProductFields();
    if (asin) {
        ajaxCall('POST', url, 'json', { asin: asin, selected_items: selected }, function (onSuccess) {
            if (onSuccess.status_code == 200) {
                $('#bottle_variant_id').val(onSuccess.data.bottle_info.variant_id);
                $('#bottle_name').val(onSuccess.data.bottle_info.name);

                setImageDropify(onSuccess.data.bottle_info.image)

                reArrageSelectedBottles(onSuccess.data.bottle_list, onSuccess.data.selected_values);
                if (selected) showProducBottles(onSuccess.data.selected_values)
            }
        }, function (error) {
            alert(error.responseJSON.message)
        })
    } else {
        alert('ASIN field is required.');
    }
}

// set dropify image
function setImageDropify(image_src) {
    let image = window.location.origin + '/bottle/' + image_src;
    let bottle_image = $('#bottle_image');
    let wrapper = bottle_image.closest('.dropify-wrapper');
    let preview = wrapper.find('.dropify-preview');
    let render = wrapper.find('.dropify-render').html('');
    
    bottle_image.attr('disabled', true);
    render
        .append($('<img />')
        .attr('src', image)        
        .css('max-height', bottle_image.data('height') || ''));
    preview.fadeIn();
}

// set bottle image
function setBottleImage(image_src) {
    $('.dropify').dropify();
    let image = window.location.origin + '/bottle/' + image_src;
    let bottle_image = $('#image');
    let wrapper = bottle_image.closest('.dropify-wrapper');
    let preview = wrapper.find('.dropify-preview');
    let render = wrapper.find('.dropify-render').html('');
    
    render
        .append($('<img />')
        .attr('src', image)        
        .css('max-height', bottle_image.data('height') || ''));
    preview.fadeIn();
}

// re arrage select 2 values
function reArrageSelectedBottles(data = false, values = false) {
    $('#bottle_ids_dropdown').select2({
        width: '100%',
        placeholder: 'Select bottles',
        allowClear: true,
        closeOnSelect: false,
        multiple: true,
        data: data
    }).val(values).trigger('change');
}

function showProducBottles(ids) {
    // let data = $('#bottle_ids_dropdown').select2('val');
    if (ids && JSON.stringify(check_diff) != JSON.stringify(ids)) {
        $('.selected_bottles').html('')
        let url = '/api/vimerson/bottle/images?type=html'
        ajaxCall('POST', url, 'html', { id: ids }, function (onSuccess) {
            $('.selected_bottles').html(onSuccess)
            check_diff = ids;
            reSortSelectedBottlesValue()
        })
    }
}

function resetProductFields() {
    $('#bottle_variant_id').val('');
    $('#bottle_name').val('');
}

function ajaxCall(method, url, dataType, data = {}, /* beforeSendCallBack, completeCallBack,  */ successCallback, errorCallback) {
    $('#error-msg').hide();
    $.ajax({
        type: method,
        url: url,
        dataType: dataType,
        data: data,
        beforeSend: function () {
            $('#allow_amazon_popup').attr('disabled', true);
        },
        complete: function () {
            $('#allow_amazon_popup').removeAttr('disabled');
        },
        success: successCallback,
        error: errorCallback
    });
}
