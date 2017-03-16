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
?>
<div class="fl">
    <div class="fl_title">
      <div class="fl01"> <?php the_author(); ?> 专栏</div>
    </div>
    <div class="filter-wrap">
      <div class="filter-tag">
		<div class="fl_list"><span> 作者简介：</span>
		<?php the_author_meta('description'); ?>
		</div>        
           
      </div>
    </div>
  </div>

  
<?php 
/** 调用分类列表 **/
cx__template('archive');
/** 掉用公共底部 **/
get_footer();