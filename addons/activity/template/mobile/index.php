<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include addons_page('share');?>
     <title><?php echo $pagetitle;?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/css/common.min.css?v=20160831">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/components/mui/mui.ext.css">
    
    <script type="text/javascript" src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/components/mui/mui.min.js?v=20160831"></script>
    
    </head>
    
<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/css/style.css">

<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/css/detail.css">

<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/components/swiper/swiper.min.css?x=1">

<script type="text/javascript" src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/components/swiper/swiper.min.js"></script>

<style type="text/css">

.latecolor{color:#ff9900}

.latecolorbg{background-color:#ff9900}

.lateborder{border:1px solid#ff9900}

.addressXX{color:#000;line-height:22px}

.tag{position:absolute;left:0;bottom:0;background-color:rgba(0,0,0,0.6);display:inline-block;z-index:2;width:100%;height:35px;padding:5px 7px;border-left:3px solid#348379;}

.tag span{font-size:18px;font-weight:bold;line-height:1.5;text-align:left;color:#fff;}

.bodybox{height:80px;}

.box-float{ display:none;}

</style>


<body>
<?php if(is_weixin()&&!empty($base_member['weixin_openid'])&&!empty($activity['followurl'])&&empty($fans['follow'])){?>
<style type="text/css">

.subscribe{position: absolute;width: 100%; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.8); z-index: 1000000; overflow: hidden; margin: 0 auto; max-width: 640px; min-width: 320px;height:60px;}

.subscribe .img{width:40px; height:40px; position:absolute; left:10px; top:10px;}

.subscribe .img img{width:40px; height:40px; border-radius:3px;}

.subscribe .text{padding:10px 90px 10px 60px; line-height:20px; color:#fff; font-size:14px;}

.subscribe .text font{color:#FA5343;}

.subscribe .btn{position:absolute; right:10px; top:15px;}

.subscribe .btn .buttonn{background:#FA5343;width:70px;height:30px;line-height:30px;text-align:center; border-radius:5px; color: #fff;border:none;}

.subscribe p{ color:#FFF; margin-bottom: 5px;}

.st{

	position:absolute;

	top:20%;

    left:0;

	right:0;

	z-index:100000;

    opacity:0.75;

    color:white;

    background: rgba(68, 68, 68, 0);

    background-image: initial;

    background-position-x: initial;

    background-position-y: initial;

    background-size: initial;

    background-repeat-x: initial;

    background-repeat-y: initial;

    background-attachment: initial;

    background-origin: initial;

    background-clip: initial;

    background-color: rgba(68, 68, 68, 0);

}

.st .m_guide{ text-align:center}

.st .close{ display:block; width:200px; margin:auto; text-align:right;}

.all{position:absolute;z-index:99999;width: 100%;height: 100%;opacity: 0.75;background-color: #000000;}

</style>

<div class="subscribe">

   <?php if(!empty($activity['followicon'])){?> <div class="img"><img src="<?php echo tomedia($activity['followicon']);?>"></div><?php }?>

    <div class="text">

        <p>欢迎进入<font><?php $weixin_setting=globalSetting('weixin'); echo $weixin_setting['weixinname'];?></font></p>

        <p>关注公众号,享专属服务</p>

    </div>

    <div class="btn">

        <a class="lizhuanz" href="<?php echo $activity['followurl'];?>"><div class="buttonn" style="font-size:12px ">进入关注页</div></a>

    </div>

</div>

<?php }?>
<?php if(false){?>
<nav class="mui-bar mui-bar-tab" id="bar">



    <a class="mui-tab-item<?php  if($_GPC['do']=='ucenter') { ?> mui-active<?php  } ?>" href="javascript:_system._guide(true);">

     我要分享  <span class="mui-icon mui-ext-icon mui-icon-fenxiang"></span>

        <span class="mui-tab-label"></span>

    </a>    

</nav>
<?php }?>


<div class="basic-box box-float">

        <div class="mui-col-xs-7 mui-left">

            <div class="buy-box">

                <div class="price" style="display:none"><span class="rmb-num">0.01 元</span></div>

                <div class="num">名额<?php  if($activity['personnum']>0) { ?><span class="rmb-num"> <?php  echo $activity['personnum'];?>人</span><?php  } else { ?>不限<?php  } ?></div>

            </div>

            <div class="end-date"><span style="font-weight:bold">报名截止：</span>

             <?php  if(TIMESTAMP < strtotime($activity['joinetime'])) { ?>

             <?php  echo date('m月d日 H:i',strtotime($activity['joinetime']))?>

             <?php  } else if(TIMESTAMP > strtotime($activity['joinetime'])) { ?>报名结束<?php  } ?>

            </div>

        </div>

        <?php  if($jion['id']!='') { ?>

        <div class="mui-head-ext mui-right" style=" margin-right:15px;">

            <img src="<?php  echo tomedia($fans['avatar']);?>" />

            <p><?php  echo $fans['nickname'];?></p>

        </div>

        <?php  } else { ?>

        <div class="mui-col-xs-4 mui-padded-top-10 mui-right">

            <?php  if(TIMESTAMP < strtotime($activity['joinetime'])) { ?>

                <a href="<?php  echo create_url('mobile',array('act' => 'activity','do' => 'join','isaddons'=>'1','activityid' => $activityid, 'op' => 'display'));?>" class="mui-btn mui-btn-block mui-btn-orange">我要报名</a>

            <?php  } ?>               

        </div>

        <?php  } ?>

        <div style="clear:both;"></div>

</div>

<div class="mui-content">

<div class="mui-scroll">

    <div class="swiper-container">

		<div class="swiper-wrapper">

      	<?php  if(is_array($activity['atlas'])) { foreach($activity['atlas'] as $row) { ?>	

            <div class="swiper-slide"><img src="<?php  echo tomedia($row);?>"></div>

      	<?php  } } ?>

        </div>

        <div class="tag"><span><?php  echo $activity['title'];?></span></div>

	</div>

    

    <div class="bodybox">

      <div class="basic-box box-fixed">

        <div class="mui-col-xs-7 mui-left">

            <div class="buy-box">

                <div class="price" style="display:none"><span class="rmb-num">0.01 元</span></div>

                <div class="num">名额<?php  if($activity['personnum']>0) { ?><span class="rmb-num"> <?php  echo $activity['personnum'];?>人</span><?php  } else { ?>不限<?php  } ?></div>

                

            </div>

            <div class="end-date"><span style="font-weight:bold">报名截止：</span>

             <?php  if(TIMESTAMP < strtotime($activity['joinetime'])) { ?>

             <?php  echo date('m月d日 H:i',strtotime($activity['joinetime']))?>

             <?php  } else if(TIMESTAMP > strtotime($activity['joinetime'])) { ?>报名结束<?php  } ?>

            </div>

        </div>

        <?php  if($jion['id']!='') { ?>

          <div class="mui-col-xs-4 mui-padded-top-10 mui-right">


            <p>您已报名成功！</p>
			
        </div>

        <?php  } else { ?>

        <div class="mui-col-xs-4 mui-padded-top-10 mui-right">

            <?php  if(TIMESTAMP < strtotime($activity['joinetime'])) { ?>

                <a href="<?php echo create_url('mobile',array('act' => 'activity','do' => 'join','isaddons'=>'1','activityid' => $activityid, 'op' => 'display'));?>" class="mui-btn mui-btn-block mui-btn-orange">我要报名</a>

            <?php  } ?>               

        </div>

        <?php  } ?>

        <div style="clear:both;"></div>

      </div>

    </div>

	

    <div class="content">

        <div class="M_detail">

        	<div class="mod_tab"><span>有<?php  echo $total;?>人报名成功</span></div>

            <div class="detail-item detail-more">

         <!--   <a href="<?php  // $this->createMobileUrl('userlist', array('activityid'=>$activityid));?>" class="more-user">-->

            <?php  if(is_array($records)) { foreach($records as $row) { ?>

            <?php  if($row['pic']=='') { ?>

            <img class="bm-user" src="<?php  echo tomedia($row['headimgurl']);?>" />

            <?php  } else { ?>

            <img class="bm-user" src="<?php  echo tomedia($row['pic']);?>" />

            <?php  } ?>

            <?php  } } ?>
	       <?php  if(count($records)<24) { $realcount=count($records);
	       	for($xi=$realcount;$realcount<24;$realcount++)
	       	{
	       	?>    <img class="bm-user" src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/face/<?php echo $realcount;?>.jpg" />
	             <?php  } } ?>
           <!-- </a>-->

            </div>

        </div>

        

        <!-- 基本信息 -->

        <div class="msgDiv" style="margin-top:15px;border-bottom:1px solid #eee"><img style="width:14px;vertical-align:top;margin-top:3px" src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/images/shop.png">主办单位：<font color="#666"><?php  echo $activity['unit'];?></font></div>

        

        <div class="msgDiv"><img src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/images/icon-time.png">活动时间：<?php  if(TIMESTAMP < strtotime($activity['endtime'])) { ?><?php  echo date('m月d日 H:i',strtotime($activity['starttime']))?>~<?php  echo date('m月d日 H:i',strtotime($activity['endtime']))?>

        <?php  } else { ?><font color="#c3c3c3">活动结束</font><?php  } ?></div>

        <?php  if($activity['lng']!='' && $activity['lng']!='lat') { ?>

        <a href="http://api.map.baidu.com/marker?location=<?php  echo $activity['lat'];?>,<?php  echo $activity['lng'];?>&content=<?php  echo $activity['address'];?>&title=<?php  echo $activity['unit'];?>&output=html&src=weiba|weiweb" style="color:#46cec0;"><div class="msgDiv" style="margin-top:1px"><img style="vertical-align:top;margin-top:3px" src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/images/icon-address.png">点击查看活动地址</div></a><?php  } ?>

        <?php  if($activity['tel']!='') { ?>

        <a href="tel:<?php  echo $activity['tel'];?>" style="color:#46cec0">

        <div class="msgDiv" style="margin-top:1px"><img style="vertical-align:top;margin-top:3px" src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/images/icon-tel.png">点击咨询</div></a>

        <?php  } ?>

        <div class="M_detail">

        <div class="mod_tab"><span>活动说明</span></div>

        <div class="M_detail-con">

        <?php  echo $activity['detail'];?>

        </div>

        <!-- 评论待定 -->

        </div>

    </div>
<p style="text-align:center;color:gray"></p>
</div>

</div>

<div id="cover"></div>

<div id="guide"><img src="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/images/guide.png"></div>

  <script>

	//nav激活

	mui.init();

	mui('.mui-bar-tab').on('tap', 'a',

	function() {

		var $this = $(this);

		if (this.getAttribute('href') != null) {

			console.log(this.getAttribute('href'));

			location.href = this.getAttribute('href');

			if(typeof($this.attr('data'))=="undefined"){

				return false;

			}

		} else {

			return false;

		}

	})

	


	//报名框浮动

	//window.onscroll = function () {Scroll();}

	$('.mui-content').on('scroll',function() {Scroll();});

	function Scroll() {

		//var Y = $(".basic-box").height() + 220;

		//alert($('.mui-content').scrollTop());

		var Y = $(".swiper-container").height();

		if ($(".mui-content").scrollTop() >= Y) {

			$(".box-float").css({"position":"fixed","top":"0","display":"block","padding":"10px 2%","width":"100%","box-shadow":"0px 0px 4px #999","background":"rgba(255,255,255,0.98)"});

			$(".box-fixed").css({"display":"none"});

		} else {

			$(".box-float").css({"position":"relative","width":"100%","display":"none","box-shadow":"0px 0px 0px","padding":"10px 2%"});

			$(".box-fixed").css({"display":"block"});

		}

	}

	//轮播图开启

	var swiperx = new Swiper(".swiper-container", {

		loop: true,

		autoplay: 3000

	});

	//全屏遮盖支持内容滑动

	var _system = {

		$: function(id) {

			return document.getElementById(id);

		},

		_client: function() {

			return {

				w: document.documentElement.scrollWidth,

				h: document.documentElement.scrollHeight,

				bw: document.documentElement.clientWidth,

				bh: document.documentElement.clientHeight

			};

		},

		_scroll: function() {

			return {

				x: document.documentElement.scrollLeft ? document.documentElement.scrollLeft: document.body.scrollLeft,

				y: document.documentElement.scrollTop ? document.documentElement.scrollTop: document.body.scrollTop

			};

		},

		_cover: function(show) {

			if (show) {

				this.$("cover").style.display = "block";

				this.$("cover").style.width = (this._client().bw > this._client().w ? this._client().bw: this._client().w) + "px";

				this.$("cover").style.height = (this._client().bh > this._client().h ? this._client().bh: this._client().h) + "px";

			} else {

				this.$("cover").style.display = "none";

			}

		},

		_guide: function(click) {

			this._cover(true);

			this.$("guide").style.display = "block";

			this.$("guide").style.top = (_system._scroll().y + 5) + "px";

			window.onresize = function() {

				_system._cover(true);

				_system.$("guide").style.top = (_system._scroll().y + 5) + "px";

			};

			if (click) {

				_system.$("cover").onclick = function() {

					_system._cover();

					_system.$("guide").style.display = "none";

					_system.$("cover").onclick = null;

					window.onresize = null;

				};

			}

		},

		_zero:function(n){

			return n<0?0:n;

		}

	}

  </script>





</body>
</html>
	