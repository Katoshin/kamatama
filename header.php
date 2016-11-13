<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php wp_head(); ?>
		<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<?php wp_deregister_script('jquery'); ?>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  	<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">
		<link href="<?php bloginfo('template_url'); ?>/css/html5-doctor-reset-stylesheet.css" rel="stylesheet">
		<script>
			(function($) {
    		$(function() {
        	var $header = $('.header');
        	$('#nav-toggle').click(function(){
            $header.toggleClass('open');
        	});
    		});
			})(jQuery);
		</script>
	</head>
	<body>
		<header id="top-head" class="header">
			<div class="inner">
	    <div id="mobile-head" class="header__mobile">
				<div class="header__titleArea">
					<span class="header__copy"><?php echo bloginfo('description'); ?></span>
	    		<h1 class="header__title"><a href="<?php echo home_url(); ?>"><?php echo bloginfo('name'); ?></a></h1>
				</div>
	        	<div id="nav-toggle">
	          	<div>
	            	<span></span>
	            	<span></span>
	            	<span></span>
	            </div>
	    			</div>
	        </div>
				<?php
					wp_nav_menu( array(
						'theme_location'=>'main_navigation',
						'container'     => 'nav',
						'container_id' => 'global-nav',
						'conteiner_class' => 'id',
						'menu_class'    =>'nav__list',
						'before' => '<li class="nav__item">',
						'after' => '</li>'
					));
				?>
			</div>
		</header>
