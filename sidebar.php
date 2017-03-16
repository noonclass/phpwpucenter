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
<div class="main_right sidebar">
<?php
if ( is_active_sidebar( 'sidebar-1' ) ){
	dynamic_sidebar( 'sidebar-1' );
}else{?>
	<div>请到 外观=》小工具 页面设置该模块调用内容。</div>
<?php } ?>
</div>