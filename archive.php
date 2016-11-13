<?php get_header(); ?>
<div class="container--pc">
	<div class="wrapper">
		<?php get_template_part('breadcrumbs'); ?>
		<div class="content">
			<span class="archive__head">新着記事</span>
			<ul class="archive">
				<?php for( $i = 0; $i < 10; $i++ ){ ?>
					<li class="archive__item">
						<div class="container--sptb">
						<a href="" class="boxLink">
						<img src="<?php bloginfo('template_url') ?>/damie.jpg" alt="" class="archive__img">
						<span class="archive__title">タイトルタイトルタイトルタイトルタイトルタイトル</span>
						<span class="archive__date">2016/11/11</span>
						</a>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
		<aside class="sidebar">
			<?php dynamic_sidebar('article_sidebar'); ?>
		</aside>
</div>
</div>
<?php get_footer(); ?>
