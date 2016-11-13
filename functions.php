<?php
require_once locate_template('functions/widget.php');
require_once locate_template('functions/option_page.php');
/*------------------------------------------
  グローバルメニューの設定
------------------------------------------*/
register_nav_menus(array(
		'main_navigation' => 'global-nav'
	)
);

/*------------------------------------------
  ページネーション
------------------------------------------*/

function responsive_pagination($pages = '', $range = 4){
  $showitems = ($range * 2)+1;

  global $paged;
  if(empty($paged)) $paged = 1;

  //ページ情報の取得
  if($pages == '') {
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if(!$pages){
      $pages = 1;
    }
  }

  if(1 != $pages) {
    echo '<ul class="pagination" role="menubar" aria-label="Pagination">';
    //先頭へ
    echo '<li class="first"><a href="'.get_pagenum_link(1).'"><span>First</span></a></li>';
    //1つ戻る
    echo '<li class="previous"><a href="'.get_pagenum_link($paged - 1).'"><span>Previous</span></a></li>';
    //番号つきページ送りボタン
    for ($i=1; $i <= $pages; $i++)     {
      if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))       {
        echo ($paged == $i)? '<li class="current"><a>'.$i.'</a></li>':'<li><a href="'.get_pagenum_link($i).'" class="inactive" >'.$i.'</a></li>';
      }
    }
    //1つ進む
    echo '<li class="next"><a href="'.get_pagenum_link($paged + 1).'"><span>Next</span></a></li>';
    //最後尾へ
    echo '<li class="last"><a href="'.get_pagenum_link($pages).'"><span>Last</span></a></li>';
    echo '</ul>';
  }
}
/*------------------------------------------
画像の設定
------------------------------------------*/

//サムネイルの設定
if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(180,135,true);
}
if ( function_exists( 'add_image_size' ) ) {
  add_image_size( 'pickup', 240, 180, true );
  add_image_size( 'sidebar',84,63, true );
}
/*------------------------------------------------------
  不要なhead情報の非表示化
------------------------------------------------------*/
remove_action('wp_head', 'rel_canonical');
// generatorを非表示にする
remove_action('wp_head', 'wp_generator');

remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// EditURIを非表示にする
remove_action('wp_head', 'rsd_link');

// wlwmanifestを非表示にする
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/*------------------------------------------
  投稿画面の設定
------------------------------------------*/
//クイックタグの設定
function add_my_quicktag() {
?>
<script type="text/javascript">
//QTags.addButton('ID', 'ボタンのラベル', '開始タグ', '終了タグ');
  QTags.addButton('h2','中見出し','<h2>','</h2>');
  QTags.addButton('a','リンク','<a href="ここにアドレスを記述" target="_blank">','</a>');
</script>
<?php
}
add_action('admin_print_footer_scripts','add_my_quicktag');

/*------------------------------------------
  ショートコードの設定
------------------------------------------*/
function my_shortcode_skii_tour($atts, $content=null) {
$str=<<<eot
<ul class="articleTourButton"><li class="articleTourButton__button"><a href="http://www.jtrip.co.jp/cm?utm_source=smartmagazine&utm_medium=media&utm_campaign=smartmagazine_hkd2" target="_brank">東京発のスキーツアー >></a></li><li class="articleTourButton__button"><a href="http://www.jtrip.co.jp/cm/osa?utm_source=smartmagazine&utm_medium=media&utm_campaign=smartmagazine_hkd2" target="_brank">大阪発のスキーツアー >></a></li><li class="articleTourButton__button"><a href="http://www.jtrip.co.jp/cm/chu?utm_source=smartmagazine&utm_medium=media&utm_campaign=smartmagazine_hkd2" target="_brank">名古屋発のスキーツアー >></a></li><li class="articleTourButton__button"><a href="http://www.jtrip.co.jp/cm/fkk?utm_source=smartmagazine&utm_medium=media&utm_campaign=smartmagazine_hkd2" target="_brank">福岡発のスキーツアー >></a></li></ul>
eot;
$str=nl2br($str);
	return $str;
}
add_shortcode('skii-tour', 'my_shortcode_skii_tour');

function get_pickup_article(){
  $pickup_1 = get_option('pickup_1');
  if( get_option('pickup_1') && get_option('pickup_2') && get_option('pickup_3') && get_option('pickup_4') ){
    if( get_the_title( get_option('pickup_1') ) != '' && get_the_title( get_option('pickup_2') == true ) && get_the_title( get_option('pickup_3') != '' ) &&  get_the_title( get_option('pickup_4') )){
      $pickup_articles = array( get_option('pickup_1'), get_option('pickup_2'), get_option('pickup_3'), get_option('pickup_4') );
    }else{
      query_posts('posts_per_page=4'); if ( have_posts() ) : while ( have_posts() ) : the_post();
      $pickup_articles[] = get_the_ID();
      endwhile; endif;
      wp_reset_query();
    }
  }else{
    query_posts('posts_per_page=4'); if ( have_posts() ) : while ( have_posts() ) : the_post();
    $pickup_articles[] = get_the_ID();
    endwhile; endif;
    wp_reset_query();
  }
  return $pickup_articles;
}
/*------------------------------------------
  最下層のカテゴリー名の取得
------------------------------------------*/

function get_my_bottom_category($post_id) {
  $cats = get_the_category($post_id);
  $count_cat = count($cats);
  $new_cats = array();
  for($n = 0; $n < $count_cat; $n++) {
    $ancestors = get_ancestors( $cats[$n]->cat_ID, 'category' );
    $count_anc = count($ancestors);
    $new_cats[$count_anc] = $cats[$n];
  }
  krsort($new_cats);
  $cat = reset($new_cats);
  return $cat;
}
function the_bottom_category_nicename($post_id){
  $cat = get_my_bottom_category($post_id);
  echo esc_html($cat->category_nicename);
}
function the_bottom_category_name($post_id){
  $cat = get_my_bottom_category($post_id);
  echo esc_html($cat->cat_name);
}
//アーカイブのカテゴリー
function get_mg_cat_archive(){
  $cat = get_queried_object_id(); $cat = get_category($cat);
  return $cat;
}
function the_mg_cat_name_archive(){
  $cat = get_mg_cat_archive();
  echo esc_html($cat->cat_name);
}
function the_mg_cat_nicename_archive(){
  $cat = get_mg_cat_archive();
  echo esc_html($cat->slug);
}


?>
