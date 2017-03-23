<?php
/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
****************************************************************/
/* 
Template Name: 重置密码模板  
*/
?>
<?php
global $user_ID;
if ($user_ID) {
    wp_redirect( home_url() ); exit;
}


function validate_url() {
    global $post;
    $page_url = esc_url(get_permalink( $post->ID ));
    $urlget = strpos($page_url, "?");
    if ($urlget === false) {
        $concate = "?";
    } else {
        $concate = "&";
    }
    return $page_url.$concate;
}

/* 重置密码 - HTML
/* -------------------------------- */
global $wpdb;
if(isset($_POST['action']) && $_POST['action'] == "lostpassword"){
    //Check随机数
    if (!wp_verify_nonce( $_POST['nonce'], "nonce")) {
        exit("Are you kidding me? ");
    }
    
    if(empty($_POST['user'])) {
        echo "<div class='error'>请输入您的用户名或电子邮箱地址。</div>";
        exit();
    }

    //过滤数据,通过邮箱或者用户名查找用户信息,最后排除管理员
    $user = $wpdb->_escape(trim($_POST['user']));
    if ( strpos($user, '@') ) {
        $user = get_user_by('email', $user);
        if(empty($user) || $user->caps['administrator'] == 1) {
            echo "<div class='error'>无效的电子邮箱地址!</div>";
            exit();
        }
    } else {
        $user = get_user_by('login', $user);
        if(empty($user) || $user->caps['administrator'] == 1) {
            echo "<div class='error'>无效的用户名!</div>";
            exit();
        }
    }

    $user_login = $user->user_login;
    $user_email = $user->user_email;
    
    //获取20位随机密匙并记录到数据库中
    $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
    if(empty($key)) {
        $key = wp_generate_password(20, false);
        $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
    }

    //构造邮件内容,并发送
    $message =  __('亲爱的') . sprintf(__(' %s '), $user_login) . ":\r\n\r\n";
    $message .= __('欢迎你使用我们的服务，请点击下面的链接来重置密码:') . "\r\n";
    $message .= validate_url() . "action=verify&code=$key&login=" . rawurlencode($user_login) . "\r\n\r\n";
    $message .= '如果以上链接无法点击，请将该链接复制到浏览器（如 Chrome ）的地址栏中访问，也可以成功完成操作！\r\n\r\n';
    $message .= '- ' . bloginfo('name');
    $message .= '(这是一封自动产生的Email，请勿回复)';
    if ( $message && !wp_mail($user_email, '重置密码请求', $message) ) {
        echo "<div class='error'>邮件发送失败-原因未知。</div>";
        exit();
    } else {
        echo "<div class='success'>我们已经在给你发送的邮件中说明了重置密码的各项事宜，请注意查收。</div>";
        exit();
    }
} else {
    get_plain_header(); ?>
    <div class="main">
        <div class="container width-full">
            <div class="auth-form">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <h2>重置密码</h2>
                    <div class="auth-form-body">
                        <label class="message">请输入您的用户名或电子邮箱地址。您会收到一封包含创建新密码链接的电子邮件。</label>
                        <form id="lostpassword" name="lostpassword" action="" method="post">
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("nonce"); ?>" />
                            <input type="hidden" name="action" value="lostpassword" />   
                            <input type="text" name="user" value="" class="form-control input-block" /><br />
                            <input type="submit" name="reset" value="获取新密码" class="btn btn-primary btn-block" />
                        </form>
                        <div id="result"></div> <!-- To hold validation results -->
                    </div>
                    <script type="text/javascript">
                    $("#lostpassword").submit(function() {
                        $('#result').html('<span class="loading">Validating...</span>').fadeIn();
                        var input_data = $('#lostpassword').serialize();
                        $.ajax({
                            type: "POST",
                            url:  "<?php echo get_permalink( $post->ID ); ?>",
                            data: input_data,
                            success: function(msg){
                                $('.loading').remove();
                                $('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
                            }
                        });
                        return false;
                    });
                    </script>
                <?php endwhile; else : ?>
                <h2><?php _e('没有找到'); ?></h1>
                <?php endif; ?>
            </div>    
        </div><!--container-->
    </div><!-- main -->
<?php get_plain_footer();
}

/* 重置密码 - 邮件中链接验证
/* -------------------------------- */
if(isset($_GET['code']) && isset($_GET['action']) && $_GET['action'] == "verify") {
    $key = $_GET['code'];
    $user_login = $_GET['login'];
    $user = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $user_login));

    $user_login = $user->user_login;
    $user_email = $user->user_email;
    if(!empty($key) && !empty($user)) { //生成7位随机密码
        $new_password = wp_generate_password(7, false);
        wp_set_password( $new_password, $user->ID ); //重置密码
        
        //构造邮件内容,将密码发送给用户
        $message =  __('亲爱的') . sprintf(__(' %s '), $user_login) . ":\r\n\r\n";
        $message .= __('欢迎你使用我们的服务，您的新密码为:') . "\r\n";
        $message .= sprintf(__('%s'), $new_password) . "\r\n\r\n";
        $message .= __('请使用你的新密码登录。') . "\r\n\r\n";
        $message .= '- ' . bloginfo('name');
        $message .= '(这是一封自动产生的Email，请勿回复)';
        if ( $message && !wp_mail($user_email, '重置密码请求', $message) ) {
            echo "<div class='error'>邮件发送失败-原因未知</div>";
            exit();
        } else {
            $redirect_to = validate_url()."action=success";//跳转到登陆成功页面(还是本页面地址)
            wp_safe_redirect($redirect_to);
            exit();
        }

    } else{
        exit('无效的key.');
    }
}

if(isset($_GET['action']) && $_GET['action'] == "success") { //如果动作为reset_success就是成功了哇
    exit('<div class="success">密码重置成功，已经通过邮件发送给您，请查收。</div>');
}