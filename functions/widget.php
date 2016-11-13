<?php
/*------------------------------------------
  ウィジェットの設定
------------------------------------------*/
if (function_exists('register_sidebar')) {
  register_sidebar(array(
    'name' => '記事下(PC)',
    'id' => 'under_article',
    'description' => '記事下のコンテンツ',
    'before_widget' => '<div class="articleUnder__widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  register_sidebar(array(
    'name' => '記事下(SP)',
    'id' => 'under_article_sp',
    'description' => '記事下のコンテンツ',
    'before_widget' => '<div class="articleUnder__widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  register_sidebar(array(
    'name' => 'トップページサイドバー',
    'id' => 'top_sidebar',
    'description' => 'トップページ',
    'before_widget' => '<aside class="sidebar">',
    'after_widget' => '</aside>',
  ));
  register_sidebar(array(
    'name' => '記事ページサイドバー',
    'id' => 'article_sidebar',
    'description' => 'サイドバー',
    'before_widget' => '<div class="sidebarContent">',
    'after_widget' => '</div>',
  ));
}

/*---------------------------------------------------
  ランキングのウィジェット
---------------------------------------------------*/
class Mg_Widget_Rank_Sidebar extends WP_Widget{
    public function __construct() {
        $widget_ops = array(
            'classname' => 'mg_widget_rank_sidebar',
            'description' => '記事のランキング（サイドバー）'
        );
        parent::__construct('rank', '記事ランキング（サイドバー）', $widget_ops);
    }
    public function widget($args, $instance) {
        // ウィジェットタイトルの作成
        $title = apply_filters('widget_title', '記事ランキング');
        $rank   = get_mg_list_pickup('ranking');
        echo $args['before_widget'];
        ?>
        <span class="sidebarRight_hdr">記事ランキング</span>
        <ul class="sidebarList">
          <?php for( $i = 0; $i < count($rank); $i++){  ?>
            <li class="sidebarList_item sidebarList_item-rank card-link linkParent">
              <img class="sidebarList_item-rank_img" src="<?php bloginfo('template_url') ?>/images/sidebar_rank<?php echo $i+1; ?>.png">
              <?php echo get_the_post_thumbnail($rank[$i], 'pickup_side', array( 'class' => 'sidebarList_item_img linkChildImg' )); ?>
              <span class="sidebarList_item_title"><a href="<?php echo get_permalink($rank[$i]); ?>"><?php the_field('title_br',$rank[$i]); ?></a></span>
            </li>
          <?php } ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }
}
add_action('widgets_init', function() {return register_widget("Mg_Widget_Rank_Sidebar");});




 // Start class widget //
 class popular_post_list_widget extends WP_Widget {

 // Constructor //
 function popular_post_list_widget() {
  $widget_ops = array( 'classname' => 'popular_post_list_widget', 'description' => __('Displays popular post list by access count.', 'tcd-w') ); // Widget Settings
  $control_ops = array( 'id_base' => 'popular_post_list_widget' ); // Widget Control Settings
  parent::__construct( 'popular_post_list_widget', __('Popular post list (tcd ver)', 'tcd-w'), $widget_ops, $control_ops ); // Create the widget
 }

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $title = apply_filters('widget_title', $instance['title']);
   $post_num = $instance['post_num'];
   $rank_range = $instance['rank_range'];


   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }

   // Widget output //
   $args = array('post_type' => 'post', 'ignore_sticky_posts' => 1, 'posts_per_page' => $post_num, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value_num');

   // date range //
   switch ($rank_range) {
    case 'week':
     $start_ts = strtotime('-1 week', current_time('timestamp'));
     break;
    case '2week':
     $start_ts = strtotime('-2 week', current_time('timestamp'));
     break;
    case 'month':
     $start_ts = strtotime('-1 month', current_time('timestamp'));
     break;
    case '3month':
     $start_ts = strtotime('-3 month', current_time('timestamp'));
     break;
    case 'half':
     $start_ts = strtotime('-6 month', current_time('timestamp'));
     break;
    case 'year':
     $start_ts = strtotime('-1 year', current_time('timestamp'));
     break;
    default:
     $start_ts = null;
     break;
   }

   if ($start_ts) {
    global $wp_version;
    if (version_compare($wp_version,'3.7','>=')) {
     // using date query
      $args['date_query']['after'] = date('Y-m-d 23:59:59', $start_ts);
      $args['date_query']['inclusive'] = false;
    } else {
     // add filter hook
     $this->start_ts = $start_ts;
     add_filter('posts_where', array(&$this, 'posts_where'));
     $add_filter_posts_where = true;
    }
   }

   $popular_post = new WP_Query($args);

   // remove filter hook
   if (!empty($add_filter_posts_where)) {
    remove_filter('posts_where' , array(&$this, 'posts_where'));
    $add_filter_posts_where = false;
   }

?>
<ol class="popular_post_list">
<?php
   $i = 1;
   if ($popular_post->have_posts()) {
    while ($popular_post->have_posts()) : $popular_post->the_post();
?>
 <li class="clearfix rank<?php echo $i; ?>">
   <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="image"><?php if(has_post_thumbnail()) { the_post_thumbnail('size1'); } else { echo '<img src="' . get_bloginfo('template_url') . '/img/common/no_image1.gif" alt="" title="" />'; }; ?></a>
   <div class="info">
    <p class="rank"><?php printf(__('rank %s', 'tcd-w'),$i); ?></p>
    <a class="title" href="<?php the_permalink() ?>"><?php trim_title(40); ?></a>
   </div>
 </li>
<?php $i++; endwhile; wp_reset_query(); } else { ?>
 <li class="no_post"><?php _e('There is no registered post.', 'tcd-w');  ?></li>
<?php }; ?>
</ol>
<?php

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['post_num'] = $new_instance['post_num'];
  $instance['rank_range'] = $new_instance['rank_range'];
  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('Popular post', 'tcd-w'), 'post_num' => 10, 'rank_range' => 'all');
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
 <label for="<?php echo $this->get_field_id('post_num'); ?>"><?php _e('Number of post:', 'tcd-w'); ?></label>
 <select id="<?php echo $this->get_field_id('post_num'); ?>" name="<?php echo $this->get_field_name('post_num'); ?>" class="widefat" style="width:100%;">
  <option value="5" <?php selected('5', $instance['post_num']); ?>>5</option>
  <option value="10" <?php selected('10', $instance['post_num']); ?>>10</option>
  <option value="15" <?php selected('15', $instance['post_num']); ?>>15</option>
  <option value="20" <?php selected('20', $instance['post_num']); ?>>20</option>
  <option value="25" <?php selected('25', $instance['post_num']); ?>>25</option>
  <option value="30" <?php selected('30', $instance['post_num']); ?>>30</option>
 </select>
</p>
<p>
 <label for="<?php echo $this->get_field_id('rank_range'); ?>"><?php _e('Time range for Popular post', 'tcd-w'); ?>:</label>
 <select id="<?php echo $this->get_field_id('rank_range'); ?>" name="<?php echo $this->get_field_name('rank_range'); ?>" class="widefat" style="width:100%;">
  <option value="week" <?php selected('week', $instance['rank_range']); ?>><?php _e('past 1 week', 'tcd-w'); ?></option>
  <option value="2week" <?php selected('2week', $instance['rank_range']); ?>><?php _e('past 2 week', 'tcd-w'); ?></option>
  <option value="month" <?php selected('month', $instance['rank_range']); ?>><?php _e('past 1 month', 'tcd-w'); ?></option>
  <option value="3month" <?php selected('3month', $instance['rank_range']); ?>><?php _e('past 3 month', 'tcd-w'); ?></option>
  <option value="half" <?php selected('half', $instance['rank_range']); ?>><?php _e('past 6 month', 'tcd-w'); ?></option>
  <option value="year" <?php selected('year', $instance['rank_range']); ?>><?php _e('past 1 year', 'tcd-w'); ?></option>
  <option value="all" <?php selected('all', $instance['rank_range']); ?>><?php _e('All time', 'tcd-w'); ?></option>
 </select>
</p>
<?php
 } // end function form

 // for WP Query where filter //
 function posts_where($where) {
  global $wpdb;
  if (!empty($this->start_ts)) {
   $where .= " AND ".$wpdb->posts.".post_date > ".date('Y-m-d 23:59:59', $this->start_ts);
  }
  return $where;
 }

}

// End class widget
add_action('widgets_init', create_function('', 'return register_widget("popular_post_list_widget");'));









?>
