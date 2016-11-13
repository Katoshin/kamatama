<?php get_header(); ?>
<div class="frontTop">
	<div class="container--pc">
		<ul class="frontPickup">
			<?php foreach ( get_pickup_article() as $id ) { ?>
				<li class="frontPickup__item">
					<div class="container--sptb">
					<a class="boxLink" href="<?php the_permalink($id) ?>">
						<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'pickup', array( 'class' => 'frontPickup__img') );
							}else{
						?>
						<img src="<?php bloginfo('template_url') ?>/damie.jpg" alt="サムネイル" class="frontPickup__img">
						<?php } ?>
					<span class="frontPickup__title"><?php echo esc_html(get_the_title($id)); ?></span>
					</a>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="container--pc">
	<div class="wrapper">
		<div class="content">
			<span class="archive__head">新着記事</span>
			<ul class="archive">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li class="archive__item">
						<div class="container--sptb">
							<a href="<?php the_permalink(); ?>" class="boxLink">
						<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'post-thumbnails', array( 'class' => 'archive__img') );
							}else{
						?>
						<img src="<?php bloginfo('template_url') ?>/damie.jpg" alt="" class="archive__img">
						<?php } ?>
						<span class="archive__cat"><?php $cats = get_the_category(); echo $cats[0]->cat_name; ?></span>
						<span class="archive__title"><?php the_title(); ?></span>
						<span class="archive__date">2016/11/11</span>
						</a>
					</div>
					</li>
					<?php endwhile; // end of the loop. ?>

					<!--ページネーション-->
					<?php if (function_exists('responsive_pagination')) {
					  responsive_pagination();
					} ?>

				<?php else: ?>

					//記事がない場合に表示
					  <?php _e('記事が見つかりませんでした。'); ?>

					<?php endif; ?>
			</ul>
		</div>
		<aside class="sidebar">
			<?php dynamic_sidebar('top_sidebar'); ?>
		</aside>
</div>
</div>
<?php get_footer(); ?>
