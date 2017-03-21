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
<?php

class mm_wg_cover extends WP_Widget {
    function __construct(){
		parent::__construct(false,'Mm-封面人物',array( 'description' => '封面人物信息' ,'classname' => 'widget_mm_wg_cover'));
	}
    function widget($args,$instance){
		extract($args);
	?>
		<?php echo '<div class="widget widget_cover">'; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
        <?php echo $this->html($instance); ?>
		<?php echo '</div>'; ?>

	<?php }

	function update($new,$old){
		return $new;
	}

	function form($instance){
        $title = '';
        $post_num = '';
        if(isset($instance['title']))
            $title = esc_attr($instance['title']);
		if(isset($instance['number']))
            $post_num = absint($instance['number']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','um'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('文章数量：','um'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text"  value="<?php echo $post_num; ?>" /></p>
	<?php
	}
    
    function html($instance){
        global $post;
        $post_id = $post->ID;
        $results = cover_get_profile($post_id);
        $profile = $results[0];
        $post_num = 6;//default
        if(isset($instance['number']))
            $post_num = absint($instance['number']);
        
        $content = '<div class="post-cover">';
        
        // 人物简介<DIV>
        $content .= '<div class="profile">';
        $content .= '<span class="name"><i class="fa fa-street-view"></i>'.$profile->cover_name.'</span>';
        $content .= '<span class="bio"> <i class="fa fa-pencil"></i>'.$profile->cover_biography.'</span>';
        $content .= '</div>';
        
        // 相关文章<DIV>
        $content .= '<ul class="related cl">';
        $ids = cover_get_post_ids($post_id);
        $args = array(
            'post_status' => 'publish',
            'post__in' => $ids,
            'orderby' => 'date',
            'posts_per_page' => $post_num,
        );
        $query = new WP_Query( $args );
        while ( $query->have_posts() ) {
            $query->the_post();
            //cx_themes_switch(2001, $query->post);
            $content .= '<li><a class="link" href="'.get_the_permalink().'" target="_blank">';
			$content .= '<img src="'.cx_timthumb(380,170,'380x170', 0, false).'" alt="'.get_the_title().'" width="270" height="120">';
			$content .= '</a></li>';
        }
        wp_reset_postdata();
        $content .= '</ul>';
        
        $content .= '</div>';
        return $content;
    }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "mm_wg_cover" );' ) );
?>