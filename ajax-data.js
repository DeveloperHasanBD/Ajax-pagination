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
        
        // filter by post status 
        $("body").delegate('.post_status li', 'click', function () {
            var bp_post_status = $(this).attr('bp_post_status');
            var get_site_url = $(".watch_site_url").attr('setup_site_url');
            var get_luser_id = $(".get_luser_id").val();
            var origin_site_url = $(location).attr('origin')
            window.history.pushState("", "", origin_site_url + '/watch/alimentazione-articoli/');

            $.ajax({
                url: url,
                data: {
                    action: 'usr_filter_by_status',
                    bp_post_status: bp_post_status,
                    get_site_url: get_site_url,
                    get_luser_id: get_luser_id,
                },
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    if (data.results.error == true) {
                        $(".dashbrd_post_grid_items").html(data.results.message);
                    } else {
                        $(".dashbrd_post_grid_items").html(data.results.post_tems);
                    }
                    $(".load_cat_ajax_pagi").html(data.results.pagination);
                },
            });
        });
        // end filter by post status 
      
      
        $("body").delegate('.usr_status_pagi .page-numbers', 'click', function (event) {
            event.preventDefault();
            var page = $(this).attr('href');
            var get_site_url = $(".watch_site_url").attr('setup_site_url');
            var post_status_name = $(".post_status li.active").attr('bp_post_status');
            var get_luser_id = $(".get_luser_id").val();
            window.history.pushState("", "", page);
            $.ajax({
                url: url,
                data: {
                    action: 'usr_status_pagi',
                    page_url: page,
                    get_site_url: get_site_url,
                    post_status_name: post_status_name,
                    get_luser_id: get_luser_id,
                },
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    if (data.results.error == true) {
                        $(".dashbrd_post_grid_items").html(data.results.message);
                    } else {
                        $(".dashbrd_post_grid_items").html(data.results.post_tems);
                    }
                    $(".load_cat_ajax_pagi").html(data.results.pagination);
                },
            });
        });
        // start blog post cat filter 
      
          });
})(jQuery)

