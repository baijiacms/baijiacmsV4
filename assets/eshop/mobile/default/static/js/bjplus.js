core_toQueryPair = function(key, value) { 
        if (typeof value == 'undefined'){ 
        return key; 
        }  
        return key + '=' + encodeURIComponent(value === null ? '' : String(value)); 
    } 
 function core_toQueryString(obj) {
      
                var ret = []; 
                for(var key in obj){ 
                    key = encodeURIComponent(key); 
                    var values = obj[key]; 
                    if(values && values.constructor == Array){//数组 
                         var queryValues = []; 
                          for (var i = 0, len = values.length, value; i < len; i++) { 
                             value = values[i]; 
                             queryValues.push(core_toQueryPair(key, value)); 
                           } 
                          ret = concat(queryValues); 
                         }else{ //字符串 
                         ret.push(core_toQueryPair(key, values)); 
                    } 
               }
           return ret.join('&'); 
    } 
	function core_json(url, args, callback,ispost,ispost2)
	{
		 var url = url;
		 if(ispost)
		 	{
		}else{
		 if(ispost2)
		 	{
		 		ispost=true;
			}
		}
		if(ispost)
		{
		}else{
		        if(args ){
		        	var params=args;
            if(typeof(params)=='object') {
                  url+="&" + core_toQueryString(params);
            }  else if(typeof(params)=='string'){
                url+="&" + params
            }
        }
      }
	      var op = {
            url: url,
                type:ispost?'post':'get',
            dataType: 'json',cache:false,
            beforeSend:function(){
           
            },
            error:function(){
            }
        }

          if (args && ispost) {
            op.data = args;
        }
        
        if (callback) {
           
            op.success = function(data) {
                callback(data);
            }
        }
   

        $.ajax(op);
	}
	
	function tpl(tpldata,datas)
	{
		return template(tpldata,datas);
	}
  function tip_show(msg, position, duration) {

            if(!msg){
                var m=document.getElementById('core_show_div');
                    var d = 0.2;
                    m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
                    m.style.opacity = '0';
                    setTimeout(function() {
                        document.body.removeChild(m)
                    }, d * 1000);
                    return;
            }
           if(position!='bottom' && position!='middle' && position!='top'){
               position ='bottom';
           }
           
            duration = isNaN(duration) ? 1000 : duration;
            var m = document.createElement('div');
            m.id = 'core_show_div';
            m.innerHTML = msg;
            var css = "width:60%; font-size:14px;min-width:150px; background:#000; opacity:0.7; min-height:35px; overflow:hidden; color:#fff; line-height:35px; text-align:center; border-radius:5px; position:fixed; left:20%; z-index:999999;box-shadow:3px 3px 4px #d9d9d9;-webkit-box-shadow: 3px 3px 4px #d9d9d9;-moz-box-shadow: 3px 3px 4px #d9d9d9;";
            if(position=='top'){
                css+="top:10%; ";
            } else if(position=='bottom'){
                 css+="bottom:10%; ";
            } else if(position=='middle'){
                 css+="top:50%;margin-top:-18px;";
            }
            m.style.cssText = css;
            document.body.appendChild(m);
            if(duration!=0){
                setTimeout(function() {
                    var d = 0.2;
                    m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
                    m.style.opacity = '0';
                    setTimeout(function() {
                        document.body.removeChild(m)
                    }, d * 1000);
                }, duration);
            }

        }
        function tip_confirm(msg,callback){
            
            var html = '<div id="core_alert"><div class="layer"></div><div class="tips"><div class="title">';
            html+=msg;
            html+='</div><div class="sub"><nav data-action="cancel">取消</nav><nav data-action="ok">确定</nav>';
            html+='</div></div></div>';
            if($('#core_alert').length>0){
                $('#core_alert').remove();
            }
            var div =$(html);
           $(document.body).append(div);
            $('.layer',div).fadeIn(100);$('.tips',div).fadeIn(100);
            div.find('nav').unbind('click').click(function(){
                
                var action=$(this).data('action');
                if(action=='ok'){
                    if(callback){
                        callback();
                    }
                }
                div.remove();
            });
            
        }
        function tip_alert(msg,callback){
          
            var html = '<div id="core_alert"><div class="layer"></div><div class="tips"><div class="title">';
            html+=msg;
            html+='</div><div class="sub"><nav data-action="ok">确定</nav>';
            html+='</div></div></div>';

            if($('#core_alert').length>0){
                $('#core_alert').remove();
            }
            var div =$(html);
            $(document.body).append(div);
            $('.layer',div).fadeIn(100);$('.tips',div).fadeIn(100);
           
            div.find('nav').unbind('click').click(function(){
               
                var action=$(this).data('action');
                if(action=='ok'){
                    if(callback){
                        callback();
                    }
                     div.remove();
                }
            });
        
    }
    //页面提示
   function tip_message(message,url,type,js) {
        
        
         tip_alert(message,function () {location.href =url});
}