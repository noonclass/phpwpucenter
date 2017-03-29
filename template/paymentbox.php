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

?>
<?php
function um_paymentbox(){
?>
<div id="paybox" class="um_paybox">
    <div class="part payPart">
    <form action="" method="null">
        <h3>扫码支付<p class="status"></p></h3>
        <p>
            <input type="radio" name="pb_way" id="weixin" value="weixin" checked="checked" >
            <label for="weixin"></label>
            <input type="radio" name="pb_way" id="alipay" value="alipay">
            <label for="alipay"></label>
        </p>
        <p>
            <input id="pb_account" name="pb_account" value="" placeholder="支付账号：微信号/支付宝账号">
        </p>
        <p>
            <input id="pb_submit" class="submit" type="button" value="确定">
        </p>
        <a class="close"><i class="fa fa-times"></i></a>
	</form>
    </div>
</div>
<?php
}
add_action('wp_footer','um_paymentbox');
?>