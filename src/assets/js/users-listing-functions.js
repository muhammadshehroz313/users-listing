jQuery(document).ready(function () {

    var ajax_nonce = users_listing_plugin_vars.nonce;
    jQuery(document).on('click', '.fetch-user-detail', function () {
        var _this = jQuery(this),
          _result, _html, _address,
          _popup_model_selector = jQuery('#user-detail-model'),
          _background_selector = jQuery(".user-detail-background"),
          _user_id = _this.attr('data-user-id');

        jQuery.ajax({
            type: 'POST',
            url: users_listing_plugin_vars.action,
            async: true,
            data: {
                user_id: _user_id,
                action: 'users_listing_get_user_detail',
                _ajax_nonce: ajax_nonce
            },
            datatype: 'json',
            beforeSend: function () {
                _background_selector.removeClass('hidden');
                _popup_model_selector.find("table").find('tbody').html('');
            },
            success: function (result) {

                _result = '';
                _result = JSON.parse(result);

                if (undefined != _result.res) {
                    _popup_model_selector.find(".modal-body .user-details").show();
                    _address = `${_result.res.address.suite} - ${_result.res.address.street} - ${_result.res.address.city} - ${_result.res.address.zipcode}`;
                    jQuery("#name").text(_result.res.name);
                    jQuery("#email").text(_result.res.email);
                    jQuery("#phone").text(_result.res.phone);
                    jQuery("#company_name").text(_result.res.company.name);
                    jQuery("#website").text(_result.res.website);
                    jQuery("#address").text(_address);
                    ajax_nonce = _result.new_nonce;
                } else {
                    _html = _result.message;
                    _popup_model_selector.find(".modal-body .user-details").hide();
                    _popup_model_selector.find(".modal-body .msg").append(_html);
                }
                // Display Modal
                setTimeout(function () {
                    _background_selector.addClass('hidden');
                    _popup_model_selector.modal('show');
                }, 100)
            },
            error: function (jqXHR, exception) {
                var _msg = '';
                if (jqXHR.status === 0) {
                    _msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    _msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    _msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    _msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    _msg = 'Time out error.';
                } else if (exception === 'abort') {
                    _msg = 'Ajax request aborted.';
                } else {
                    _msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }

                _popup_model_selector.find(".modal-body .user-details").hide();
                _popup_model_selector.find(".modal-body .msg").append(_msg);
                _background_selector.addClass('hidden');
                _popup_model_selector.modal('show');
            }
        });
    });
    jQuery(document).on('hide.bs.modal','#user-detail-model', function () {
        jQuery('.modal-el').text('');
    });
});

