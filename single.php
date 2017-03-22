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
        <div class="main_left"<?php cx_format_post('image',' style="width:100%"')?>>
		  <div class="item_title">
			<h1> <?php the_title();?></h1>
			<div class="single-cat"> <span>分类：</span> <?php the_category( '-' ) ?></div>
		  </div>
		  <div class="item_info">
			<div style="float:left;"> 
				发布时间：<span><?php the_time('Y-n-j H:i:s');?></span> / 
                评论：<span><?php comments_popup_link( '0', '1', '%' ); ?></span> / 
                标签：<span class="tags_block"><?php the_tags('',',&nbsp;',''); ?></span> 
			 </div>
		  </div>
		  <!--AD id:single_1002-->
		  <div class="affs">
			 <a href="#">
				<img src="<?php echo CX_THEMES_URL;?>/images/cover/1.jpg" width="820" height="150">
			 </a>
		  </div>
		   <!--AD.end-->
		  <div class="content">
			<div class="content_left">
				<?php the_content();?>
                <?php the_random_posts(1,'<div class="post-more cl">','</div>','换一篇');?>
			</div>
		  </div>  
	  
<?php 
endwhile;
/** 相关文章 **/
cx_xg_post();
/** 评论模板 **/
comments_template();
/** div.main_left **/
echo "</div>";
/** 侧边调用 **/
if ( !has_post_format('image'))
	get_sidebar();
/** div.main_inner **/
echo "</div>";
/** div.main **/
echo "</div>";
/** 底部公共模板 **/
get_footer();