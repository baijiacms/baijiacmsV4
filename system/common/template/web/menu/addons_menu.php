<?php defined('IN_IA') or exit('Access Denied');?>
<?php 
  
  $modulelist = mysqld_selectall("SELECT *,'' as menus FROM " . table('modules') . " where 1=1  and icon!='hidden' order by displayorder");
		foreach($modulelist as $index => $module)  
							{
		
	
					
					
						$modulelist[$index]['menus']=mysqld_selectall("SELECT * FROM " . table('modules_menu') . " WHERE `module`=:module order by id",array(':module'=>$module['name']));
					
		

	
		
		}
   if(is_array($modulelist)) { foreach($modulelist as $module) { if(!empty($module['menus'])){
                               
                                   	?>
                                   	
                                   	<h3>
						<i class="main_i_icon1 fa fa-plug"></i><?php  echo $module['title'] ?>
					</h3>
                                   	
                                   	 		<ul>
					
			
            <?php if (!function_exists('addons_url_exploder')) {
                   	function addons_url_exploder($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}
              }          
             foreach($module['menus'] as $menu) { ?>
                               <li 	<?php  $addons_urls=parse_url(WEBSITE_ROOT.$menu['href']);
                             	
                               $addons_url=addons_url_exploder($addons_urls['query']); if($_GPC['act'] == $addons_url['act']&&$_GPC['do'] == $addons_url['do'] ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo $menu['href'] ?>"><?php  echo $menu['title'] ?> </a>           	
                                   	          </li>   <?php  } ?> 

    
                                               
                                     
                	</ul>     <?php  } }} ?>    	
          	       
            