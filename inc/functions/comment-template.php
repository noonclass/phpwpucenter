<?php
/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
****************************************************************/
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'div-comment';
	} else {
		$tag = 'li';
		$add_below = 'comment';
	}
	// 楼层
	global $commentcount;
	if(!$commentcount) {
		$page = get_query_var('cpage')-1;
		$cpp=get_option('comments_per_page');
		$commentcount = $cpp * $page;
	}
    
    // 评论输出HTML，comment-ajax也使用此结构
?>
	
	<<?php echo $tag ?> <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	<div class="comment cf comment_details">
		<div class="avatar left">
			<a href="javascript:void(0)">
				<?php echo get_avatar( $comment, 40 ); ?>
			</a>
		</div>	
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="commenttext">
	<?php endif; ?>
	<div class="comment-wrapper">
          <div class="postmeta">
			  <a class="user_info_name" href="javascript:void(0)"><?php comment_author();?></a>
			  <?php if($comment->user_id == 1) echo "<a title='博主' class='vip'></a>"; ?>
			  <time class="timeago" datetime="<?php printf( __('%1$s at %2$s'), get_comment_date( 'Y-m-d' ),  get_comment_time() ); ?>"> • <?php echo get_comment_date( 'm-d' ); ?></time>
			  <?php edit_comment_link( '编辑' , '&nbsp;', '' ); ?>
			  <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		  </div>
          <div class="commemt-main">
            <?php comment_text(); ?>
          </div>
     </div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<div class="comment-awaiting-moderation">您的评论正在等待审核！</div>
	<?php endif; ?>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
	</div>
<?php 
}