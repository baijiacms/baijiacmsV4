<?php defined('IN_IA') or exit('Access Denied');?>
<?php  if ( is_use_weixin()) {
			$share_settings=globalSetting('share');
		
	      		if(empty($weixin_share_dzddes))
	      		{
        					$weixin_share_dzddes=	$share_settings['desc'];
        			}	
        				if(empty($weixin_share_dzddes))
	      		{
        					$weixin_share_dzddes=	"";
        			}	
        					if(empty($weixin_share_dzdtitle))
	      		{
        					$weixin_share_dzdtitle=	$share_settings['title'];
        				}
        							if(empty($weixin_share_dzdtitle))
	      		{
        					$weixin_share_dzddes=	"商城";
        			}	
        					if(empty($weixin_share_dzdpic))
	      		{
			      			if(empty($share_settings['icon']))
			      		{
        				$weixin_share_dzdpic="";
        				}else
        				{
        				$weixin_share_dzdpic=	ATTACHMENT_WEBROOT.$share_settings['icon'];
        				}
        	}
        				
       if(empty($weixin_share_url))
       {
				$weixin_share_url=WEBSITE_ROOT.create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop'));
			 }

	$sharedata = array(
      "title"       => $weixin_share_dzdtitle,
      "imgUrl"       => $weixin_share_dzdpic,
      "link"      => $weixin_share_url,
      "description" => $weixin_share_dzddes
    );
    
      $wx_weixin_share = weixin_js_signPackage($sharedata);
	
	 ?>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
<script type="text/javascript">
var wxshare=true;
function load_jwxshare(){
var wxData = {
            "imgUrl" : "<?php echo $wx_weixin_share['imgUrl'];?>",
            "link" : "<?php echo $wx_weixin_share['link'];?>",
            "desc" : "<?php echo $wx_weixin_share['description'];?>",
            "title" : "<?php echo $wx_weixin_share['title'];?>"
};
wx.config({
    debug: false,
    appId: "<?php echo $wx_weixin_share['appId'];?>",
    timestamp: <?php echo $wx_weixin_share['timestamp'];?>, 
    nonceStr: "<?php echo $wx_weixin_share['nonceStr'];?>", 
    signature: "<?php echo $wx_weixin_share['signature'];?>",
     jsApiList: [
        'checkJsApi',<?php if($weixin_share_address_show){?>'openAddress',<?php } ?>
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone'
      ]
});
wx.error(function(res){
	if('<?php echo $wx_weixin_share['signature'];?>'!='')
	{
		if(res.errMsg='config:invalid signature')
		{
	//alert(res.errMsg);
			//alert("转发接口失效，请联系管理员");
		}
	}
});	
var shareData = {
      title: wxData.title,
      link: wxData.link,
    	desc: wxData.desc,
      imgUrl:  wxData.imgUrl
    };

wx.ready(function () {
    wx.onMenuShareAppMessage(shareData);
    wx.onMenuShareTimeline(shareData);
    wx.onMenuShareAppMessage(shareData);
		wx.onMenuShareQQ(shareData);
		wx.onMenuShareWeibo(shareData);
		wx.onMenuShareQZone(shareData);
});};
</script><?php } ?>