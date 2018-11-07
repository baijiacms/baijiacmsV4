<?php defined('IN_IA') or exit('Access Denied');?> 

<script language="javascript">
    require(['bootstrap'], function ($) {});
     $(function(){
          
            var height1=$(".main_wrap").height(); 
            var height2=$(".main_tgy").height();
            if(parseInt(height1) > parseInt(height2)){
                $(".main_tgy").css({'min-height': (height1+50)});
            };
            
          });
</script>

 
			</div>


		</div>
	</div>

</body>
</html>