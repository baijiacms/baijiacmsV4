<?php defined('IN_IA') or exit('Access Denied');?>
	<?php  if(is_array($articles)) { foreach($articles as $k => $v) { ?>
		<div class="list-number">
			<?php  if(count($v['articles'])==1) { ?>
				<a href="<?php  echo create_url('mobile',array('act' => 'article','do' => 'article', 'id' => $v['articles'][0]['id']))?>" class="external">
					<div class="fui-card">
						<div class="fui-card-title">
							<span class="title"><?php  echo $v['articles'][0]['article_title'];?></span>
							<span class="subtitle"><?php  echo $k;?></span>
						</div>
						<?php  if(!empty($v['articles'][0]['resp_img'])) { ?>
							<div class="fui-card-image">
								<img src="<?php  echo tomedia($v['articles'][0]['resp_img'])?>">
							</div>
						<?php  } ?>
						<div class="fui-card-content"><?php  echo $v['articles'][0]['resp_desc'];?></div>
						<div class="fui-card-footer">
							<span class="text">点击查看详情</span>
							<span class="remark"></span>
						</div>
					</div>
				</a>
			<?php  } else { ?>
				<div class="fui-card fui-card-list">
					<?php  if(is_array($v['articles'])) { foreach($v['articles'] as $index => $vv) { ?>
						<?php  if($index==0) { ?>
							<a href="<?php  echo create_url('mobile',array('act' => 'article','do' => 'article', 'id' => $vv['id']))?>" class="external">
								<div class="fui-card-info">
									<div class="image">
										<img src="<?php  echo tomedia($vv['resp_img'])?>" />
									</div>
									<div class="text">
										<span class="subtitle"><?php  echo $k;?></span>
									</div> 
								</div>
								<div class="fui-card-first">
									<div class="image">
										<img src="<?php  echo tomedia($vv['resp_img'])?>" />
										<div class="text"><?php  echo $vv['article_title'];?></div>
									</div>
								</div>
							</a>
						<?php  } else { ?>
							<a href="<?php  echo create_url('mobile',array('act' => 'article','do' => 'article', 'id' => $vv['id']))?>" class="external">
								<div class="fui-card-item">
									<img src="<?php  echo tomedia($vv['resp_img'])?>" />
									<div class="text"><?php  echo $vv['article_title'];?></div>
								</div>
							</a>
						<?php  } ?>
					<?php  } } ?>
				 </div>
			<?php  } ?>
		</div>
	<?php  } } ?>