
function card_items_search()
{

    $page_url = $_POST['page_url'];
    $get_site_url = $_POST['get_site_url'];

    $get_num = explode('/', $page_url);

    $final_num = [];
    foreach ($get_num as $single_item) {
        if ($single_item != '') {
            $final_num[] = $single_item;
        }
    }

    $last_val = end($final_num);
    $set_num = 1;

    if (is_numeric($last_val)) {
        $set_num = $last_val;
    } else {
        $set_num = 1;
    }

    $paged = get_query_var("page") ? get_query_var("page") : $set_num;
    $posts_per_page = 12;



    $input_value = $_POST['input_value'] ?? '';

    $upost_args = array(
        'post_type'         => 'cards',
        'posts_per_page'    => $posts_per_page,
        'paged'             => $paged,
        's'                 => $input_value,
    );

    $upost_query = new WP_Query($upost_args);

    $post_items     = '';
    $error          = '';
    if ($upost_query->have_posts()) {
        while ($upost_query->have_posts()) {
            $upost_query->the_post();

            $get_the_id =   get_the_ID();
            $card_title =   get_the_title();

            $get_thumbnail_url = '';
            if (get_the_post_thumbnail_url()) {
                $get_thumbnail_url = get_the_post_thumbnail_url();
            } else {
                $get_thumbnail_url = get_template_directory_uri() . '/assets/images/bg.jpg';
            }

            $get_icons_text = '';
            if (have_rows('crd_icon_and_text')) {
                while (have_rows('crd_icon_and_text')) : the_row();
                    $aci_crd_icon = get_sub_field('aci_crd_icon');
                    $aci_crd_text = get_sub_field('aci_crd_text');
                    $get_icons_text .= '<div class="card_single_icon"> <img src="' . $aci_crd_icon . '" alt="">' . $aci_crd_text . '</div>';
                endwhile;
            }

            $crd_price_top_text     = get_field('crd_price_top_text');
            $crd_price              = get_field('crd_price');
            $crd_price_bottom_text  = get_field('crd_price_bottom_text');
            $crds_notes             = get_field('crds_notes');

            $post_items .= '
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="aci_travel_card_item">
                        <div class="aci_travel_card_innr" style="background-image: url(' . $get_thumbnail_url . ');">
                            <div class="aci_card_top">
                                <h2>' . $card_title . '</h2>
                                <div class="card_icons">
                                    
                                        ' . $get_icons_text . '
                                    
                                </div>
                                <button class="acr_travel_request" travel_card_id="' . $get_the_id . '">Richiedi Viaggio </button>
                            </div>
                            <div class="aci_card_bottom">
                                <div class="price">
                                    <span class="start_from">' . $crd_price_top_text . '</span>
                                    <span class="amt">' . $crd_price . ' €</span>
                                    <span class="to_present">' . $crd_price_bottom_text . '</span>
                                </div>
                            </div>
                        </div>
                        <div class="destination">
                            ' . $crds_notes . '
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        $error = true;
    }
    $message = '';
    $message                .= '<p class="msg_display">Nessun post trovato</p>';

    $pagination = array(
        'base' => home_url('/%_%'),
        'current'       => $paged,
        'total'         => $upost_query->max_num_pages,
        'prev_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/arrow-left.svg>',
        'next_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/arrow-right.svg>',
    );
    $set_cat_pagi = '<div class="aci_cards_pagination aci_card_pagi">' . paginate_links($pagination) . '</div>';



    $response['results']    = array(
        'post_items'        => $post_items,
        'error'             => $error,
        'pagination'        => $set_cat_pagi,
        'message'           => $message,
    );
    echo  json_encode($response);

    die;
}

add_action('wp_ajax_card_items_search', 'card_items_search');
add_action('wp_ajax_nopriv_card_items_search', 'card_items_search');


function aci_card_pagi_action()
{
    $page_url = $_POST['page_url'];
    $get_site_url = $_POST['get_site_url'];

    $get_num = explode('/', $page_url);

    $final_num = [];
    foreach ($get_num as $single_item) {
        if ($single_item != '') {
            $final_num[] = $single_item;
        }
    }

    $last_val = end($final_num);
    $set_num = 1;

    if (is_numeric($last_val)) {
        $set_num = $last_val;
    } else {
        $set_num = 1;
    }

    $paged = get_query_var("page") ? get_query_var("page") : $set_num;
    $posts_per_page = 12;

    $upost_args = array(
        'post_type' => 'cards',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
    );

    $upost_query = new WP_Query($upost_args);

    $post_items     = '';
    $error          = '';
    if ($upost_query->have_posts()) {
        while ($upost_query->have_posts()) {
            $upost_query->the_post();

            $get_the_id =   get_the_ID();
            $card_title =   get_the_title();

            $get_thumbnail_url = '';
            if (get_the_post_thumbnail_url()) {
                $get_thumbnail_url = get_the_post_thumbnail_url();
            } else {
                $get_thumbnail_url = get_template_directory_uri() . '/assets/images/bg.jpg';
            }

            $get_icons_text = '';
            if (have_rows('crd_icon_and_text')) {
                while (have_rows('crd_icon_and_text')) : the_row();
                    $aci_crd_icon = get_sub_field('aci_crd_icon');
                    $aci_crd_text = get_sub_field('aci_crd_text');
                    $get_icons_text .= '<div class="card_single_icon"> <img src="' . $aci_crd_icon . '" alt="">' . $aci_crd_text . '</div>';
                endwhile;
            }

            $crd_price_top_text     = get_field('crd_price_top_text');
            $crd_price              = get_field('crd_price');
            $crd_price_bottom_text  = get_field('crd_price_bottom_text');
            $crds_notes             = get_field('crds_notes');

            $post_items .= '
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="aci_travel_card_item">
                        <div class="aci_travel_card_innr" style="background-image: url(' . $get_thumbnail_url . ');">
                            <div class="aci_card_top">
                                <h2>' . $card_title . '</h2>
                                <div class="card_icons">
                                    
                                        ' . $get_icons_text . '
                                    
                                </div>
                                <button class="acr_travel_request" travel_card_id="' . $get_the_id . '">Richiedi Viaggio </button>
                            </div>
                            <div class="aci_card_bottom">
                                <div class="price">
                                    <span class="start_from">' . $crd_price_top_text . '</span>
                                    <span class="amt">' . $crd_price . ' €</span>
                                    <span class="to_present">' . $crd_price_bottom_text . '</span>
                                </div>
                            </div>
                        </div>
                        <div class="destination">
                            ' . $crds_notes . '
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        $error = true;
    }

    $message                = '<p class="cat_msg_display">Nessun post trovato</p>';
    $pagination = array(
        'base' => home_url('/%_%'),
        'current'       => $paged,
        'total'         => $upost_query->max_num_pages,
        'prev_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/arrow-left.svg>',
        'next_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/arrow-right.svg>',
    );
    $set_cat_pagi = '<div class="aci_cards_pagination aci_card_pagi">' . paginate_links($pagination) . '</div>';


    $response['results']    = array(
        'post_items'        => $post_items,
        'error'             => $error,
        'pagination'        => $set_cat_pagi,
        'message'           => $message,
    );
    echo  json_encode($response);

    die;
}

add_action('wp_ajax_aci_card_pagi_action', 'aci_card_pagi_action');
add_action('wp_ajax_nopriv_aci_card_pagi_action', 'aci_card_pagi_action');


function usr_filter_by_status()
{
    session_start();
    global $wpdb;
    $rda_users                  = $wpdb->prefix . 'rda_users';
    $get_luser_id               = $_POST['get_luser_id'];

    $current_user = $wpdb->get_row("SELECT * FROM $rda_users WHERE id = {$get_luser_id}");

    $bp_post_status             = $_POST['bp_post_status'];
    $_SESSION['bp_post_status'] = $bp_post_status;

    $get_site_url               = $_POST['get_site_url'];
    $paged                      = 1;
    $posts_per_page             = 3;

    if ($bp_post_status) {
        $upost_args = array(
            'post_type'         => 'post',
            'post_status'       => $bp_post_status,
            'posts_per_page'    => $posts_per_page,
            'paged'             => $paged,
            'meta_query' => array(
                array(
                    'key'     => '_rda_artical_user_id',
                    'value'   => $get_luser_id,
                ),
            ),
        );
    } else {
        $upost_args = array(
            'post_type'         => 'post',
            'post_status'       => 'all',
            'posts_per_page'    => $posts_per_page,
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key'       => '_rda_artical_user_id',
                    'value'     => $get_luser_id,
                ),
            ),
        );
    }

    $upost_query                  = new WP_Query($upost_args);

    $post_items                   = '';
    $error = '';
    if ($upost_query->have_posts()) {
        while ($upost_query->have_posts()) {
            $upost_query->the_post();

            $usr_get_p_status   = get_post_status(get_the_ID());
            $set_not_clickable  = '';
            $set_target  = '';

            if ($usr_get_p_status == 'publish') {
                $set_target = 'target="_blank"';
            } else {
                $set_not_clickable = 'post_n_clickable';
            }
            $post_url = get_the_permalink();

            $bp_title = get_the_title();
            $pieces = explode(" ", $bp_title);
            $first_part = implode(" ", array_splice($pieces, 0, 8));
            $directory_uri = get_template_directory_uri();

            $user_name = $current_user->name ?? '';
            $user_img_id = $current_user->image ?? '';

            $set_user_img_url = '';
            if ($user_img_id) {
                $set_user_img_url = wp_get_attachment_url($user_img_id);
            } else {
                $set_user_img_url = $directory_uri . '/assets/images/default.png';
            }

            $set_thumbnail_url = '';
            if (get_the_post_thumbnail_url()) {
                $set_thumbnail_url = get_the_post_thumbnail_url();
            } else {
                $set_thumbnail_url = $directory_uri . '/assets/images/default.png';
            }

            $user_post_cat = get_the_terms(get_the_ID(), 'category');
            $cat_mane = '';
            foreach ($user_post_cat as $single_cat) {
                $cat_mane .= $single_cat->name . '<span> ,</span>';
            }

            $post_items .= '
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ' . $set_not_clickable . '">
                <div class="watch_single_item">
                    <a ' . $set_target . ' class="' . $set_not_clickable . '" href="' . $post_url . '"></a>
                    <div class="watch_single_item_normal">
                        <div class="watch_item_top">
                            <div class="watch_inner_top">
                                <h2>' . $cat_mane . '</h2>
                            </div>
                            <div class="watch_item_top_inner ">
                                <div class="watch_inner_bottom">
                                    <h3>' . $first_part . '</h3>
                                </div>
                                <div class="watch_inner_simg d-flex  align-items-center">
                                    <img src="' . $set_user_img_url . '" alt="">
                                    <p>' . $user_name . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="watch_item_bottm">
                            <img class="set_arrow" src="' . $directory_uri . '/assets/images/icons/wt-arrow-down.svg" alt="">
                            <img src="' . $set_thumbnail_url . '" alt="">
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        $error = true;
    }

    $pagination = array(
        'base' => home_url('/alimentazione-articoli/%_%'),
        'current'       => $paged,
        'total'         => $upost_query->max_num_pages,
        'prev_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/arrow-left.svg>',
        'next_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/FrecciaCustom.svg>',
    );
    $set_cat_pagi = '<div class="blog_item_pagination usr_status_pagi">' . paginate_links($pagination) . '</div>';

    $message                = '<p class="cat_msg_display">Nessun post trovato</p>';

    $response['results']    = array(
        'post_tems'         => $post_items,
        'pagination'        => $set_cat_pagi,
        'error'             => $error,
        'message'           => $message,
    );
    echo  json_encode($response);
    die;
}


add_action('wp_ajax_usr_filter_by_status', 'usr_filter_by_status');
add_action('wp_ajax_nopriv_usr_filter_by_status', 'usr_filter_by_status');



function usr_status_pagi()
{
    $page_url     = $_POST['page_url'];
    $get_site_url = $_POST['get_site_url'];
    $get_luser_id = $_POST['get_luser_id'];

    global $wpdb;
    $rda_users                  = $wpdb->prefix . 'rda_users';
    $current_user               = $wpdb->get_row("SELECT * FROM $rda_users WHERE id = {$get_luser_id}");

    $post_status_name           = $_POST['post_status_name'];
    $get_num                    = explode('/', $page_url);

    $final_num                  = [];
    
    foreach ($get_num as $single_item) {
        if ($single_item != '') {
            $final_num[] = $single_item;
        }
    }

    $last_val = end($final_num);
    $set_num = 1;

    if (is_numeric($last_val)) {
        $set_num = $last_val;
    } else {
        $set_num = 1;
    }

    $paged          = get_query_var("paged") ? get_query_var("paged") : $set_num;
    $posts_per_page = 3;

    if ($post_status_name) {
        $upost_args = array(
            'post_type' => 'post',
            'post_status' => $post_status_name,
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key'     => '_rda_artical_user_id',
                    'value'   => $get_luser_id,
                ),
            ),
        );
    } else {
        $upost_args = array(
            'post_type' => 'post',
            'post_status' => 'all',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key'     => '_rda_artical_user_id',
                    'value'   => $get_luser_id,
                ),
            ),
        );
    }
    $upost_query = new WP_Query($upost_args);

    $post_items                   = '';
    $error = '';
    if ($upost_query->have_posts()) {
        while ($upost_query->have_posts()) {
            $upost_query->the_post();

            $usr_get_p_status   = get_post_status(get_the_ID());
            $set_not_clickable  = '';
            $set_target  = '';
            if ($usr_get_p_status == 'publish') {
                $set_target = 'target="_blank"';
            } else {
                $set_not_clickable = 'post_n_clickable';
            }
            $post_url = get_the_permalink();

            $bp_title = get_the_title();
            $pieces = explode(" ", $bp_title);
            $first_part = implode(" ", array_splice($pieces, 0, 8));
            $directory_uri = get_template_directory_uri();

            $user_name = $current_user->name ?? '';
            $user_img_id = $current_user->image ?? '';

            $set_user_img_url = '';
            if ($user_img_id) {
                $set_user_img_url = wp_get_attachment_url($user_img_id);
            } else {
                $set_user_img_url = $directory_uri . '/assets/images/default.png';
            }

            $set_thumbnail_url = '';
            if (get_the_post_thumbnail_url()) {
                $set_thumbnail_url = get_the_post_thumbnail_url();
            } else {
                $set_thumbnail_url = $directory_uri . '/assets/images/default.png';
            }

            $user_post_cat = get_the_terms(get_the_ID(), 'category');
            $cat_mane = '';
            foreach ($user_post_cat as $single_cat) {
                $cat_mane .= $single_cat->name . '<span> ,</span>';
            }

            $post_items .= '
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ' . $set_not_clickable . '">
                <div class="watch_single_item">
                    <a ' . $set_target . ' class="' . $set_not_clickable . '" href="' . $post_url . '"></a>
                    <div class="watch_single_item_normal">
                        <div class="watch_item_top">
                            <div class="watch_inner_top">
                                <h2>' . $cat_mane . '</h2>
                            </div>
                            <div class="watch_item_top_inner ">
                                <div class="watch_inner_bottom">
                                    <h3>' . $first_part . '</h3>
                                </div>
                                <div class="watch_inner_simg d-flex  align-items-center">
                                    <img src="' . $set_user_img_url . '" alt="">
                                    <p>' . $user_name . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="watch_item_bottm">
                            <img class="set_arrow" src="' . $directory_uri . '/assets/images/icons/wt-arrow-down.svg" alt="">
                            <img src="' . $set_thumbnail_url . '" alt="">
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        $error = true;
    }

    $pagination = array(
        'base' => home_url('/alimentazione-articoli/%_%'),
        'current'       => $paged,
        'total'         => $upost_query->max_num_pages,
        'prev_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/arrow-left.svg>',
        'next_text'     => '<img src=' . "$get_site_url" . '/assets/images/icons/FrecciaCustom.svg>',
    );
    $set_cat_pagi = '<div class="blog_item_pagination usr_status_pagi">' . paginate_links($pagination) . '</div>';

    $message                = '<p class="cat_msg_display">Nessun post trovato</p>';

    $response['results']    = array(
        'post_tems'         => $post_items,
        'pagination'        => $set_cat_pagi,
        'error'             => $error,
        'message'           => $message,
    );
    echo  json_encode($response);

    die;
}

add_action('wp_ajax_usr_status_pagi', 'usr_status_pagi');
add_action('wp_ajax_nopriv_usr_status_pagi', 'usr_status_pagi');

