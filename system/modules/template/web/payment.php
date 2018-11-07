<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header-base');?>
	  <div class="panel ">
        
            <h3 class="custom_page_header">支付方式设置</a>
       </h3>
<div class="panel-body">


<table class="table">
                <thead>
                    <tr>
                        <th class="text-center" >支付方式名称</th>
                        <th class="text-center">支付方式描述</th>
                        <th class="text-center" >操作</th>
                    </tr>
                </thead>
                 <tbody>
                 							<?php  if(is_array($modules)) { foreach($modules as $item) { ?>
				<tr>
					<td class="text-center"><?php  echo $_LANG['payment_'.$item['code'].'_name']?></td>
          <td class="text-center"><?php  echo $_LANG['payment_'.$item['code'].'_desc']?></td>
         <td class="text-center"><?php if(empty($item['enable'])||$item['enable']==0){?>
         	<a class="btn btn-default btn-sm"  href="<?php  echo create_url('site', array('act' => 'modules','do' => 'payment','op'=>'install','code'=>$item['code']))?>" >
                                   <i class="fa fa-cog"></i>&nbsp;启&nbsp;动&nbsp;                               
                                </a><?php }else{ ?>
                                	&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-sm"  href="<?php  echo create_url('site', array('act' => 'modules','do' => 'payment','op'=>'config','code'=>$item['code']))?>" >
                                   <i class="fa fa-pencil"></i>&nbsp;编&nbsp;辑  &nbsp;                           
                                </a>
                                 &nbsp;&nbsp;&nbsp;	<a class="btn btn-default btn-sm"  href="<?php  echo create_url('site', array('act' => 'modules','do' => 'payment','op'=>'uninstall','code'=>$item['code']))?>" >
                                  <i class="fa fa-times"></i>&nbsp;关&nbsp;闭&nbsp;                          
                                </a>
                                 <?php }?>  </td>
				</tr>
				<?php  } } ?>
                 	</tbody>
		</table>
		
		
</div>
</div>

<?php  include page('footer-base');?>
