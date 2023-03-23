(function ($) {
    $(document).ready(function () {

      var url = action_url_ajax.ajax_url;

        // start aci card form

        $("#aci_card_form").submit(function (e) {
            e.preventDefault();
            var url = action_url_ajax.ajax_url;
            var form = $("#aci_card_form");
            $("#aci_card_form .error").html('');
             $(".aci_submit_btn").val('Invia...');
            $.ajax({
                url: url,
                data: form.serialize() + '&action=' + 'aci_card_form_action' + '&param=' + 'form_data',
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    if (data.error == true) {
                        if (data.check == true) {
                            $.each(data.message, function (key, value) {
                                $(".error_usr_" + value[0]).html(value[1]);
                                $("#aci_form_messgae").addClass('msg_m');
                                 $(".aci_submit_btn").val('Invia');
                            });
                        }
                    } else {
                        $("#aci_form_messgae").html(data.message);
                        $("#aci_form_messgae").addClass('msg_m');
                         $(".aci_submit_btn").val('Invia');
                    }
                }
            });
        })

        // start card search 
        $("#card_items_search").on('keyup', function () {
            var input_value = $(this).val();
            var input_value_length = input_value.length;

            var page = $(this).attr('href');
            var get_site_url = $(".site_main_url").attr('setup_site_url');
            window.history.pushState("", "", page);


            if (input_value_length > 0) {
                $.ajax({
                    url: url,
                    data: {
                        action: 'card_items_search',
                        input_value: input_value,
                        page_url: page,
                        get_site_url: get_site_url,
                    },
                    type: 'post',
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.results.error == true) {
                            $(".ajax_cards_load").html(data.results.message);
                            $(".load_card_ajax_pagi").html('');
                        } else {
                            $(".ajax_cards_load").html(data.results.post_items);
                           $(".load_card_ajax_pagi").html(data.results.pagination);
                        }

                    },
                });
            } else {
                $.ajax({
                    url: url,
                    data: {
                        action: 'card_items_search',
                        input_value: input_value,
                        page_url: page,
                        get_site_url: get_site_url,
                    },
                    type: 'post',
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.error == true) {
                            $(".ajax_cards_load").html(data.results.message);
                            $(".load_card_ajax_pagi").html('');
                        } else {
                            $(".ajax_cards_load").html(data.results.post_items);
                            $(".load_card_ajax_pagi").html(data.results.pagination);
                        }
                    },
                });
            }
        });
        // end card search 

        // start card pagination 
        $("body").delegate('.aci_card_pagi .page-numbers', 'click', function (event) {
            event.preventDefault();
            var page = $(this).attr('href');
            var get_site_url = $(".site_main_url").attr('setup_site_url');
            window.history.pushState("", "", page);
            $.ajax({
                url: url,
                data: {
                    action: 'aci_card_pagi_action',
                    page_url: page,
                    get_site_url: get_site_url,
                },
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    $(".ajax_cards_load").html(data.results.post_items);
                    $(".load_card_ajax_pagi").html(data.results.pagination);
                },
            });
        });
        // end card pagination 

      
      
      
          });
})(jQuery)

