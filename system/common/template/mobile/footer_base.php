<?php defined('IN_IA') or exit('Access Denied');?>

<script id='tpl_show_message' type='text/html'><div class="sweet-alert" style="display:block;">
        <%if type=='error'%><div class="icon error animateErrorIcon" style="display: block;"><span class="x-mark animateXMark"><span class="line left"></span><span class="line right"></span></span></div><%/if%>
        <%if type=='warning'%><div class="icon warning pulseWarning" style="display: block;"><span class="body pulseWarningIns"></span><span class="dot pulseWarningIns"></span></div><%/if%>
        <%if type=='success'%><div class="icon success animate" style="display: block;"><span class="line tip animateSuccessTip"></span><span class="line long animateSuccessLong"></span><div class="placeholder"></div><div class="fix"></div></div><%/if%>
        <div class="info"><%message%><%if url%><br><span>如果您的浏览器没有自动跳转请点击此处</span><%/if%></div>
        
        <div class="sub" 
             <%if url%>
                    onclick="location.href='<%url%>'"
             <%else%>
                    <%if js%>
                        onclick="<%js%>"
                    <%else%>
                        onclick="history.back()"
                    <%/if%>
             <%/if%>
             >
        <%if type=='success'%><div class="green">确认</div><%/if%>
        <%if type=='warning'%><div class="grey">确认</div><%/if%>
        <%if type=='error'%><div class="red">确认</div><%/if%>
        </div></script>
      
		<span style='display:none'>
 <?php  $shopset = globalSetting('shop');?><?php  echo $shopset['diycode']?> 
 </span>
		
		
			<?php  if(!empty($shopset['kefuu'])){ ?>
       
  	
         	
         	<div class="fe-floatico fe-floatico-right" style="position: fixed; width: 60px; top: 300px;min-height: 10px;right: 0px;z-index: 1000;box-sizing: border-box;" ng-style="{'width':pages[0].params.floatwidth,'top':pages[0].params.floattop}" ng-class="{'fe-floatico-right':pages[0].params.floatstyle=='right'}" ng-show="pages[0].params.floatico==1">
            <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $shopset['kefuu']; ?>&site=qq&menu=yes" target="_parent">
                <img src=" <?php echo RESOURCE_ROOT;?>public/image/qq.png" ng-src="<?php echo RESOURCE_ROOT;?>public/image/qq.png" style="width:100%;">
            </a>
        </div>
         	    	<?php  } ?>

		
<script>
	$(function(){
	if(wxshare==true)
	{
		load_jwxshare();
	}
	});
	</script>
</body>
</html>