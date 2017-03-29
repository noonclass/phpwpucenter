<?php
/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
Package: Ucenter & Market
****************************************************************/
/* 
Template Name: 网关支付模板
*/
/*
 支付页面，VIP信息，支付交互，最后返回上一个页面。
*/
?>
<?php get_header(); ?>
<?php 
$order_id = $_POST['order_id'];
$product_id = $_POST['product_id'];
if(empty($order_id) || empty($product_id))wp_die('获取商品信息出错,请重试或联系客服!');

//一致性检查
global $wpdb;
$prefix = $wpdb->prefix;
$table = $prefix.'um_order';
$order = $wpdb->get_row("select * from ".$table." where product_id=".$product_id." and order_id=".$order_id);
if(!$order)wp_die('获取订单出错,请重试或联系客服!');

//获取支付方式和支付账号
$total_fee = $order->order_total_price;
$payment_way = $order->payment_way;
$payment_account = $order->payment_account;
 
$product_name = '';
$product_des = '';
if($product_id>0){$product_name = $_POST['order_name'];$product_des = get_post_field('post_excerpt',$product_id);}elseif($product_id==-1){$product_name='开通VIP月费会员';$product_des='VIP月费会员';}elseif($product_id==-2){$product_name='开通VIP季费会员';$product_des='VIP季费会员';}elseif($product_id==-3){$product_name='开通VIP年费会员';$product_des='VIP年费会员';}elseif($product_id==-4){$product_name='开通VIP终身会员';$product_des='VIP终身会员';}elseif($product_id==-5){$product_name='积分充值';$product_des=isset($_POST['creditrechargeNum'])?'充值'.$_POST['creditrechargeNum']*(100).'积分':'充值积分';}else{}
?>
<div class="main">
<div class="main_inner">
<div class="main_left">
    <div class="cashier" data-role="cashier">
    <?php if($payment_way == 'weixin'){ ?>
        <div class="qrcode-integration qrcode-area">  
            <div class="qrcode-header">
                <div class="fn-center">扫一扫付款（元）</div>
                <div class="fn-center qrcode-header-money"><?php echo $total_fee; ?></div>
            </div>
            <div class="qrcode-img-wrapper">
                <div class="qrcode-img-area"><img src="<?php echo CX_THEMES_URL; ?>/images/qrcode_weixin.png"></div>
                <div class="qrcode-img-explain fn-clear">
                    <img class="fn-left" src="https://t.alipayobjects.com/images/T1bdtfXfdiXXXXXXXX.png" alt="扫一扫标识">
                    <div class="fn-left">打开手机微信<br>扫一扫继续付款</div>
                </div>
            </div>
            <div class="qrcode-foot">
                <div class="qrcode-explain fn-hide">
                    <a href="https://weixin.qq.com/d" data-role="dl-app" target="_blank">首次使用请下载手机微信</a>
                </div>
            </div>
        </div>
        <div class="qrguide-area">
            <img src="<?php echo CX_THEMES_URL; ?>/images/qrguide_step.png" class="qrguide-area-img active">
            <img src="https://t.alipayobjects.com/images/rmsweb/T1ASFgXdtnXXXXXXXX.png" class="qrguide-area-img background">
        </div>
    <?php }else{ ?>
        <div class="qrcode-integration qrcode-area">  
            <div class="qrcode-header">
                <div class="fn-center">扫一扫付款（元）</div>
                <div class="fn-center qrcode-header-money"><?php echo $total_fee; ?></div>
            </div>
            <div class="qrcode-img-wrapper">
                <div class="qrcode-img-area"><img src="<?php echo CX_THEMES_URL; ?>/images/qrcode_alipay.png"></div>
                <div class="qrcode-img-explain fn-clear">
                    <img class="fn-left" src="https://t.alipayobjects.com/images/T1bdtfXfdiXXXXXXXX.png" alt="扫一扫标识">
                    <div class="fn-left">打开手机支付宝<br>扫一扫继续付款</div>
                </div>
            </div>
            <div class="qrcode-foot">
                <div class="qrcode-explain fn-hide">
                    <a href="https://mobile.alipay.com/index.htm" data-role="dl-app" target="_blank">首次使用请下载手机支付宝</a>
                </div>
            </div>
        </div>
        <div class="qrguide-area">
            <img src="<?php echo CX_THEMES_URL; ?>/images/qrguide_step1.png" class="qrguide-area-img active">
            <img src="https://t.alipayobjects.com/images/rmsweb/T1ASFgXdtnXXXXXXXX.png" class="qrguide-area-img background">
        </div>
    <?php } ?>
    </div>
    
    <div class="notice-area" data-role="notice">
        <p><i class="fa fa-notice"></i>非及时到账，扫码付款后请耐心等待10-30分钟，系统后台处理完成即可生效。
        <p>付款过程中如有疑问请联系我们，我们会立即为您处理。
        <p>客服QQ：23765999
    </div>
</div><!-- main_left -->

<div class="main_right sidebar">
    <div class="widget widget_cover">
        <h3>订单详情</h3>
        <div class="wrapper">
            <ul class="commodity-message cl">
                <li><span class="amount">金额：<?php echo $total_fee; ?>（元）</span></li>
                <li><span class="first long-content">摘要：<?php echo $order->product_name; ?></span></li>
                <li><span class="second short-content">支付方式：<?php echo $payment_way; ?></span></li>
                <li><span class="amount">支付账号：<?php echo $payment_account; ?></span></li>
                <span class="activity-btn"><a class="buy" href="<?php echo get_author_posts_url($order->user_id); ?>?tab=orders"><i class="fa fa-shopping-cart">&nbsp;</i>支付成功</a></span>
                <span class="activity-btn"><a class="buy" href="#"><i class="fa fa-shopping-cart">&nbsp;</i>支付失败</a></span>
            </ul>
        </div>
    </div>
</div><!-- main_right -->

</div><!-- main_inner -->
</div><!-- main -->

<?php get_footer(); ?>