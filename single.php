<?php get_header(); ?>
<div class="container--pc">
	<div class="wrapper">
		<?php get_template_part('breadcrumbs'); ?>
		<div class="content">
      <article class="article">
			<?php if(have_posts()):while(have_posts()):the_post(); ?>
        <header>
            <span class="article__date"><?php echo date("Y.m.d", strtotime($post->post_date)); ?></span>
          <h1 class="article__title"><?php the_title(); ?></h1>
          <div class="article__shareArea">
            <div class="article__share article__share--facebook">
							<a  href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onclick="window.open(encodeURI(decodeURI(this.href)), 'FBwindow', 'width=554, height=470, menubar=no, toolbar=no, scrollbars=yes'); return false;" rel="nofollow">シェアする</a>
						</div>
						<div class="article__share article__share--twitter">
							<a href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php the_permalink(); ?>" onClick="window.open(encodeURI(decodeURI(this.href)), 'tweetwindow', 'width=650, height=470, personalbar=0, toolbar=0, scrollbars=1, sizable=1'); return false;" rel="nofollow">ツイートする</a>
						</div>
          </div>
        </header>
				 <div class="article__content">
        	<?php the_content(); ?>
				</div>
				<div class="article__shareArea">
					<div class="article__share article__share--facebook">
						<a  href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onclick="window.open(encodeURI(decodeURI(this.href)), 'FBwindow', 'width=554, height=470, menubar=no, toolbar=no, scrollbars=yes'); return false;" rel="nofollow">シェアする</a>
					</div>
					<div class="article__share article__share--twitter">
						<a href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php the_permalink(); ?>" onClick="window.open(encodeURI(decodeURI(this.href)), 'tweetwindow', 'width=650, height=470, personalbar=0, toolbar=0, scrollbars=1, sizable=1'); return false;" rel="nofollow">ツイートする</a>
					</div>
				</div>
      <?php endwhile; endif; ?>
      <article>
		</div>
		<aside class="sidebar">
			<?php dynamic_sidebar('article_sidebar'); ?>
		</aside>
  </div>
</div>
<?php get_footer(); ?>
