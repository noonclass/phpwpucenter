/*!**************************************************************
Theme Name: MOE-PIX
Theme URI: http://moemob.com/moe-pix
Author: 萌える動 • 萌动网
Author URI: http://moemob.com
Description: 时尚自适应图片主题，集成了功能强大的前台用户中心
Version: 1.0
****************************************************************/

/* 图片延迟加载配置 */
$("img").lazyload({effect: "fadeIn",threshold: 200});
/* 移动端导航VS幻灯片参数 */
$(function(){$('.bxslider').bxSlider({auto:true,captions:false,mode:'fade'});$('.slide-wrapper').on('touchstart','li',function(e){$(this).addClass('current').siblings('li').removeClass('current')});$('a.slide-menu').on('click',function(e){var wh=$(document).height();$('.slide-mask').css('height',wh).show();$('.slide-wrapper').css('height',wh).addClass('moved')});$('.slide-mask').on('click',function(){$('.slide-mask').hide();$('.slide-wrapper').removeClass('moved')});});
/* 返回顶部按钮 */
function back2top(){this.init();}
back2top.prototype={constructor:back2top,init:function(){this._initBackTop()},_initBackTop:function(){var $backTop=this.$backTop=$('<div class="cbbfixed"><a class="gotop cbbtn"><i class="fa fa-angle-up"></i></a></div>');$('body').append($backTop);$backTop.click(function(){$("html, body").animate({scrollTop:0},120)});var timmer=null;$(window).bind("scroll",function(){var d=$(document).scrollTop(),e=$(window).height();0<d?$backTop.css("bottom","10px"):$backTop.css("bottom","-90px");clearTimeout(timmer);timmer=setTimeout(function(){clearTimeout(timmer)},100)})}}		
var back2top = new back2top();
/* 侧边栏-热门专题-窗口滚动到指定位置的时候FIXED定位 */
if($('.widget_image').length>=1){
var wg_top=$(".widget_image").offset().top;
$(window).scroll(function(){var win_top=$(this).scrollTop();var top=$(".widget_image").offset().top; if(win_top>=top){$(".widget_image").addClass("fixed");}if(win_top<wg_top){$(".widget_image").removeClass("fixed");}})
}
/* 评论提交 */
$(document).ready(function() {
	var __cancel = $('#cancel-comment-reply-link'),
		__cancel_text = __cancel.text(),
		__list = 'comment-list';//your comment wrapprer
	$(document).on("submit", "#commentform", function() {
		$.ajax({
			url: moemob.ajax_url,
			data: $(this).serialize() + "&action=ajax_comment",
			type: $(this).attr('method'),
			beforeSend: addComment.createButterbar("提交中...."),
			error: function(request) {
				var t = addComment;
				t.createButterbar(request.responseText);
			},
			success: function(data) {
				$('textarea').each(function() {
					this.value = ''
				});
				var t = addComment,
					cancel = t.I('cancel-comment-reply-link'),
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId),
					post = t.I('comment_post_ID').value,
					parent = t.I('comment_parent').value;
				if (parent != '0') {
					$('#respond').before('<ol class="children">' + data + '</ol>');
				} else if (!$('.' + __list ).length) {
					if (moemob.comment_form == 'bottom') {
						$('#respond').before('<ol class="' + __list + '">' + data + '</ol>');
					} else {
						$('#respond').after('<ol class="' + __list + '">' + data + '</ol>');
					}

				} else {
					if (moemob.comment_order == 'asc') {
						$('.' + __list ).append(data); // your comments wrapper
					} else {
						$('.' + __list ).prepend(data); // your comments wrapper
					}
				}
				t.createButterbar("提交成功");
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});
	addComment = {
		moveForm: function(commId, parentId, respondId) {
			var t = this,
				div, comm = t.I(commId),
				respond = t.I(respondId),
				cancel = t.I('cancel-comment-reply-link'),
				parent = t.I('comment_parent'),
				post = t.I('comment_post_ID');
			__cancel.text(__cancel_text);
			t.respondId = respondId;
			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			}!comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
			$("body").animate({
				scrollTop: $('#respond').offset().top - 180
			}, 400);
			parent.value = parentId;
			cancel.style.display = '';
			cancel.onclick = function() {
				var t = addComment,
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId);
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp);
				}
				this.style.display = 'none';
				this.onclick = null;
				return false;
			};
			try {
				t.I('comment').focus();
			} catch (e) {}
			return false;
		},
		I: function(e) {
			return document.getElementById(e);
		},
		clearButterbar: function(e) {
			if ($(".butterBar").length > 0) {
				$(".butterBar").remove();
			}
		},
		createButterbar: function(message) {
			var t = this;
			t.clearButterbar();
			$("body").append('<div class="butterBar butterBar-center"><p class="butterBar-message">' + message + '</p></div>');
			setTimeout("$('.butterBar').remove()", 3000);
		}
	};
});