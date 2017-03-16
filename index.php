<?php
/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
****************************************************************/
get_header();
/** 调用首页幻灯片 **/
$slider = cx_options('_cx_slider');
if(isset($slider) && $slider == 'off')
cx__template('slider');
?>

	<div class="home-filter">	
		<div class="h-screen-wrap">
			<ul class="h-screen">
				<?php 
				if(function_exists('wp_nav_menu')) 
				wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'home-nav'));
				?>				                            
			</ul>
		</div>
		<ul class="h-soup cl">
			<li class="open"><i class="fa fa-coffee"></i>最近一周新增 <em><?php echo get_week_post_count();?></em> 篇文章</li>                                                
		</ul>
	</div>
	<h2 class="btt mobies"> <i class="fa fa-gittip" style="color: #E53A40;"></i>为您推荐 <span>给您推荐一批更精彩的</span> </h2>
		
<?php 
/** 调用首页文章列表 **/
cx__template('archive');
/** 掉用公共底部 **/
get_footer();