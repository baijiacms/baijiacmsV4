<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<div class="clearfix ng-cloak" id="js-reply-form" ng-controller="replyForm">

<form id="reply-form"  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 图文回复</h3>
        <div class='panel-body'>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">规则名称</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='entry[name]' value="<?php  echo $rule['name'];?>" />
                </div>
            </div>
            
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 触发关键词</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='entry[keyword]' value="<?php  echo $rule['keyword'];?>" />
                </div>
            </div>
      <script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/components/ueditor/ueditor.config.js"></script>
      <script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/components/ueditor/ueditor.all.min.js"></script>
      <script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/components/ueditor/lang/zh-cn/zh-cn.js"></script>
	<script type="text/javascript">
			var ueditoroption = {
				'autoClearinitialContent' : false,
				'toolbars' : [['fullscreen', 'source', 'preview', '|', 'bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', '|',
					'justifyleft', 'justifycenter', 'justifyright', '|', 'insertorderedlist', 'insertunorderedlist', 'blockquote', 'emotion', 'insertvideo',
					'link', 'removeformat', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight','indent', 'paragraph', 'fontsize', '|',
					'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol',
					'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|', 'anchor', 'map', 'print', 'drafts']],
				'elementPathEnabled' : false,
				'initialFrameHeight': 200,
				'focus' : false,
				'maximumWords' : 9999999999999
			};
			var opts = {
				type :'image',
				direct : false,
				multi : true,
				tabs : {
					'upload' : 'active',
					'browser' : '',
					'crawler' : ''
				},
				path : '',
				dest_dir : '',
				global : false,
				thumb : false,
				width : 0
			};
			UE.registerUI('myinsertimage',function(editor,uiName){
				editor.registerCommand(uiName, {
					execCommand:function(){
						require(['fileUploader'], function(uploader){
							uploader.show(function(imgs){
								if (imgs.length == 0) {
									return;
								} else if (imgs.length == 1) {
									editor.execCommand('insertimage', {
										'src' : imgs[0]['url'],
										'_src' : imgs[0]['attachment'],
										'width' : '100%',
										'alt' : imgs[0].filename
									});
								} else {
									var imglist = [];
									for (i in imgs) {
										imglist.push({
											'src' : imgs[i]['url'],
											'_src' : imgs[i]['attachment'],
											'width' : '100%',
											'alt' : imgs[i].filename
										});
									}
									editor.execCommand('insertimage', imglist);
								}
							}, opts);
						});
					}
				});
				var btn = new UE.ui.Button({
					name: '插入图片',
					title: '插入图片',
					cssRules :'background-position: -726px -77px',
					onclick:function () {
						editor.execCommand(uiName);
					}
				});
				editor.addListener('selectionchange', function () {
					var state = editor.queryCommandState(uiName);
					if (state == -1) {
						btn.setDisabled(true);
						btn.setChecked(false);
					} else {
						btn.setDisabled(false);
						btn.setChecked(state);
					}
				});
				return btn;
			}, 19);
			
	</script>
             <style>
	.panel-group{clear: both;margin-bottom: 20px; position: relative;}
	.panel-group .del,.panel-group .no{position: absolute; top:-10px; width:20px; height:20px; color:#fff; background:rgba(0,0,0,0.3); text-align:center; line-height:20px; cursor:pointer; border-radius:100%;}
	.panel-group .del{right:-10px;}
	.panel-group .no{left:-10px;background: #3071a9}
	.panel-group .del:hover{background:rgba(0,0,0,0.7);}
	.reply .panel-group .panel:last-child{margin-bottom: 0;}
	.panel-default {
    border-color: #ddd;
}
</style>



<input type="hidden" name="replies" value="">
<div class="panel ">
	<div class="panel-body">
		<div class="row clearfix reply">
			<div class="col-xs-6 col-sm-3 col-md-3">
				<div class="panel-group" ng-repeat="items in context.groups">
					<div class="panel panel-default" ng-repeat="item in items">
						<div class="panel-body" ng-if="$index == 0">
							<div class="img">
								<i class="default">封面图片</i>
								<img src="" ng-src="{{item.thumb}}">
								<span class="text-left">{{item.title}}</span>
								<div class="mask">
									<a href="javascript:;" ng-click="context.editItem(item, items)"><i class="fa fa-edit"></i>编辑</a>
									<a href="javascript:;" ng-click="context.removeItem(item, items)"><i class="fa fa-times"></i>删除</a>
								</div>
							</div>
						</div>
						<div class="panel-body" ng-if="$index != 0">
							<div class="text">
								<h4>{{item.title}}</h4>
							</div>
							<div class="img">
								<img src="" ng-src="{{item.thumb}}">
								<i class="default">缩略图</i>
							</div>
							<div class="mask">
								<a href="javascript:;" ng-click="context.editItem(item, items)"><i class="fa fa-edit"></i> 编辑</a>
								<a href="javascript:;" ng-click="context.removeItem(item, items)"><i class="fa fa-times"></i> 删除</a>
							</div>
						</div>
					</div>
					<div class="panel panel-default" ng-show="items.length < 8">
						<div class="panel-body" style="padding-right:15px">
							<div class="add" ng-click="items.length >= 8 ? '' : context.addItem(items);"><span><i class="fa fa-plus"></i> 添加</span></div>
						</div>
					</div>
				<!--		<div class="no">{{$index + 1}}</div>-->
				<!--	<div class="del" ng-click="context.removeGroup(items);"><i class="fa fa-times"></i></div>-->
				</div>
				<!--<div class="btn btn-primary" ng-click="context.addGroup()" style="margin-bottom: 20px">添加一组回复</div>-->

			</div>
			<div class="col-xs-6 col-sm-9 col-md-9 aside" id="edit-container">
				<div style="margin-bottom: 20px"></div>
				<div class="card">
					<div class="arrow-left"></div>
					<div class="inner">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control" placeholder="添加图文消息的标题" ng-model="context.activeItem.title"/>
										<input type="hidden" ng-model="context.activeItem.id" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">作者</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control" placeholder="添加图文消息的作者" ng-model="context.activeItem.author"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control" placeholder="添加排序" ng-model="context.activeItem.displayorder"/>
										<span class="help-block">排序只能在提交后显示。按照从大到小的顺序对图文排序</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面</label>
									<div class="col-sm-9 col-xs-12">
										<div class="col-xs-3 img" ng-if="context.activeItem.thumb == ''">
											<span ng-click="context.changeItem(context.activeItem)"><i class="fa fa-plus-circle green"></i>&nbsp;添加图片</span>
										</div>
										<div class="col-xs-3 img" ng-if="context.activeItem.thumb != ''">
											<h3 ng-click="context.changeItem(context.activeItem)">重新上传</h3>
											<img ng-src="{{ context.activeItem.thumb }}">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<label>
											封面（大图片建议尺寸：360像素 * 200像素）
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<label class="checkbox-inline">
											<input type="checkbox" value="1" ng-model="context.activeItem.incontent" ng-checked="context.activeItem.incontent"/> 封面图片显示在正文中
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">描述</label>
									<div class="col-sm-9 col-xs-12">
										<textarea class="form-control" placeholder="添加图文消息的简短描述" ng-model="context.activeItem.description"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-4 col-md-offset-3 col-lg-offset-2 col-xs-12 col-sm-8 col-md-9 col-lg-10">
										<label class="checkbox-inline">
											<input type="checkbox" value="1" ng-model="context.activeItem.detail" ng-checked="context.activeItem.detail" ng-init="context.activeItem.detail = context.activeItem.content!=''"/> 是否编辑图文详情
										</label>
										<span class="help-block">编辑详情可以展示这条图文的详细内容, 可以选择不编辑详情, 那么这条图文将直接链接至下方的原文地址中.</span>
									</div>
								</div>
								<div class="form-group" ng-show="context.activeItem.detail">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">详情</label>
									<div class="col-sm-9 col-xs-12">
										<div ng-my-editor ng-my-value="context.activeItem.content"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接</label>
									<div class="col-sm-9 col-xs-12">
											<input type="text" class="form-control" placeholder="图文消息的来源地址" ng-model="context.activeItem.url"/>
											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

 <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            </div>
        </div>
        </div>
     
    </div>
</form>
<script>
require(['angular.sanitize', 'bootstrap', 'underscore', 'util'], function(angular, $, _, util){
	angular.module('app', ['ngSanitize']).controller('replyForm', function($scope, $http){
		$scope.reply = {
			advSetting: false,
			advTrigger: false,
			entry: null 
		};
		$scope.trigger = {};
		$scope.trigger.descriptions = {};
		$scope.trigger.descriptions.contains = '用户进行交谈时，对话中包含上述关键字就执行这条规则。';
		$scope.trigger.descriptions.regexp = '用户进行交谈时，对话内容符合述关键字中定义的模式才会执行这条规则。<br/><strong>注意：如果你不明白正则表达式的工作方式，请不要使用正则匹配</strong> <br/><strong>注意：正则匹配使用MySQL的匹配引擎，请使用MySQL的正则语法</strong> <br /><strong>示例: </strong><br/><em>^微信</em>匹配以“微信”开头的语句<br /><em>微信$</em>匹配以“微信”结尾的语句<br /><em>^微信$</em>匹配等同“微信”的语句<br /><em>微信</em>匹配包含“微信”的语句<br /><em>[0-9\.\-]</em>匹配所有的数字，句号和减号<br /><em>^[a-zA-Z_]$</em>所有的字母和下划线<br /><em>^[[:alpha:]]{3}$</em>所有的3个字母的单词<br /><em>^a{4}$</em>aaaa<br /><em>^a{2,4}$</em>aa，aaa或aaaa<br /><em>^a{2,}$</em>匹配多于两个a的字符串';
		$scope.trigger.descriptions.trustee = '如果没有比这条回复优先级更高的回复被触发，那么直接使用这条回复。<br/><strong>注意：如果你不明白这个机制的工作方式，请不要使用直接接管</strong>';
		$scope.trigger.labels = {};
		$scope.trigger.labels.contains = '包含关键字';
		$scope.trigger.labels.regexp = '正则表达式模式';
		$scope.trigger.labels.trustee = '直接接管操作';
		$scope.trigger.active = 'contains';
		$scope.trigger.items = {};
		$scope.trigger.items.default = '';
		$scope.trigger.items.contains = [];
		$scope.trigger.items.regexp = [];
		$scope.trigger.items.trustee = [];
		if($scope.reply.entry) {
			$scope.reply.entry.istop = $scope.reply.entry.displayorder >= 255 ? 1 : 0;
			//$scope.reply.advSetting = $scope.reply.entry.displayorder!=0 || !$scope.reply.entry.status;
			if($scope.reply.entry.keywords) {
				angular.forEach($scope.reply.entry.keywords, function(v, k){
					if(v.type == '1') {
						this.default += (v.content + ',');
					}
					if(v.type == '2') {
						this.contains.push({content: v.content, label: '请输入' + $scope.trigger.labels.contains, saved: true});
					}
					if(v.type == '3') {
						this.regexp.push({content: v.content, label: '请输入' + $scope.trigger.labels.regexp, saved: true});
					}
					if(v.type == '4') {
						this.trustee.push({});
					}
				}, $scope.trigger.items);
				if($scope.trigger.items.default.length > 1) {
					$scope.trigger.items.default = $scope.trigger.items.default.slice(0, $scope.trigger.items.default.length - 1);
				}
				if($scope.trigger.items.contains.length > 0 || $scope.trigger.items.regexp.length > 0 || $scope.trigger.items.trustee.length > 0) {
					$scope.reply.advTrigger = true;
				}
				if($scope.trigger.items.contains.length > 0) {
					$('a[data-toggle="tab"]').eq(0).tab('show');
					$scope.trigger.active = 'contains';
				} else if($scope.trigger.items.regexp.length > 0) {
					$('a[data-toggle="tab"]').eq(1).tab('show');
					$scope.trigger.active = 'regexp';
				} else if($scope.trigger.items.trustee.length > 0) {
					$('a[data-toggle="tab"]').eq(2).tab('show');
					$scope.trigger.active = 'trustee';
				}
			}
		}
		$scope.trigger.addItem = function(){
			var type = $scope.trigger.active;
			if(type != 'trustee') {
				$scope.trigger.items[type].push({content: '', label: '请输入' + $scope.trigger.labels[type], saved: false});
			} else {
				if($scope.trigger.items.trustee.length == 0) {
					$scope.trigger.items.trustee.push({type:4, content:''});
				}
			}
		};
		
		$scope.trigger.saveItem = function(item){
			item.saved = !item.saved;
		};
		$scope.trigger.removeItem = function(item) {
			var type = $scope.trigger.active;
			$scope.trigger.items[type] = _.without($scope.trigger.items[type], item);
			$scope.$digest();
		};
		$scope.trigger.test = function(item) {
		}
		if($.isFunction(window.initReplyController)) {
			window.initReplyController($scope, $http);
		}
		$('#reply-form').submit(function(){		
		
				  if($(':input[name="entry[name]"]').val()==""||$(':input[name="entry[name]"]').val().length==0){
                alert('请输入规则名称!');
                return false;
            }
			  if($(':input[name="entry[keyword]"]').val()==""||$(':input[name="entry[keyword]"]').val().length==0){
                alert('请输入关键词!');
                return false;
            }
		
			
			if($.isFunction(window.validateReplyForm)) {
				return window.validateReplyForm(this, $, _, util, $scope, $http);
			}
			return true;
		});
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			$scope.trigger.active = e.target.hash.replace(/#/, '');
			$scope.$digest();
		})
		util.emotion($("#keyword"), $("#keywordinput")[0], function(txt, elm, target){
			$scope.trigger.items.default = $(target).val();
			$scope.$digest();
		});
	}).filter('nl2br', function($sce){
		return function(text) {
			return text ? $sce.trustAsHtml(text.replace(/\n/g, '<br/>')) : '';
		};
	}).directive('ngInvoker', function($parse){
		return function (scope, element, attr) {
			scope.$eval(attr.ngInvoker);
		};
	}).directive('ngMyEditor', function(){
		var editor = {
			'scope' : {
				'value' : '=ngMyValue'
			},
			'template' : '<textarea id="editor" style="height:600px;width:100%;"></textarea>',
			'link' : function ($scope, element, attr) {
				if(!element.data('editor')) {
					editor = UE.getEditor('editor', ueditoroption);
					element.data('editor', editor);
					editor.addListener('contentChange', function() {
						$scope.value = editor.getContent();
						$scope.$root.$$phase || $scope.$apply('value');
					});
					editor.addListener('ready', function(){
						if (editor && editor.getContent() != $scope.value) {
							editor.setContent($scope.value);
						}
						$scope.$watch('value', function (value) {
							if (editor && editor.getContent() != value) {
								editor.setContent(value ? value : '');
							}
						});
					});
				}
			}
		};
		return editor;
	});
	angular.bootstrap($('#js-reply-form')[0], ['app']);


	// 检测规则是否已经存在
	window.checkKeyWord = function(key) {
		var keyword = key.val().trim();
		if (keyword == '') {
			return false;
		}
		var type = key.attr('data-type');
		var wordIndex = key.index('.keyword');
		var isLeagl = true;
		$('.keyword').each(function(index) {
			var currentWord = $(this).val().trim();
			if (keyword == currentWord && wordIndex != index) {
				isLeagl = false;
				return false;
			}
		});
		if (isLeagl === false) {
			key.next().text('');
			util.message('该关键字已重复存在于当前规则中.');
			return false;
		}

		$.post(location.href, {keyword:keyword}, function(resp){
			if(resp != 'success') {
				var rid = $('input[name="rid"]').val();
				var rules = JSON.parse(resp);
				var url = "./index.php?c=platform&a=reply&do=post&m=news";
				var ruleurl = '';
				for (rule in rules) {
					if (rid != rules[rule].id) {
						ruleurl += "<a href='" + url + "&rid=" + rules[rule].id + "' target='_blank'><strong class='text-danger'>" + rules[rule].name + "</strong></a>&nbsp;";
					}
				}
				if (ruleurl != '') {
					key.next().html('该关键字已存在于 ' + ruleurl + ' 规则中.');
				}
			} else {
				key.next().text('');
			}
		});
	}

	$('.keyword').each(function() {
		$(this).attr('data-type', 'keyword');
	});
});

</script>

<script>
	window.initReplyController = function($scope, $http) {
		$scope.context = {};
		$scope.context.groups = <?php echo json_encode($replies)?>;
		if(!$.isArray($scope.context.groups)) {
			$scope.context.groups = [];
		}
		if($scope.context.groups.length == 0) {
			$scope.context.groups.push(
				[{
					id: '',
					parent_id: -1,
					title: '',
					author: '',
					thumb: '',
					displayorder: '0',
					incontent: true,
					description: '',
					detail: true,
					content: '',
					url: ''
				}]
			);
		}

		//当前编辑的回复项目的索引
		$scope.context.activeGroupIndex = 0;
		$scope.context.activeIndex = 0;
		//当前编辑的回复项目
		$scope.context.activeItem = $scope.context.groups[$scope.context.activeGroupIndex][$scope.context.activeIndex];
		$scope.context.activeItem.incontent = $scope.context.activeItem.incontent == 1;

		$scope.context.addGroup = function(){
			$scope.context.groups.push(
				[{
					id: '',
					parent_id: -1,
					title: '',
					author: '',
					thumb: '',
					displayorder: '0',
					incontent: true,
					description: '',
					detail: true,
					content: '',
					url: ''
				}]
			);

			$scope.context.activeGroupIndex = $scope.context.groups.length - 1;
			$scope.context.triggerActiveItem(0);
		};

		$scope.context.removeGroup = function(items){
			if($scope.context.groups.length == 1) {
				util.message('至少有一组回复内容');
				return false;
			}
			$scope.context.groups = _.without($scope.context.groups, items);
			$scope.context.activeGroupIndex = 0;
			$scope.context.triggerActiveItem(0);
			$scope.$digest();
		}

		$scope.context.editItem = function(item, items){
			$scope.context.triggerActiveGroup(items);
			var index = $.inArray(item, $scope.context.groups[$scope.context.activeGroupIndex]);
			if(index == -1) return false;
			$scope.context.triggerActiveItem(index);
		};

		$scope.context.triggerActiveGroup = function(items) {
			var index = $.inArray(items, $scope.context.groups);
			if(index == -1) return false;
			$scope.context.activeGroupIndex = index;
		}

		$scope.context.triggerActiveItem = function(index) {
			var gindex = $scope.context.activeGroupIndex;
			var top = 0;
			for(i = 0; i < gindex; i++) {
				if($scope.context.groups[i].length == 8) {
					top = top + 7*105 + 210;
				} else {
					top = top + 210 + $scope.context.groups[i].length * 105;
				}
			}
			top += index * 105 + 80;

			$('#edit-container').css('marginTop', top);
			$("html,body").animate({scrollTop:top + 500},500);
			$scope.context.activeIndex = index;
			$scope.context.activeItem = $scope.context.groups[$scope.context.activeGroupIndex][$scope.context.activeIndex];
			$scope.context.activeItem.incontent = $scope.context.activeItem.incontent == 1;
			$scope.context.activeItem.detail = $scope.context.activeItem.content != '';
		};

		$scope.context.changeItem = function(item) {
			require(['fileUploader'], function(uploader){
				uploader.init(function(imgs){
					var index = $.inArray(item, $scope.context.groups[$scope.context.activeGroupIndex]);
					if(index > -1){
						$scope.context.groups[$scope.context.activeGroupIndex][index].thumb = imgs.url;
						$scope.$apply()
					}
				}, {'direct' : true, 'multiple' : false});
			});
		};


		$scope.context.addItem = function(items){
			$scope.context.triggerActiveGroup(items);

			$scope.context.groups[$scope.context.activeGroupIndex].push({
				id: '',
				parent_id: -1,
				title: '',
				author: '',
				thumb: '',
				displayorder: '0',
				incontent: true,
				description: '',
				detail: true,
				content: '',
				url: ''
			});
			var index = $scope.context.groups[$scope.context.activeGroupIndex].length - 1;
			$scope.context.triggerActiveItem(index);
		};

		$scope.context.removeItem = function(item, items){
			$scope.context.triggerActiveGroup(items);
			require(['underscore'], function(_){
				$scope.context.groups[$scope.context.activeGroupIndex] = _.without($scope.context.groups[$scope.context.activeGroupIndex], item);
				$scope.context.triggerActiveItem(0);
				$scope.$digest();
			});
		};



	

	
	};

	window.validateReplyForm = function(form, $, _, util, $scope) {
		if($scope.context.groups.length == 0) {
			util.message('没有回复内容', '', 'error');
			return false;
		}
		var error = {empty: false, message: ''};
		angular.forEach($scope.context.groups, function(v, k){
			var item = $scope.context.groups[k];
			angular.forEach(item, function(v1){
				if($.trim(v1.title) == '') {
					this.empty = true;
				}
				if($.trim(v1.thumb) == '') {
					this.message = '标题为 "' + v1.title + '" 的回复条目没有上传封面图片<br>';
				}
			}, error);
		}, error);
		if(error.empty) {
			util.message('存在没有设置 "标题" 的回复条目');
			return false;
		}
		if(error.message) {
			util.message(error.message, '', 'error');
			return false;
		}
		var val = angular.toJson($scope.context.groups);
		$(':hidden[name=replies]').val(val);
		return true;
	};
</script>




          
        

<?php include page("footer-base");?>