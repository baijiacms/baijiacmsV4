<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<?php  if($operation == 'post') { ?>
<script language='javascript' src="<?php echo RESOURCE_ROOT;?>eshop/poster/js/designer.js"></script>
<script language='javascript' src="<?php echo RESOURCE_ROOT;?>eshop/poster/js/jquery.contextMenu.js"></script>
<link href="<?php echo RESOURCE_ROOT;?>eshop/poster/js/jquery.contextMenu.css" rel="stylesheet">
<style type='text/css'>
    #poster {
        width:320px;height:504px;border:1px solid #ccc;position:relative
    }
   #poster .bg { position:absolute;width:100%;z-index:0}
   #poster .drag[type=img] img,#poster .drag[type=thumb] img { width:100%;height:100%; }

   #poster .drag { position: absolute; width:80px;height:80px; border:1px solid #000; }

    
    #poster .drag[type=nickname] { width:80px;height:40px; font-size:16px; font-family: 黑体;}
    #poster .drag img {position:absolute;z-index:0;width:100%; }
    
    #poster .rRightDown,.rLeftDown,.rLeftUp,.rRightUp,.rRight,.rLeft,.rUp,.rDown{
            position:absolute;
            width:7px;
            height:7px;
            z-index:1;
            font-size:0;
    }    
 
 
       #poster .rRightDown,.rLeftDown,.rLeftUp,.rRightUp,.rRight,.rLeft,.rUp,.rDown{
              background:#C00;
       }

    .rLeftDown,.rRightUp{cursor:ne-resize;}
    .rRightDown,.rLeftUp{cursor:nw-resize;}
    .rRight,.rLeft{cursor:e-resize;}
    .rUp,.rDown{cursor:n-resize;}
    .rLeftDown{left:-4px;bottom:-4px;}
    .rRightUp{right:-4px;top:-4px;}
    .rRightDown{right:-4px;bottom:-4px;}
   
            .rRightDown{background-color:#00F;}   

    
    .rLeftUp{left:-4px;top:-4px;}
    .rRight{right:-4px;top:50%;margin-top:-4px;}
    .rLeft{left:-4px;top:50%;margin-top:-4px;}
    .rUp{top:-4px;left:50%;margin-left:-4px;}
    .rDown{bottom:-4px;left:50%;margin-left:-4px;}
    .context-menu-layer { z-index:9999;}
    .context-menu-list { z-index:9999;}

</style>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class='panel'>
         	<h3 class="custom_page_header">海报设置 </h3>
          
            <div class='panel-body'>
    
                
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报名称</label>
                    <div class="col-sm-9 col-xs-12">
                   
                        <input type="text" name="title" class="form-control" value="<?php  echo $item['title'];?>" />
                     
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报类型</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1" <?php  if(empty($item['type'])||$item['type']==1) { ?>checked<?php  } ?> /> 商城海报
                        </label>
              
                           
                        <label class="radio-inline"> 
                            <input type="radio" name="type" value="4" <?php  if($item['type']==4) { ?>checked<?php  } ?> /> 微信关注海报
                        </label>
                          
                    </div> 
                </div> 
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 微信二维码生成关键词</label>
                    <div class="col-sm-9 col-xs-12">
                  
                        <input type="text" name="keyword" class="form-control" value="<?php  echo $item['keyword'];?>" />
                         
                    </div>
                </div>
              
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否默认</label>
                    <div class="col-sm-9 col-xs-12">
                          
                        <label class="radio-inline">
                            <input type="radio" name="isdefault" value="1" <?php  if($item['isdefault']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="isdefault" value="0" <?php  if(empty($item['isdefault'])) { ?>checked<?php  } ?> /> 否
                        </label>
                        <span class='help-block'>是否是海报类型的默认设置，一种海报只能一个默认设置</span>
                        
                    </div> 
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开发权限</label>
                    <div class="col-sm-9 col-xs-12">
                          
                        <label class="radio-inline">
                            <input type="radio" name="isopen" value="1" <?php  if($item['isopen']==1) { ?>checked<?php  } ?> /> 允许
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="isopen" value="0" <?php  if(empty($item['isopen'])) { ?>checked<?php  } ?> /> 不允许
                        </label>
                        <span class='help-block'>是否允许非分销商生成自己的海报</span>
                        
                    </div> 
                </div>
                     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报设计</label>
                    <div class="col-sm-9 col-xs-12">
                        <table style='width:100%;'>
                                <tr>
                                    <td style='width:320px;padding:10px;' valign='top'>
                                        <div id='poster'>
                                          <?php  if(!empty($item['bg'])) { ?>
                                          <img src='<?php  echo tomedia($item['bg'])?>' class='bg'/>
                                          <?php  } ?>
                                          <?php  if(!empty($data)) { ?>
                                          <?php  if(is_array($data)) { foreach($data as $key => $d) { ?>
                                       
                                          <div class="drag" type="<?php  echo $d['type'];?>" index="<?php  echo $key+1?>" style="zindex:<?php  echo $key+1?>;left:<?php  echo $d['left'];?>;top:<?php  echo $d['top'];?>;
                                               width:<?php  echo $d['width'];?>;height:<?php  echo $d['height'];?>" 
                                               src="<?php  echo $d['src'];?>" size="<?php  echo $d['size'];?>" color="<?php  echo $d['color'];?>"
                                               > 
                                               <?php  if($d['type']=='qr') { ?>
                                                 <img src="<?php echo RESOURCE_ROOT;?>eshop/poster/images/qr.jpg" />
                                               <?php  } else if($d['type']=='head') { ?>
                                                  <img src="<?php echo RESOURCE_ROOT;?>eshop/poster/images/head.jpg" />
                                                <?php  } else if($d['type']=='img' || $d['type']=='thumb') { ?>
                                                  <img src="<?php echo empty($d['src'])?'<?php echo RESOURCE_ROOT;?>eshop/poster/images/img.jpg':tomedia($d['src'])?>" />
                                                <?php  } else if($d['type']=='nickname') { ?>
                                                   <div class=text style="font-size:<?php  echo $d['size'];?>;color:<?php  echo $d['color'];?>">昵称</div> 
                                                   <?php  } ?>
                                              <div class="rRightDown"> </div><div class="rLeftDown"> </div><div class="rRightUp"> </div><div class="rLeftUp"> </div><div class="rRight"> </div><div class="rLeft"> </div><div class="rUp"> </div><div class="rDown"></div>
                                          </div>
                                          <?php  } } ?> 
                                          <?php  } ?>
                                        </div>
                                        
                                    </td>
                                    <td valign='top' style='padding:10px;'>
                                     
                                          <div class='panel panel-default'>
                                              <div class='panel-body'>
                                                <div class="form-group" id="bgset">
                                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图片</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                       <?php  echo tpl_form_field_image('bg',$item['bg'])?>
                                                       <span class='help-block'>背景图片尺寸: 640 * 1008</span>
                                                    </div>
                                                
                                                    
                                                </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">海报元素</label>
                                                        <div class="col-sm-9 col-xs-12">
                                                             <button class='btn btn-default btn-com' type='button' data-type='head' >头像</button>
                                                             <button class='btn btn-default btn-com' type='button' data-type='nickname' >昵称</button>
                                                             <button class='btn btn-default btn-com' type='button' data-type='qr' >二维码</button>
                                                             <button class='btn btn-default btn-com' type='button' data-type='img' >图片</button>
                                                           
                                                        </div>
                                                    </div>
                                                  <div id='qrset' style='display:none'>
                                                   <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码尺寸</label>
                                                         <div class="col-sm-9 col-xs-12">
                                                             <select id='qrsize' class='form-control'>
                                                                 <option value='1'>1</option>
                                                                 <option value='2'>2</option>
                                                                 <option value='3'>3</option>
                                                                 <option value='4'>4</option>
                                                                 <option value='5'>5</option>
                                                                 <option value='6'>6</option>
                                                             </select>
                                                        </div>
                                                    
                                                    </div>
                                                  </div>
                                                  
                                                  <div id='nameset' style='display:none'>
                                                   <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称颜色</label>
                                                         <div class="col-sm-9 col-xs-12">
                                                              <?php  echo tpl_form_field_color('color')?>
                                                        </div>
                                                    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称大小</label>
                                                        <div class="col-sm-4">
                                                             <div class='input-group'>
                                                                 <input type="text" id="namesize" class="form-control namesize" placeholder="例如: 14,16"  />
                                                                 <div class='input-group-addon'>px</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                             </div>
                                                     <div class="form-group" id="imgset" style="display:none">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">图片设置</label>
                                                        <div class="col-sm-9 col-xs-12">
                                                              <?php  echo tpl_form_field_image('img')?>
                                                        </div>
                                                    </div>
                                       
                                          </div>
                                   </div>
                                   
                                    </td>
                                </tr>
                        </table>
                    </div>
                     </div>
                       
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">生成等待文字</label>
                    <div class="col-sm-9 col-xs-12">
                                    <input type="text" class="form-control"  name="waittext"  value="<?php  echo $item['waittext'];?>" />
							         <span class="help-block">例如：您的专属海报正在拼命生成中，请等待片刻...</span>
                        
                  
                    </div>
                </div>

                       
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                            <input type="hidden" name="data" value="" />
                 
                       <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default" />
                    </div>
            </div>
            </div>
   
        </div>
 
    </form> 
</div>


				
<script language='javascript'>
    $('form').submit(function(){
        if($(':input[name=title]').isEmpty()){
            Tip.focus($(':input[name=title]'),'请输入海报名称!');
            return false;
        }
        if($(':input[name=type]:checked').length<=0){
            Tip.focus($(':input[name=title]'),'请选择海报类型!');
            return false;
        }
         if($(':input[name=keyword]').isEmpty()){
            Tip.focus($(':input[name=keyword]'),'请输入回复关键词!');
            return false;
        }

        var data = [];
        $('.drag').each(function(){
            var obj = $(this);
            var type = obj.attr('type');
            var left = obj.css('left'),top = obj.css('top');
            var d= {left:left,top:top,type:obj.attr('type'),width:obj.css('width'),height:obj.css('height')};
            if(type=='nickname' ||type=='title' || type=='marketprice' || type=='productprice'){
                d.size = obj.attr('size');
                d.color = obj.attr('color');
            } else if(type=='qr'){
                d.size = obj.attr('size');
            } else if(type=='img'){
                d.src = obj.attr('src');
            }
            data.push(d);
        });
        $(':input[name=data]').val( JSON.stringify(data));
    
        return true;
    });
        
        function bindEvents(obj){
            
              var index = obj.attr('index');
              
                 var rs = new Resize(obj, { Max: true, mxContainer: "#poster" });
            rs.Set($(".rRightDown",obj), "right-down");
            rs.Set($(".rLeftDown",obj), "left-down");
            rs.Set($(".rRightUp",obj), "right-up");
            rs.Set($(".rLeftUp",obj), "left-up");
            rs.Set($(".rRight",obj), "right");
            rs.Set($(".rLeft",obj), "left");
            rs.Set($(".rUp",obj), "up");
            rs.Set($(".rDown",obj), "down"); 
            rs.Scale = true;
            var type = obj.attr('type');
            if(type=='nickname' || type=='img' || type=='title' || type=='marketprice' || type=='productprice'){
                rs.Scale = false;
            }
            new Drag(obj, { Limit: true, mxContainer: "#poster" });
            $('.drag .remove').unbind('click').click(function(){
                $(this).parent().remove();
            })
        
         $.contextMenu({
                selector: '.drag[index=' + index + ']',
                callback: function(key, options) {
                    var index = parseInt($(this).attr('zindex'));
                    
                    if(key=='next'){
                        var nextdiv = $(this).next('.drag');
                        if(nextdiv.length>0 ){
                           nextdiv.insertBefore($(this));  
                        }
                    } else if(key=='prev'){
                        var prevdiv = $(this).prev('.drag');
                        if(prevdiv.length>0 ){
                           $(this).insertBefore(prevdiv);  
                        } 
                    } else if(key=='last'){
                        var len = $('.drag').length;
                         if(index >=len-1){
                            return;
                        } 
                        var last = $('#poster .drag:last');
                        if(last.length>0){
                           $(this).insertAfter(last);  
                        }
                    }else if(key=='first'){
                        var index = $(this).index();
                        if(index<=1){
                            return;
                        }
                        var first = $('#poster .drag:first');
                        if(first.length>0){
                           $(this).insertBefore(first);  
                        }
                    }else if(key=='delete'){
                       $(this).remove();
                    }
                    var n =1 ;
                    $('.drag').each(function(){
                        $(this).css("z-index",n);
                        n++; 
                    })
                },
                items: {
                    "next": {name: "调整到上层"},
                    "prev": {name: "调整到下层"},
                    "last": {name: "调整到最顶层"},
                    "first": {name: "调整到最低层"},
                    "delete": {name: "删除元素"}
                }
            });
            obj.unbind('click').click(function(){
                bind($(this));
            })
            
              
              
        }
   var imgsettimer = 0 ;
   var nametimer = 0;
   var bgtimer = 0 ;
      
         function clearTimers(){
           clearInterval(imgsettimer);
           clearInterval(nametimer);
           clearInterval(bgtimer);
           
         }
         function getImgUrl(val){
       
              if(val.indexOf('http://')==-1){
                  val = "<?php  echo ATTACHMENT_WEBROOT;?>" + val;
              }
              return val;
         }
         function bind(obj){
            var imgset = $('#imgset'), nameset = $("#nameset"),qrset = $('#qrset');
             imgset.hide(),nameset.hide(),qrset.hide();
             clearTimers();
               var type = obj.attr('type');
               if(type=='img'){
                   imgset.show();
                   var src = obj.attr('src');
                   var input = imgset.find('input');
                   var img = imgset.find('img');
                   if(typeof(src)!='undefined' && src!=''){
                       input.val(src); 
                       img.attr('src',getImgUrl(src));
                  }
                   
                   imgsettimer = setInterval(function(){
                       if(input.val()!=src && input.val()!=''){
                           var url = getImgUrl(input.val());
                         
                           obj.attr('src',input.val()).find('img').attr('src',url);
                       }
                   },10);
                   
             } else if(type=='nickname' || type=='title' || type=='marketprice' || type=='productprice'){
       
                  nameset.show();
                  var color = obj.attr('color') || "#000";
                  var size = obj.attr('size') || "16";
                  var input = nameset.find('input:first');
                  var namesize = nameset.find('#namesize');
                  var picker = nameset.find('.sp-preview-inner');
                  input.val(color); namesize.val(size.replace("px",""));  
                  picker.css( {'background-color':color,'font-size':size});
                      
                  nametimer = setInterval(function(){
                       obj.attr('color',input.val()).find('.text').css('color',input.val());
                       obj.attr('size',namesize.val() +"px").find('.text').css('font-size',namesize.val() +"px");
                   },10);
                   
             } else if(type=='qr'){
                 qrset.show();
                 var size = obj.attr('size') || "3";
                 var sel = qrset.find('#qrsize');
                 sel.val(size);
                 sel.unbind('change').change(function(){
                      obj.attr('size',sel.val()) 
                 });
             }  
         }
         
    $(function(){
        <?php  if(!empty($item['id'])) { ?>
         
          $('.drag').each(function(){
              bindEvents($(this));
          })
   
        <?php  } ?>
            
          
        //改变背景
        $('#bgset').find('button:first').click(function(){
            var oldbg = $(':input[name=bg]').val();
            bgtimer = setInterval(function(){
                 var bg = $(':input[name=bg]').val();
                 if(oldbg!=bg){
                 	  bg = getImgUrl(bg);
                       
                      $('#poster .bg').remove();
                      var bgh = $("<img src='" + bg + "' class='bg' />");
                       var first = $('#poster .drag:first');
                        if(first.length>0){
                           bgh.insertBefore(first);  
                        } else{
                           $('#poster').append(bgh);      
                        }
                       
                      oldbg = bg;
                 }
            },10);
        })
           
        $('.btn-com').click(function(){
            
           var imgset = $('#imgset'), nameset = $("#nameset"),qrset = $('#qrset');
           imgset.hide(),nameset.hide(),qrset.hide();
           clearTimers();
      
            if($('#poster img').length<=0){
                //alert('请选择背景图片!');
                //return;
            }
            var type = $(this).data('type');
            var img = "";
            if(type=='qr'){
                img = '<img src="<?php echo RESOURCE_ROOT;?>eshop/poster/images/qr.jpg" />';
            }
            else if(type=='head'){
                img = '<img src="<?php echo RESOURCE_ROOT;?>eshop/poster/images/head.jpg" />';
            }else  if(type=='img' || type=='thumb'){
                img = '<img src="<?php echo RESOURCE_ROOT;?>eshop/poster/images/img.jpg" />';
            } 
            else if(type=='nickname'){
                img = '<div class=text>昵称</div>';
            }  
            var index = $('#poster .drag').length+1;
            var obj = $('<div class="drag" type="' + type +'" index="' + index +'" style="z-index:' + index+'">' + img+'<div class="rRightDown"> </div><div class="rLeftDown"> </div><div class="rRightUp"> </div><div class="rLeftUp"> </div><div class="rRight"> </div><div class="rLeft"> </div><div class="rUp"> </div><div class="rDown"></div></div>');
            
            $('#poster').append(obj);
            
            bindEvents(obj);
            
        });
    
         $('.drag').click(function(){
               bind($(this))     ;
         })
        
    })
	
	
    </script>
<?php  } else if($operation == 'display') { ?>
 
            <form action="" method="post" onsubmit="return formcheck(this)">
     <div class='panel'>
     	<h3 class="custom_page_header">推广海报    <a class='btn btn-default' href="<?php  echo $this->createWebUrl('poster', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加海报</a>
                     
                        
                 <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                       </h3>
     
     
         <div class='panel-body'>
   
            <table class="table">
                <thead>
                    <tr>
                        <th>海报名称</th>
                        <th>海报类型</th>
                        <th>扫描次数</th>
                        <th>吸引关注数</th>
                        <th>是否默认</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><?php  echo $row['title'];?></td>
                        <td>
                            <?php  if($row['type']==1) { ?>
                            <label class='label label-primary'>商城</label>
                            <?php  } else if($row['type']==4) { ?>
                            <label class='label label-danger'>关注</label>
                         
                            <?php  } ?>
                        </td>
                        <td><?php  echo $row['times'];?></td>
                        <td><?php  echo $row['follows'];?></td>
                            <td>
                                   <?php  if($row['isdefault']==1) { ?>
                                   <i class='fa fa-check' style='color:green'></i> 
                          <?php  } ?>
                        </td>
                        <td>
                        

				 <?php  if($row['type']==4) { ?>
				<a class='btn btn-default' href="<?php  echo $this->createWebUrl('poster/log', array('id' => $row['id']))?>"  title='关注记录'><i class='fa fa-qrcode'></i></a>
				<?php  } else { ?>
				<a class='btn btn-default' href="<?php  echo $this->createWebUrl('poster/scan', array('id' => $row['id']))?>"  title='扫描记录'><i class='fa fa-qrcode'></i></a>
				<?php  } ?>
                     
							
                                <a class='btn btn-default' href="<?php  echo $this->createWebUrl('poster', array('op' => 'post', 'id' => $row['id']))?>" title='编辑'><i class='fa fa-edit'></i></a>
                                <a class='btn btn-default' href="<?php  echo $this->createWebUrl('poster', array('op' => 'setdefault', 'id' => $row['id']))?>"  title='设置默认' onclick="return confirm('确认设置此海报为默认海报吗？');return false;"><i class='fa fa-check'></i></a>
                                <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('poster', array('op' => 'delete', 'id' => $row['id']))?>"  title='删除' onclick="return confirm('确认删除此海报吗？');return false;"><i class='fa fa-remove'></i></a></td>
                         

                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
  <?php  echo $pager;?>
         </div>
      
     </div>
         </form> 
<?php  } ?>
<?php include page("footer-base");?>
