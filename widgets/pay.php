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
class mm_wg_pay extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Mm-支付入口',array( 'description' => '数字商品支付入口' ,'classname' => 'widget_mm_wg_pay'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo '<div class="widget widget_pay">'; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
        <?php echo $this->html($instance); ?>
		<?php echo '</div>'; ?>

	<?php }

	function update($new,$old){
		return $new;
	}

	function form($instance){
        $title = '';
        if(isset($instance['title']))
            $title = esc_attr($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','um'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
	<?php
	}
    
    function html($instance){
        global $post;
        $post_id = $post->ID;
        $price   = product_smallest_price($post_id);
        $currency   = (int)get_post_meta($post_id, 'pay_currency', true);
        $amount     = (int)get_post_meta($post_id, 'product_amount', true);
        $content = '<div class="wrapper">';
        
        // 购买入口<DIV>
        $content .= '<div class="price">';
        if($price[5]>0){//$last_price
            if($currency>0){
                $content .= '<div class="inner-box"><span class="money purple" title="人民币">'.sprintf('%0.2f',$price[5]).'</span>RMB</div>';
            }else{
                $content .= '<div class="inner-box"><span class="money purple" title="积分">'.sprintf('%d',$price[5]).'</span>GB</div>';
            }
        }else{
            $content .= '<div class="inner-box"><span class="money purple" title="积分">0</span>RMB</div>';
        }
        $content .= '</div>';
        
        // 统计信息<DIV>
        $sum = get_um_orders(0, "count", "product_id = $post_id");
        $content .= '<ul class="stat-meta cl">';
        $content .= '<li class="border"><span class="line">'.$sum.'</span>购买人数</li>';
        $content .= '<li class="border"><span class="line">'.Bing_get_views(false).'</span>人气</li>';
        $content .= '<li ><span class="line">'.get_the_excerpt().'</span>类型</li>';
        $content .= '</ul>';
        
        // 购买入口<DIV>
        $content .= '<div class="buy">';
        if(count(get_user_order_records($post_id,0,1))){
            $content .= '<a class="inner-bought disabled" href="javascript:"><i class="fa fa-shopping-cart">&nbsp;</i>已购买</a>';
        }
        else if($amount>0){
            $content .= '<a class="inner-buy-btn" data-top="false"><i class="fa fa-shopping-cart">&nbsp;</i>购买</a>';
        }else if($price[5]>0){
            $content .= '<a class="inner-soldout disabled" href="javascript:"><i class="fa fa-shopping-cart">&nbsp;</i>已售罄</a>';
        }else{
            $content .= '<a class="inner-bought disabled" href="javascript:"><i class="fa fa-shopping-cart">&nbsp;</i>免费</a>';
        }
        $content .= '</div>';
        
        // 购买会员列表<DIV>
        $results = get_um_orders(0, 0, "product_id = $post_id", 6);
        if(count($results)>0){
            $content .= '<ul class="buyer-list cl">';
            foreach ($results as $order){
                $user_id = $order->user_id;
                $name = get_user_meta($user_id,'nickname',true);
                $avatar = um_get_avatar( $user_id , '40' , um_get_avatar_type($user_id) );
                $content .= '<li class="avatar"><a href="'.get_author_posts_url($user_id).'" title="'.$name.'" target="_blank">'.$avatar.'</a></li>';
            }
            if($sum >count($results)){
                $content .= '...';
            }
            $content .= '</ul>';
        }
        
        $content .= '</div>';
        return $content;
    }
}
add_action('widgets_init',create_function('', 'register_widget("mm_wg_pay");'));
?>