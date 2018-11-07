<?php defined('IN_IA') or exit('Access Denied');?> <?php  if(empty($item['statusvalue'])) { ?>
                             <!--未付款-->
				  
                            
				<?php  if($item['paytypevalue']==3) { ?>
				<div>
					   <input class='addressdata' type='hidden' value='<?php  echo json_encode($item['addressdata'])?>'  />
                                        <input class='itemid'  type='hidden' value="<?php  echo $item['id'];?>"  />
                                         <a class="btn btn-primary btn-sm" href="javascript:;" onclick="send(this)" data-toggle="modal" data-target="#modal-confirmsend">确认发货</a>
										 </div>
				<?php  } else { ?>
                                <a class="btn btn-primary btn-sm" href="<?php  echo $this->createWebUrl('order', array('op' => 'deal','to'=>'confirmpay','id' => $item['id']))?>" onclick="return confirm('确认此订单已付款吗？');return false;">确认付款</a>
                               <?php  } ?>
							   
                          
                            
                            <?php  } else if($item['statusvalue'] == 1) { ?>
                               <!--已付款-->
                            
                                <?php  if(!empty($item['addressid']) ) { ?>
                                      <!--快递 发货-->
                                      
                                        <div>
                                        <input class='addressdata' type='hidden' value='<?php  echo json_encode($item['addressdata'])?>'  />
                                        <input class='itemid'  type='hidden' value="<?php  echo $item['id'];?>"  />
                                        <a class="btn btn-primary btn-sm" href="javascript:;" onclick="send(this)" data-toggle="modal" data-target="#modal-confirmsend">确认发货</a>
                                        </div>
                                  
                                <?php  } else { ?>
                                        <?php  if($item['isverify']==1) { ?>
                                            <!--核销 确认核销-->
                                            
                                                 <a class="btn btn-primary btn-sm" href="<?php  echo $this->createWebUrl('order', array('op' => 'deal','act'=>'list','to'=>'confirmsend1','id' => $item['id']))?>" onclick="return confirm('确认使用吗？');return false;">确认使用</a>
                                         
                                        <?php  } else { ?>
                                            <!--自提 确认取货-->
                                           
                                                 <a class="btn btn-primary btn-sm" href="<?php  echo $this->createWebUrl('order', array('op' => 'deal','act'=>'list','to'=>'confirmsend1','id' => $item['id']))?>" onclick="return confirm('确认取货吗？');return false;">确认取货</a>
                                         
                                        <?php  } ?>
                                
                                <?php  } ?>
                                
                            
                            <?php  } else if($item['statusvalue'] == 2) { ?>
                                       <!--已发货-->
                                <?php  if(!empty($item['addressid'])) { ?>
                                 <!--快递 取消发货-->
                               
                                      <a class="btn btn-danger btn-sm" href="javascript:;" onclick="$('#modal-cancelsend').find(':input[name=id]').val('<?php  echo $item['id'];?>')" data-toggle="modal" data-target="#modal-cancelsend">取消发货</a>
                              
                               
                                       <a class="btn btn-primary btn-sm" href="<?php  echo $this->createWebUrl('order', array('op' => 'deal','act'=>'list','to'=>'finish','id' => $item['id']))?>" onclick="return confirm('确认订单收货吗？');return false;">确认收货</a>
                              
                                 
                                <?php  } ?>
                                
                            <?php  } else if($item['statusvalue'] == 3) { ?>
 
                            <?php  } ?>
