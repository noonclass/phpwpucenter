<?php
/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
****************************************************************/
wp_get_header();
while ( have_posts() ) : the_post();
?>

<div class="main">
  <div class="main_inner">
        <div class="main_left" style="width:100%">
		  <div class="item_title">
			<h1> <?php the_title();?></h1>
			<div class="single-cat"> <span>发布时间：</span> <?php the_time('Y-n-j');?></div>
		  </div>
		  <!--AD id:single_1002-->
		  
		   <!--AD.end-->
		  <div class="content">
			<div class="content_left">
				<?php the_content();?>
			</div>
		  </div>
	  
	  
<?php 
endwhile;
/** 评论模板 **/
comments_template();
/** div.main_left **/
echo "</div>";
/** div.main_inner **/
echo "</div>";
/** div.main **/
echo "</div>";
/** 底部公共模板 **/
get_footer();