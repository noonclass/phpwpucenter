<?php
define('AC_VERSION','1.0.0');

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	wp_die('请升级到4.4以上版本');
}

if(!function_exists('fa_ajax_comment_err')) :

    function fa_ajax_comment_err($a) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }

endif;

if(!function_exists('fa_ajax_comment_callback')) :

    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
        if ( is_wp_error( $comment ) ) {
            $data = $comment->get_error_data();
            if ( ! empty( $data ) ) {
            	fa_ajax_comment_err($comment->get_error_message());
            } else {
                exit;
            }
        }
        $user = wp_get_current_user();
        do_action('set_comment_cookies', $comment, $user);
        $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
            <div class="comment cf comment_details">
            <div class="avatar left">
                <a href="javascript:void(0)">
                    <?php echo get_avatar( $comment, 40 ); ?>
                </a>
            </div>
            <div id="div-comment-<?php comment_ID() ?>" class="commenttext">
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
            </div>
        </li>
        <?php die();
    }

endif;

add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');