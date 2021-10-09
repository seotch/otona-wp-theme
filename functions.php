<?php
function my_user_meta($wb)
{
    //項目の追加
    $wb['name_kana'] = '姓名 (かな)';
    $wb['facebook'] = 'Facebook ID';
    $wb['twitter'] = 'Twitter ID';
    $wb['Pixiv'] = 'Pixiv ID';
    $wb['title'] = '役職';

    return $wb;
}
add_filter('user_contactmethods', 'my_user_meta', 10, 1);

// サイト用のスタイルシートを読み込み
function ob_euqueue_my_style()
{
    wp_enqueue_style("ob_instructor", get_stylesheet_directory_uri(). "/ob_instructor.css");
}
add_action('wp_enqueue_scripts', 'ob_euqueue_my_style');


// 記事IDを受けて講師テンプレートを読み込む
function ob_include_instructor($user_id)
{
    ob_start();
    include "ob_instructor.php";
    return ob_get_clean();
}

// 講師を挿入するするショートコード
function ob_instructors($atts)
{
    extract(
        shortcode_atts(
            array(
            'user_id' => get_the_author_meta('ID'),
            ),
            $atts
        )
    );
    return ob_include_instructor($user_id);
}
add_shortcode('ob_instructors', 'ob_instructors');

// ブログ記事を整形
function ob_modify_post($the_content)
{
    if (is_singular('post')) {
        //　アイキャッチがあれば先頭に追加
        if (has_post_thumbnail()) {
            $return .= '<div class="post_title_image">' . the_post_thumbnail('full') . '</div>';
        }
        $return .= $the_content;
        //　末尾に執筆者を追加
        $return .= '<h3>この記事を書いた人</h3>';
        $return .= ob_include_instructor(get_the_author_meta('ID'));
        return $return;
    } else {
        return $the_content;
    }
}
add_filter("the_content", "ob_modify_post");

// // ブログ記事の先頭に執筆者を追加
// function ob_add_eyecatch_to_post($the_content) {
// 	if ( is_singular( 'post' )) {
//
// 		if ( has_post_thumbnail()) {
// 			$return .= '<div class="post_title_image">' . the_post_thumbnail('full') . '</div>';
// 		}
// 		$return .= $the_content;
// 		return $return;
// 	} else {
// 		return $the_content;
// 	}
// }
// add_filter("the_content","ob_add_eyecatch_to_post");




// ブログ記事の先頭に

function ob_leadtext($atts)
{
    extract(
        shortcode_atts(
            array(
            'post_id' => get_the_ID(),
            ),
            $atts
        )
    );

    return get_field('lead_text', $post_id, false);
}
add_shortcode('ob_leadtext', 'ob_leadtext');

function ob_special_lecture($atts)
{
    extract(
        shortcode_atts(
            array(
            'post_id' => get_the_ID(),
            ),
            $atts
        )
    );

    return get_field('special', $post_id, false);
}
add_shortcode('ob_special_lecture', 'ob_special_lecture');


function insert_eyecatch_into_content($atts)
{
    extract(
        shortcode_atts(
            array(
             'size' => 'full', // default size choose in 'thumbnail', 'medium', 'large', 'full'
             'align' => 'center' // default alignment choose in 'left', 'right', 'center', 'none'
            ),
            $atts
        )
    );
    global $post;
    if (!get_post_thumbnail_id($post->ID)) {
        return false;
    } //no post thumbnail found

    $eyecatch = get_the_post_thumbnail($post->ID, $size, 'class=align' . $align);
    return '<div class="eyecatch">' . $eyecatch . '</div>';
}
add_shortcode('eyecatch', 'insert_eyecatch_into_content');


/**
 * my_mail
 *
 * @param object          $Mail
 * @param array           $values
 * @param MW_WP_Form_Data $Data
 */
function ob_entry_special_mail($Mail, $values, $Data)
{
    // $Data->get( 'hoge' ) で送信されたデータが取得できます。

    $Mail->body = str_replace(',', "\n", $Mail->body); // 本文を変更
    // $Mail->send(); で送信もできます。
    return $Mail;
}
add_filter('mwform_admin_mail_mw-wp-form-2000', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_auto_mail_mw-wp-form-2000', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_admin_mail_mw-wp-form-2088', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_auto_mail_mw-wp-form-2088', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_admin_mail_mw-wp-form-2168', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_auto_mail_mw-wp-form-2168', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_admin_mail_mw-wp-form-3191', 'ob_entry_special_mail', 10, 3);
add_filter('mwform_auto_mail_mw-wp-form-3191', 'ob_entry_special_mail', 10, 3);

// おとな講座データベースからフォームデータ読み込んで、ショートコードをMW_WP_FORMのタグと置き換え
function ob_set_mw_form($atts)
{
    extract(
        shortcode_atts(
            array(
            'name' => "",
            'type' => "",
            ),
            $atts
        )
    );
    global $wpdb;
    $sql = $wpdb->prepare("SELECT * FROM wp_otona_courses WHERE name = %s", $name);
    $course = $wpdb->get_row($sql);
    $mw_form;
    if ($type == "regular") {
         $mw_form = $course->regular_form;
    } elseif ($type == "special") {
         $mw_form = $course->special_form;
    }

    return do_shortcode($mw_form);
}
add_shortcode('ob_set_mw_form', 'ob_set_mw_form');

// おとな講座データベースから講座情報を読み込んで出力
function ob_course_info($atts)
{
    extract(
        shortcode_atts(
            array(
            'name' => "",
            'field' => "",
            ),
            $atts
        )
    );
    global $wpdb;
    $sql = $wpdb->prepare("SELECT * FROM wp_otona_courses WHERE name = %s", $name);
    $course = $wpdb->get_row($sql, ARRAY_A);
    $result = $course[$field];

    return $result;
}
add_shortcode('ob_course_info', 'ob_course_info');

// Codes for WooCommerce Integration
// Declear WooCommerse support.
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


/**
 * Set a custom add to cart URL to redirect to
 * @return string
 */
function custom_add_to_cart_redirect() {
    return 'http://otonanobijutsu.com/correspondence/cg%e3%82%a4%e3%83%a9%e3%82%b9%e3%83%88%e9%80%9a%e4%bf%a1%e8%ac%9b%e5%ba%a7%e3%83%86%e3%82%b9%e3%83%88';
}
add_filter( 'woocommerce_add_to_cart_redirect', 'custom_add_to_cart_redirect' );


// function ob_add_lecture_post_type() {
//     $params = array(
//       'public' => true,
// 			'labels' => array(
// 							'name' => '講義',
// 							'singular_name' => '講義',
// 							'add_new' => '新規追加',
// 							'add_new_item' => '講義を新規追加',
// 							'edit_item' => '講義を編集する',
// 							'new_item' => '新規講義',
// 							'all_items' => '講義一覧',
// 							'view_item' => '講義の説明を見る',
// 							'search_items' => '検索する',
// 							'not_found' => '講義が見つかりませんでした。',
// 							'not_found_in_trash' => 'ゴミ箱内に講義が見つかりませんでした。'
// 				),
// 				'public' => true,
// 				'query_var' => true,
// 				'rewirte' => array('slug' => 'lecture'),
// 				'capability_type' => 'page',
// 				'has_archive' => true,
// 				'hierarchical' => false,
// 				'menu_position' =>5,
// 				'supports' => array(
// 								'title',
// 								'editor',
// 								'thumbnail',
// 								'author',
// 								'custom-fields',
// 				),
// 		'taxonomies' => array('lecture_category','lecture_tag')
// 	  );
// 		register_post_type(‘lecture’,$params);// 投稿タイプ名の定義
// }
// add_action( 'init', 'ob_add_lecture_post_type' );
//
// function ob_create_lecture_taxonomies() {
// 	$labels = array(
// 					'name'                => '講義カテゴリ',        //複数系のときのカテゴリ名
// 					'singular_name'       => '講義カテゴリ',        //単数系のときのカテゴリ名
// 					'search_items'        => '講義カテゴリを検索',
// 					'all_items'           => '全ての講義カテゴリ',
// 					'parent_item'         => '親講義カテゴリ',
// 					'parent_item_colon'   => '親講義カテゴリ:',
// 					'edit_item'           => '講義カテゴリを編集',
// 					'update_item'         => '講義カテゴリを更新',
// 					'add_new_item'        => '新規講義カテゴリを追加',
// 					'new_item_name'       => '新規講義カテゴリ',
// 					'menu_name'           => '講義カテゴリ'        //ダッシュボードのサイドバーメニュー名
// 	);
// 	$params = array(
// 					'hierarchical'        => true,
// 					'labels'              => $labels,
// 					'rewrite'             => array( 'slug' => 'lecture_cat')
// 	);
// 	register_taxonomy( 'lecture_category', 'lecture', $params );
//
// 	// タグを作成
// 	$labels = array(
// 					'name'                => '講義タグ',        //複数系のときのタグ名
// 					'singular_name'       => '講義タグ',        //単数系のときのタグ名
// 					'search_items'        => '講義タグを検索',
// 					'all_items'           => '全ての講義タグ',
// 					'parent_item'         => null,
// 					'parent_item_colon'   => null,
// 					'edit_item'           => '講義タグを編集',
// 					'update_item'         => '講義タグを更新',
// 					'add_new_item'        => '新規講義タグを追加',
// 					'new_item_name'       => '新規講義タグ',
// 					'separate_items_with_commas'   => '講義タグをコンマで区切る',
// 					'add_or_remove_items'          => '講義タグを追加or削除する',
// 					'choose_from_most_used'        => 'よく使われている講義タグから選択',
// 					'not_found'                    => 'アイテムは見つかりませんでした',
// 					'menu_name'                    => '講義タグ'        //ダッシュボードのサイドバーメニュー名
// 	);
// 	$params = array(
// 					'hierarchical'            => false,
// 					'labels'                  => $labels,
// 					'update_count_callback'   => '_update_post_term_count',    //タグの動作に必要なCallback設定
// 					'rewrite'                 => array( 'slug' => 'lecture_tag' )
// 	);
//
// 	register_taxonomy( 'lecture_tag', 'lecture', $params );
//
//
// }
// add_action('init', 'ob_create_lecture_taxonomies');
