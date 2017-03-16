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
				 <i class="fa fa-eye"></i> <span><?php echo Bing_get_views();?></span> 人气 / 
				 <i class="fa fa-comment"></i> <span><?php comments_popup_link( '0', '1', '%' ); ?></span> 评论 / 
				 <i class="fa fa-clock-o"></i> <span><?php the_time('Y-n-j');?></span> 发布
			 </div>
			<div class="post_au"> Author：<?php the_author_posts_link();?></div>
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
			  <div class="tag cl">
				<div class="single-tags-title"> Tags： </div>
				  <div class="single-tags"><?php the_tags('','',''); ?></div> 
				  <span class="post-like">
				  <a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="favorite<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' done';?>">
				  <i class="fa fa-heart"></i> 
					  <span class="count">
						<?php 
						if( get_post_meta($post->ID,'bigfa_ding',true) ){
							echo get_post_meta($post->ID,'bigfa_ding',true);
						} else {
							echo '0';
						}
						?>
						</span>+ 赞 </a>
				</span>
			  </div>
			  <script>
				$.fn.postLike = function() {
					if ($(this).hasClass('done')) {
						return false;
					} else {
						$(this).addClass('done');
						var id = $(this).data("id"),
						action = $(this).data('action'),
						rateHolder = $(this).children('.count');
						var ajax_data = {
							action: "bigfa_like",
							um_id: id,
							um_action: action
						};
						$.post(moemob.ajax_url, ajax_data,
						function(data) {
							$(rateHolder).html(data);
						});
						return false;
					}
				};
				$(document).on("click", ".favorite",function() {
					$(this).postLike();
				});
			 </script>
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