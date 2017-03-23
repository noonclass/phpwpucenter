<?php
/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
****************************************************************/
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="initial-scale=1.0,user-scalable=no"> 
		<?php wp_head(); ?>
		<!--[if lt IE 9]> 
		<script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script> 
		<![endif]--> 
	</head>
	<body class="home blog">
		<div class="index_header">
			<div class="header_inner">
				<div class="logo">
					<a href="<?php echo home_cx;?>"><img src="<?php echo CX_THEMES_URL;?>/images/logo.png" alt="<?php bloginfo('name'); ?>" /></a>
				</div>

				<div class="header_menu">
					<ul>
						<?php 
						if(function_exists('wp_nav_menu')) 
							wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'left-nav'));
						?>
					</ul>
				</div>
				<div class="login_text pc" style="padding-top: 25px;">
				<?php if ( is_user_logged_in() ) {?>
					<a class="rlogin reg_hre_btn" href="<?php echo wp_logout_url( get_permalink() ); ?>">退出</a>
					<a class="rlogin login_hre_btn" href="<?php echo um_get_user_url('index'); ?>">用户中心</a>
				<?php }else{ ?>
					<a class="rlogin reg_hre_btn sign-up" href="javascript:;">注册</a>
					<a class="rlogin login_hre_btn sign-in" href="javascript:;">登录</a>
				<?php } ?>
				</div>
				<div class="login_text mobie">
					<a href="javascript:;" class="slide-menu"><i class="fa fa-list-ul"></i></a>
				</div>
				<div class="header_search_bar">
					<form action="<?php echo home_cx;?>">
						<button class="search_bar_btn" type="submit"><i class="fa fa-search"></i></button>
						<input class="search_bar_input" type="text" name="s" placeholder="输入关键字">
					</form>
				</div>
			</div>
		</div>
		<!--移动端菜单-->
		<div class="slide-mask"></div>
		<nav class="slide-wrapper">
				<div class="header-info">
				<?php if ( is_user_logged_in() ) {?>
             	     <div class="header-logo">
	        			<a href="<?php echo home_cx;?>">
							<?php global $current_user; $email=$current_user->user_email ;echo get_avatar($email, 100 );?>						
						</a>
	        		</div>
        			<div class="header-info-content">
	        			<a href="<?php echo um_get_user_url('index'); ?>">用户中心</a>
	        		</div>
				<?php }else{ ?>
             	     <div class="header-logo">
	        			<a href="<?php echo home_cx;?>">	                     
							<img src="<?php echo CX_THEMES_URL;?>/images/avatar.jpg" alt="默认头像" />
						</a>
	        		</div>
        			<div class="header-info-content">
	        			<a href="<?php echo wp_login_url( get_permalink() ); ?>">登录</a>
	        		</div>
				<?php } ?>	
	        	</div>
				<ul class="menu_slide">
					<?php 
						if(function_exists('wp_nav_menu')) 
							wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'mini-nav'));
					?>
				</ul>
		</nav>
<!-- 头部代码end -->