/* 图片延迟加载配置 */
$("img").lazyload({effect: "fadeIn",threshold: 200});
/* 移动端导航VS幻灯片参数 */
$(function(){$('.bxslider').bxSlider({auto:true,captions:false,mode:'fade'});$('.slide-wrapper').on('touchstart','li',function(e){$(this).addClass('current').siblings('li').removeClass('current')});$('a.slide-menu').on('click',function(e){var wh=$('.wrapper').height();$('.slide-mask').css('height',wh).show();$('.slide-wrapper').css('height',wh).addClass('moved')});$('.slide-mask').on('click',function(){$('.slide-mask').hide();$('.slide-wrapper').removeClass('moved')});$('.logint').on('click',function(){$('#back').load(chenxing.home_url+'/login');document.getElementById("back").style.display=""})});
/* 返回顶部按钮 */
function chenxingweb(){this.init();}
chenxingweb.prototype={constructor:chenxingweb,init:function(){this._initBackTop()},_initBackTop:function(){var $backTop=this.$backTop=$('<div class="cbbfixed"><a class="gotop cbbtn"><i class="fa fa-angle-up"></i></a></div>');$('body').append($backTop);$backTop.click(function(){$("html, body").animate({scrollTop:0},120)});var timmer=null;$(window).bind("scroll",function(){var d=$(document).scrollTop(),e=$(window).height();0<d?$backTop.css("bottom","10px"):$backTop.css("bottom","-90px");clearTimeout(timmer);timmer=setTimeout(function(){clearTimeout(timmer)},100)})}}		
var chenxingweb = new chenxingweb();