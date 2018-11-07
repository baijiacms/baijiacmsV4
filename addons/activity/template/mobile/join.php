<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include addons_page('share');?>
     <title><?php echo $pagetitle;?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/css/common.min.css?v=20160831">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_ROOT."addons/activity/";?>app/resource/components/mui/mui.ext.css">
    
    
    </head>

	<style type="text/css">

.pic img{display:inline-block;width:50%;max-width:100%;height:auto;padding:4px;line-height:1.42857143;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}

.pic .webuploader-pick{ font-size:14px;}

.pic .js-image-pic{ border-left:none;border-radius:0 4px 4px 0!important;padding: 3px 10px!important;}

.mui-bar a{color: #ff9900;}

.mui-btn{ border:none!important;padding: 10px;}

.mui-btn-primary{background-color: #ff9900;}



.mui-btn-primary:enabled:active{background-color: #ec7230!important;}



.mui-btn-cancel{color: #fff;background-color: #b8b8b8;}

.mui-textarea{ height:auto!important; width:100%;}

.area {margin: 20px auto 0px auto;}

.mui-input-group:first-child {margin-top: 20px;}

.mui-input-group label {width: 25%;}

.mui-input-row label~input,

.mui-input-row label~select,

.mui-input-row label~textarea {width: 75%;}

.mui-checkbox input[type=checkbox],

.mui-radio input[type=radio] {top: 6px;}

.mui-content-padded {margin-top: 25px;}

.mui-image-uploader .mui-upload-btn{width: 60px;height: 60px;}

.mui-image-uploader .mui-upload-btn .webuploader-pick{width: 60px;height: 60px; font-size:60px;}

.mui-image-uploader img{width: 60px;height: 60px; }

</style>

<body>



<header class="mui-bar mui-bar-nav">

    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" href="javascript:;" onclick="history.back()"></a>

    <h1 class="mui-title">报名信息填写</h1>

</header>

<div class="mui-content">

    <form class="mui-input-group"  action="" method="post" onSubmit="return check(this)" >
        <div class="mui-input-row">

            <label>姓名：</label>

            <input type="text" name="username" id="username" placeholder="请输入姓名">

        </div>

        <div class="mui-input-row">

            <label>手机：</label>

            <input type="text" name="mobile" id="mobile" placeholder="请输入手机号" data-input-clear="3">

            <span class="mui-icon mui-icon-clear mui-hidden"></span>

        </div>

        

     
        <div class="mui-input-row mui-textarea">

           <textarea id="textarea" name="msg" placeholder="请输入留言"></textarea>

        </div>
        

        <div class="mui-content-padded">

          <button type="submit" class="mui-btn mui-btn-block mui-btn-primary">提交报名</button>

          <button type="button" class="mui-btn mui-btn-block mui-btn-cancel" onClick="history.go(-1);">取　消</button>&nbsp;&nbsp;&nbsp;

          <input type="hidden" name="submit" value="提交报名"/>

          <input type="hidden" name="activityid" value="<?php  echo $activityid;?>" />

          <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />

        </div>
<p style="text-align:center;color:gray"></p>
    </form>

</div>



<script type="text/javascript">

	function check(form) {



		if (!form['username'].value) {

			util.alert('请输入姓名', ' ', function() {

				$("input[name='username']").focus();

			});

			return false;

		}

		

		if (!form['mobile'].value) {

			util.alert('请输入手机号', ' ', function() {

				$("input[name='mobile']").focus();

			});

			return false;

		}else{

			 var mobile = $('#mobile').val();

			 var pattern = /^1[34578]\d{9}$/; 

			  

		     if (!pattern.test(mobile)) {

					 util.alert('手机号不合法', ' ', function() {

						$("input[name='mobile']").focus();

					 });

					return false;

			 }

		}

		

		return true;

	}

	$(".pic input.form-control").attr('type','text');

	$(".pic .js-image-pic").addClass('input-group-btn');

</script>




</body>
</html>
	
	