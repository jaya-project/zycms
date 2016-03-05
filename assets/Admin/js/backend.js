var Module=angular.module('backend',['ngFileUpload', "ngQuickDate", 'angular-loading-bar']);
var RootPath = '/';
Module.filter('to_trusted', ['$sce', function ($sce) {return function (text) {return $sce.trustAsHtml(text);};}]);

Module.directive('ckEditor', function() {
  return {
    require: '?ngModel',
    link: function(scope, elm, attr, ngModel) {
      var ck = CKEDITOR.replace(elm[0]);
	  CKFinder.setupCKEditor( ck, '/assets/Admin/js/ckfinder/' );
	  
      if (!ngModel) return;
	  
	  ck.on('instanceReady', function(value) {
			ck.setData(ngModel.$viewValue);
		});
		
	  ck.on('change', function() {
		  scope.$apply(function() {
			  ngModel.$setViewValue(ck.getData());
			});
	  })
	  
	  ck.on('key', function() {
		 scope.$apply(function() {
			  ngModel.$setViewValue(ck.getData());
			});
	  })
		
      ck.on('pasteState', function() {
		  
        scope.$apply(function() {
          ngModel.$setViewValue(ck.getData());
        });
      });

      ngModel.$render = function(value) {
        ck.setData(ngModel.$viewValue);
      };
    }
  };
});


Module.controller('icoCtrl', function($scope, $http, upload) {
	var NG = $scope;
	
	NG.icoPath = '/favicon.ico';
	
	NG.$watch('files', function () {
       upload.uploadFile(RootPath + 'Backend/common/upload_ico', NG.files, NG, function(NG, data) {
		   NG.icoPath = data.data.relative_path + data.data.file_name;
		   window.location.reload();
	   });
    });
	
});

Module.controller('accessCtrl', function($scope, $http, upload) {
	var NG = $scope;
	
	NG.getBrowserPercent = function() {
		$http.post(RootPath + "Backend/tools/get_browser_percent").success(function(result) {
			
			if(result.code == 200 ) {
				var data = result.data;
				if (data.max > 0) {
					var seriesData = [];
					for (var i in data.series_data) {
						seriesData.push({value:data.series_data[i], name:i});
					}
					
					var myChart = echarts.init(document.getElementById('main'));
					var option = {
						title : {
							text: data.title,
							x:'center'
						},
						tooltip : {
							trigger: 'item',
							formatter: "{a} <br/>{b} : {c} ({d}%)"
						},
						legend: {
							orient : 'vertical',
							x : 'left',
							data:data.legend_data
						},
						toolbox: {
							show : true,
							feature : {
								mark : {show: true},
								dataView : {show: true, readOnly: false},
								magicType : {
									show: true, 
									type: ['pie', 'funnel'],
									option: {
										funnel: {
											x: '25%',
											width: '50%',
											funnelAlign: 'left',
											max: data.max
										}
									}
								},
								restore : {show: true},
								saveAsImage : {show: true}
							}
						},
						calculable : true,
						series : [
							{
								name:'浏览器份额',
								type:'pie',
								radius : '55%',
								center: ['50%', '60%'],
								data: seriesData
							}
						]
					};
									
					myChart.setOption(option);
				}
				
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getReferer = function() {
		$http.post(RootPath + "Backend/tools/get_referer").success(function(result) {
			
			if(result.code == 200 ) {
				var data = result.data;
				if (data.max > 0) {
					var seriesData = [];
					for (var i in data.series_data) {
						seriesData.push({value:data.series_data[i], name:i});
					}
					
					var myChart = echarts.init(document.getElementById('referer'));
					var option = {
						title : {
							text: data.title,
							x:'center'
						},
						tooltip : {
							trigger: 'item',
							formatter: "{a} <br/>{b} : {c} ({d}%)"
						},
						legend: {
							orient : 'vertical',
							x : 'left',
							data:data.legend_data
						},
						toolbox: {
							show : true,
							feature : {
								mark : {show: true},
								dataView : {show: true, readOnly: false},
								magicType : {
									show: true, 
									type: ['pie', 'funnel'],
									option: {
										funnel: {
											x: '25%',
											width: '50%',
											funnelAlign: 'left',
											max: data.max
										}
									}
								},
								restore : {show: true},
								saveAsImage : {show: true}
							}
						},
						calculable : true,
						series : [
							{
								name:'来源统计',
								type:'pie',
								radius : '55%',
								center: ['50%', '60%'],
								data: seriesData
							}
						]
					};
									
					myChart.setOption(option);
				}
				
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getPv = function() {
		$http.post(RootPath + "Backend/tools/get_pv").success(function(result) {
			
			if(result.code == 200 ) {
				var data = result.data;
				var sData = [];
				for (var i in data.result) {
					var temp = data.result[i].date.split('-');
					sData.push([
						new Date(temp[0], temp[1], temp[2]),
						data.result[i].count
					]);
				}
				var myChart = echarts.init(document.getElementById('pv'));
				var	option = {
						title : {
							text : data.title,
						},
						tooltip : {
							trigger: 'item',
							formatter : function (params) {
								var date = new Date(params.value[0]);
								data = date.getFullYear() + '-'
									   + (date.getMonth() + 1) + '-'
									   + date.getDate() + ' '
									   + date.getHours() + ':'
									   + date.getMinutes();
								return data + '<br/>'
									   + params.value[1] + '个页面访问量';
							}
						},
						toolbox: {
							show : true,
							feature : {
								mark : {show: true},
								dataView : {show: true, readOnly: false},
								restore : {show: true},
								saveAsImage : {show: true}
							}
						},
						dataZoom: {
							show: true,
							start : 0
						},
						legend : {
							data : ['pv']
						},
						grid: {
							y2: 80
						},
						xAxis : [
							{
								type : 'time',
								splitNumber:10
							}
						],
						yAxis : [
							{
								type : 'value'
							}
						],
						series : [
							{
								name: 'pv',
								type: 'line',
								showAllSymbol: true,
								symbolSize: function (value){
									return Math.round(value[1]/10) + 2;
								},
								data: sData,
							}
						]
					};
                    
                    
					myChart.setOption(option);
				
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getUv = function() {
		$http.post(RootPath + "Backend/tools/get_uv").success(function(result) {
			
			if(result.code == 200 ) {
				var data = result.data;
				var sData = [];
				for (var i in data.result) {
					var temp = data.result[i].date.split('-');
					sData.push([
						new Date(temp[0], temp[1], temp[2]),
						data.result[i].count
					]);
				}
				var myChart = echarts.init(document.getElementById('uv'));
				var	option = {
						title : {
							text : data.title,
						},
						tooltip : {
							trigger: 'item',
							formatter : function (params) {
								var date = new Date(params.value[0]);
								data = date.getFullYear() + '-'
									   + (date.getMonth() + 1) + '-'
									   + date.getDate() + ' '
									   + date.getHours() + ':'
									   + date.getMinutes();
								return data + '<br/>'
									   + params.value[1] + '个IP访问';
							}
						},
						toolbox: {
							show : true,
							feature : {
								mark : {show: true},
								dataView : {show: true, readOnly: false},
								restore : {show: true},
								saveAsImage : {show: true}
							}
						},
						dataZoom: {
							show: true,
							start : 0
						},
						legend : {
							data : ['uv']
						},
						grid: {
							y2: 80
						},
						xAxis : [
							{
								type : 'time',
								splitNumber:10
							}
						],
						yAxis : [
							{
								type : 'value'
							}
						],
						series : [
							{
								name: 'uv',
								type: 'line',
								showAllSymbol: true,
								symbolSize: function (value){
									return Math.round(value[1]/10) + 2;
								},
								data: sData,
							}
						]
					};
                    
                    
					myChart.setOption(option);
				
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.needClear = function() {
		$http.post(RootPath + "Backend/tools/get_tongji_count").success(function(result) {
			
			if(result.code == 200 ) {
				NG.needClear = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.clear = function() {
		$http.post(RootPath + "Backend/tools/clear_tongji").success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.needClear();
	NG.getBrowserPercent();
	NG.getPv();
	NG.getUv();
	NG.getReferer();
});

Module.controller('modelCtrl', function($scope, $http, sConfig, template, $compile) {
	var NG = $scope;
	
	var isEdit = $('#channelId').val() ? true : false;
	
	var channelId = $('#channelId').val();
	
	NG.modelArray = [];
	
	NG.channel = {"label_fields":'', 'fields':'', 'values':'', 'channel_type':'text'};
	
	NG.getModel = function() {
		$http.post(RootPath + "Backend/channel/get_model").success(function(result) {
			
			if(result.code == 200 ) {
				
				NG.data = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.modifyModel = function(channelId) {
		NG.addingField = false;
		NG.modifingField = false;
		template.getTemplate('channel-modify', NG, function(result) {
			NG.modifyModelCallback(result);
			
			NG.showModelStruct(channelId);
		})
	}
	
	NG.modifyModelCallback = function(content) {
		$('#container').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '修改模型',
			'content' : $('#container'),
			'id' : 'container'
			
		}).show();
	}
	
	NG.showModelStruct = function(channelId) {
		var data = {channelId:channelId};
		$http.post(RootPath + "Backend/channel/get_model_struct", data).success(function(result) {
			if(result.code == 200) {
				NG.channelId = result.data.channel_id;
				NG.modelArray = result.data.table_struct;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.deleteFields = function(channelId, field) {
		if (window.confirm('你确定要删除该字段吗? 删除后会丢失该字段的数据')) {
			var data = {channel_id:channelId, field:field};
			$http.post(RootPath + "Backend/channel/delete_channel_field", data).success(function(result) {
				if(result.code == 200) {
					generate({"text":result.message, "type":"success"});
					dialog({id:'container'}).remove();
					NG.getModel();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.cancelAdd = function() {
		NG.addingField = false;
	}
	
	NG.showAddUI = function() {
		NG.newFields = [{'fields':'', 'label_fields':'', 'values':'', 'channel_type':'text'}];
		NG.addingField = true;
	}
	
	NG.addFieldRow = function() {
		NG.newFields.push({'fields':'', 'label_fields':'', 'values':'', 'channel_type':'text'})
	}
	
	NG.deleteFieldRow = function(index) {
		NG.newFields.splice(index, 1);
	}
	
	NG.addField = function(channelId) {
		
		var newFields = [];
		for (var i in NG.newFields) {
			if (typeof NG.newFields[i].fields != 'undefined' && NG.newFields[i].fields != '') {
				newFields.push(NG.newFields[i]);
			}
		}
		
		if (newFields.length <= 0) {
			generate({'text':'请至少填写一个字段', 'type':'error'});
			return;
		}
		
		var data = {"new_fields":newFields, "channel_id":channelId};
		
		$http.post(RootPath + "Backend/channel/add_channel_fields", data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				dialog({'id':'container'}).remove();
				NG.getModel();
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.showModifyUI = function(index) {
		NG.modifingField = true;
		NG.oldField = $.extend({}, NG.modelArray[index]);
		NG.modifyIndex = index;
	}
	
	NG.cancelModify = function() {
		NG.modifingField = false;
	}
	
	NG.modifyField = function(channelId) {
		if (window.confirm('你真的要更改字段吗?已经添加的数据可能会受到影响')) {
			if (typeof NG.oldField.fields == 'undefined' || NG.oldField.fields == '') {
				generate({'text':'字段名不能为空', 'type':'error'});
				return;
			}
			
			var data = {"channel_id":channelId, "old_field":NG.oldField, "be_modified":NG.modelArray[NG.modifyIndex]};
			$http.post(RootPath + "Backend/channel/modify_channel_field", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					dialog({'id':'container'}).remove();
					NG.getModel();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.deleteModel = function(channelId) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {"channel_id":channelId};
			$http.post(RootPath + "Backend/channel/delete_model", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.addModel = function() {
		var First = {'fields':NG.channel.fields, 'label_fields':NG.channel.label_fields, 'channel_type':NG.channel.channel_type, 'values':NG.channel.values};
		
		var data = {'table_struct':[First], 'channel_name':NG.channel.channel_name, 'table_name':NG.channel.table_name};
		
		if (NG.modelArray.length > 0) {
			for (var i in NG.modelArray) {
				if (NG.modelArray[i].fields) {
					data.table_struct.push({'fields':NG.modelArray[i].fields, 'label_fields':NG.modelArray[i].label_fields, 'channel_type':NG.modelArray[i].channel_type, 'values':NG.modelArray[i].values});
				}
			}
		}
		
		var url = isEdit ? RootPath + 'Backend/channel/edit' : RootPath + "Backend/channel/add";
		
		$http.post(url, data).success(function(result) {
				if(result.code == 200 ) {
					window.location.reload();
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getSpecifyModel = function() {
		if (!channelId) {
			generate({'text':'ID不正确', 'type':'error'});
			return;
		} else {
			var data = {"channel_id":channelId};
			$http.post(RootPath + "Backend/channel/get_specify_model", data).success(function(result) {
				if(result.code == 200 ) {
					NG.channel = result.data;
					for (var i in result.data.table_struct) {
						NG.modelArray.push(result.data.table_struct[i]);
					}
					
					var temp = NG.modelArray.shift();
					
					$.extend(NG.channel, temp);
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	if (isEdit) {
		NG.getSpecifyModel();
	}
	
	NG.addTableTr = function() {
		NG.modelArray.push({'fields':'', 'label_fields':'', 'values':'', 'channel_type':'text'});
	}
	
	NG.deleteTableTr = function(index) {
		NG.modelArray.splice(index, 1);
	}
	
	sConfig.getChannelTypeConfig(NG);
	
	
	
	NG.getModel();
});

Module.controller('columnCtrl', function($scope, $http, upload, List, sort) {
	var NG = $scope;
	
	NG.columnId = window.location.hash.substring(1);
	
	
	 NG.$watch('files', function () {
       upload.uploadFile(RootPath + 'Backend/common/upload_image', NG.files, NG, function(NG, data) {
		   NG.column = $.extend({}, NG.column, {'column_thumb':data.data.relative_path + data.data.file_name});
	   });
    });
	
	NG.column = {"rule_type":2};
	
	NG.addColumn = function() {
		$.extend(NG.column, {"is_add":1});
		NG.saveColumn();
	}
	
	NG.modifyColumn = function(id) {
		window.location.href = RootPath + 'admin/column_add#' + id;
	}
	
	NG.getSpecifyColumn = function() {
		var data = {"id":NG.columnId};
		$http.post(RootPath + "Backend/column/get_specify_column", data).success(function(result) {
				if(result.code == 200 ) {
					NG.column = result.data;
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteColumn = function(id) {
		if(window.confirm('你确定要删除吗?')) {
			var data = {"id":id};
			$http.post(RootPath + "Backend/column/column_delete", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					List.getAllColumn(NG);
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.saveColumn = function() {
		var data = NG.column;
		var pid = typeof NG.column.pid == 'undefined' || NG.column.pid == null ? 0 : NG.column.pid;
		
		$.extend(data, {'pid':pid});
		$http.post(RootPath + "Backend/column/column_save", data).success(function(result) {
				if(result.code == 200 ) {
					generate({'text':result.message, "type":'success'});
					NG.column = {};
					NG.columnId = false;
					List.getAllColumn(NG);
					NG.is_delete = 0;
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.updateColumn = function() {
		$.extend(NG.column, {"is_edit":1});
		NG.saveColumn();
	}
	
	NG.modifySort = function(id, sortValue) {
		sortValue = parseInt(sortValue);
		id = parseInt(id);
		var data = {"id":id, "sort":sortValue};
		var url = RootPath + "Backend/column/modify_sort";
		sort.modifySort(url, data);
	}
	
	if (NG.columnId != '') {
		NG.getSpecifyColumn();
	}
	
	List.getChannelType(NG);
  
    List.getAllColumn(NG);
	
	
	
})

Module.controller('autoPushCtrl', function($scope, $http) {
	var NG = $scope;
	
	NG.autoPush = function() {
		if (typeof NG.push == 'undefined') {
			generate({'text':'请至少填写一个链接', 'type':'error'});
			return;
		}
		
		var data = NG.push;
		
		
		
		$http.post(RootPath + 'Backend/tools/auto_push', data).success(function(result) {
			if(result.code == 200 ) {
				var message = '';
				message += '已成功推送' + result.data.success + '条<br />';
				message += '还剩余' + result.data.remain + '条<br />';
				typeof result.data.not_same_site == 'undefined' ||	(message += '不是该域名下的非法域名有' + result.data.not_same_site.join(' ') + '<br />');
				typeof result.data.not_valid == 'undefined' ||	(message += '不符合域名格式的有' + result.data.not_valid.join(' '));
				generate({"text":message, "type":"success", 'timeout':10000});
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
})

Module.controller('messageCtrl', function($scope, $http, List, $compile, template) {
	var NG = $scope;
	
	NG.message = {};
	
	
	NG.showMessageList = function(id) {
		
		
		template.getTemplate('message-list', NG, function(content) {
			NG.showMessageListCallback(content);
			
			NG.getReplyMessage(id);
		});
		
	}
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.data) {
				NG.data[i].is_chk = NG.data[i].id;
			}
		} else {
			for (var i in NG.data) {
				delete NG.data[i].is_chk;
			}
		}
	}
	
	NG.batDelete = function() {
		if (window.confirm('你确定要删除吗?')) {
			
			var ids = [];
			for (var i in NG.data) {
				if (typeof NG.data[i].is_chk != 'undefined') {
					ids.push(NG.data[i].id);
				}
			}
			
			if (ids.length <= 0) {
				generate({'text':'请至少选择一条消息', 'type':'error'});
				return;
			}
			
			var data = {"ids":ids};
			
			$http.post(RootPath + 'Backend/message/bat_delete', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
		
		}
	}
	
	NG.sendMessage = function() {
		var data = NG.message;
		
		if (typeof data.title == 'undefined') {
			generate({'text':'标题不能为空', 'type':'error'});
			return;
		}
		
		if (typeof data.content == 'undefined') {
			generate({'text':'内容不能为空', 'type':'error'});
			return;
		}
		
		
		$http.post(RootPath + 'Backend/message/send_message', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				$('.ui-dialog-close').click();
				NG.getContent();
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getReplyMessage = function(id) {
		var data = {"id":id};
		$http.post(RootPath + "Backend/message/get_reply_message", data).success(function(result) {
			if(result.code == 200 ) {
				var data = $compile(result.data)(NG);
				$(data).appendTo('#message-list');
				
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.showReplyUI = function(id) {
		
		template.getTemplate('send-message', NG, function(content) {
			NG.showReplyUICallback(content);
			
		});
		
		NG.message.pid = id;
	}
	
	NG.showReplyUICallback = function(content) {
		$('.ui-popup').remove();
		$('#showSendMessage').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '消息回复',
			'content' : $('#showSendMessage'),
			'id' : 'showSendMessage'
			
		}).show();
	}
	
	NG.deleteMessage = function(id, obj) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {"id":id};
			$http.post(RootPath + "Backend/message/delete", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getContent();
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.searchMessage = function() {
		var data = {"id":NG.memberId};
		
		$http.post(RootPath + "Backend/message/search_message", data).success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showMessageListCallback = function(content) {
		$('.ui-popup').remove();
		$('#messageList').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '消息回复列表',
			'content' : $('#messageList'),
			'id' : 'messageList'
			
		}).show();
	}
	
	
	NG.getContent = function(id) {
		var data = {"id":0};
		$http.post(RootPath + "Backend/message/get_all", data).success(function(result) {
			if(result.code == 200 ) {
				NG.data = result.data;
				
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	List.getAllMembers(NG);
	
	NG.getContent();
	
})

Module.controller('restoreCtrl', function($http, $scope, upload, List, sort, $compile) {
	var NG = $scope;
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.data) {
				NG.data[i].is_chk = NG.data[i].id;
			}
		} else {
			for (var i in NG.data) {
				delete NG.data[i].is_chk;
			}
		}
		
	}
	
	NG.clean = function() {
		if (window.confirm('真的要清空回收站吗?清空后不可恢复!')) {
			$http.post(RootPath + "Backend/document/clean").success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getAllArticle();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.batDelete = function() {
		if (window.confirm('你真的要删除吗?删除后不可恢复!')) {
			var ids = [];
			for (var i in NG.data) {
				if (NG.data[i].is_chk == NG.data[i].id) {
					ids.push(NG.data[i].id);
				}
			}
			
			var data = {"ids":ids, "finally":1};
			
			$http.post(RootPath + "Backend/document/bat_delete", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getAllArticle();
					 
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	
	NG.getAllArticle = function(page) {
		var data = NG.search;
		page = typeof page == 'undefined' ? 1 : page;
		
		data = $.extend({}, data, {page:page, 'is_delete':1});
		
		$http.post(RootPath + "Backend/document/get_article", data).success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data.data;
					NG.totalPages = [];
					NG.totalPages2 = result.data.total_pages;
					
					for (var i=1; i<=result.data.total_pages; i++) {
						NG.totalPages.push(i);
					}
					
					NG.currentPage = result.data.current_page;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.restoreDocument = function(type,id) {
		var ids = [];
		for (var i in NG.data) {
			if (NG.data[i].is_chk == NG.data[i].id) {
				ids.push(NG.data[i].id);
			}
		}
		
		typeof id != 'undefined' && ids.push(id);
		
		
		switch(type) {
			case 1: //还原单个文档
				break;
			case 2: //还原所选文档
			default:
				if (ids.length == 0) {
					generate({"text":'请至少选择一个文档', "type":"error"});
					return;
				}
				break;
			case 3: //还原所有文档
				if (!window.confirm('你真的要还原所有文档吗?')) {
					return;
				}
				break;
		}
		
		
		var data = {"ids":ids};
		$http.post(RootPath + "Backend/document/restore_document", data).success(function(result) {
				if(result.code == 200 ) {
					generate({'text':result.message, 'type':'success'});
					NG.getAllArticle();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteArticle = function(id) {
		if (window.confirm('你真的删除这篇文章吗?')) {
			var data = {"id":id, 'finally':1};
			$http.post(RootPath + "Backend/document/document_delete", data).success(function(result) {
					if(result.code == 200 ) {
						generate({'text':result.message, 'type':'success'});
						NG.getAllArticle();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getAllArticle();
	
	
	List.getAllColumn(NG);
	
})

Module.controller('exportCtrl', function($http, $scope, Upload, List, $compile) {
	var NG = $scope;
	
	NG.$watch('files', function () {
		if (NG.files) {
			NG.maskAndNoticeBoxShow();
			Upload.upload({
				url: RootPath + 'Backend/tools/bat_export',
				file: NG.files
			}).success(function (data, status, headers, config) {
				console.log(data);
				if (data.code == 200) {
				   generate({'text':data.message, 'type':'success'});
			   } else if (data.code == 201) {
					$('<span>'+data.message+'</span>').appendTo('#noticeBox');
				   NG.exportSub(data.data);
				  
			   } else {
				   generate({"text":data.message, "type":"error"});
				   NG.maskHide();
			   }
			});
		}
		
		
    });
	
	NG.maskAndNoticeBoxShow = function() {
		$('<div id="mask"></div>').appendTo('body');
		$('<div id="noticeBox"><span>正在上传文件,请稍候...</span></div>').appendTo('body');
	}
	
	NG.maskHide = function() {
		$('#mask').remove();
		$('#noticeBox').remove();
	}
	

	
	NG.exportSub = function(data) {
		$http.post(RootPath + "Backend/tools/import_company_each_time", data).success(function(result) {
			if(result.code == 200) {
				NG.maskHide();
				generate({'text':result.message, 'type':'success'});
			} else if (result.code == 201) {
				NG.exportSub(result.data);
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.downloadTemplate = function() {
		if (typeof NG.search.cid == 'undefined') {
			generate({'text':'请先选择栏目', 'type':'error'});
			return;
		}
		
		window.open(RootPath + 'download/columnTemplate/'+NG.search.cid);
	}
	
	List.getAllColumn(NG);
})

Module.controller('documentCtrl', function($http, $scope, upload, List, sort, $compile, deleteFile) {
	var NG = $scope;
	NG.delayRelease = 0;
	
	NG.callbacks = [];
	
	NG.article = {'sort':50, 'author':'admin', 'source':'原创', 'seo_title':'', 'seo_description':'', 'seo_keywords':'', 'tag':'', 'delay_time':0};
	
	NG.documentId = window.location.hash.substring(1);
	
	
	 NG.$watch('files', function () {
       upload.uploadFile(RootPath + 'Backend/common/upload_image', NG.files, NG, function(NG, data) {
		   NG.article = $.extend({}, NG.article, {'thumb':data.data.relative_path + data.data.file_name});
	   });
    });
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.data) {
				NG.data[i].is_chk = NG.data[i].id;
			}
		} else {
			for (var i in NG.data) {
				delete NG.data[i].is_chk;
			}
		}
		
	}
	
	NG.batDelete = function() {
		if (window.confirm('你真的要删除吗?')) {
			var ids = [];
			for (var i in NG.data) {
				if (NG.data[i].is_chk == NG.data[i].id) {
					ids.push(NG.data[i].id);
				}
			}
			
			var data = {"ids":ids};
			
			if (ids.length == 0) {
				generate({"text":'请至少选择一个文档', "type":"error"});
				return;
			}
			
			$http.post(RootPath + "Backend/document/bat_delete", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getAllArticle();
					 
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.getStruct = function(id) {
		
		$('.newItem').remove();
		
		var data = {"id":id};
		$http.post(RootPath + "Backend/document/get_column_struct", data).success(function(result) {
				if(result.code == 200 ) {
					
					var data = $compile(result.data.html)(NG);
					$(data).insertAfter($('#thumb'));
					
					for(var i in result.data.code) {
						// console.log(result.data.code[i])
						eval(result.data.code[i])
					}
					
					 
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.saveContent = function(url, data) {
		
		$http.post(url, data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.article = {'sort':50, 'author':'admin', 'source':'原创', 'seo_title':'', 'seo_description':'', 'seo_keywords':'', 'tag':''};
					NG.files = [];
					for (var i in NG.callbacks) {
						(NG.callbacks[i])();
					}
					NG.callbacks = [];
					$('.newItem').remove();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.addContent = function() {
		if (typeof NG.article.title == 'undefined') {
			generate({'text':'请填写标题', 'type':'error'});
			return;
		}
		
		if (typeof NG.article.cid == 'undefined') {
			generate({'text':'请选择栏目ID', 'type':'error'});
			return;
		}
		
		var data = NG.article;
		
		var url = RootPath + "Backend/document/save";
		
		for (var i in data.sub_column) {
			if (!data.sub_column[i]) {
				delete data.sub_column[i];
			}
		}
		
		NG.saveContent(url, data);
		
		
	}
	
	NG.editContent = function() {
		if (typeof NG.article.title == 'undefined') {
			generate({'text':'请填写标题', 'type':'error'});
			return;
		}
		
		if (typeof NG.article.cid == 'undefined') {
			generate({'text':'请选择栏目ID', 'type':'error'});
			return;
		}
		
		var data = NG.article;
		
		var url = RootPath + "Backend/document/save";
		
		for (var i in data.sub_column) {
			if (!data.sub_column[i]) {
				delete data.sub_column[i];
			}
		}
		
		NG.saveContent(url, data);
	}

	
	NG.modifyContent = function(id) {
		Cookies.set('status', JSON.stringify({search:NG.search, currentPage:NG.currentPage}));
		window.location.href=RootPath+"admin/document_add#"+id;
	}
	
	NG.getSpecifyDocument = function() {
		var data = {"id":NG.documentId};
		$http.post(RootPath + "Backend/document/get_specify_article", data).success(function(result) {
				if(result.code == 200 ) {
					
					NG.article = result.data;
					var temp = NG.article.sub_column.split(',');
					var temp_obj = {};
					for (var i in temp) {
						temp_obj[temp[i]] = temp[i];
					}
					NG.article.sub_column = temp_obj;
					if (NG.article.delay_time != 0) {
						NG.delayRelease = '1';
					}
					NG.getStruct(NG.article.cid);
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}

	
	NG.getAllArticle = function(page) {
		
		var data = NG.search;
		page = typeof page == 'undefined' ? 1 : page;
		
		data = $.extend({}, data, {page:page});
		
		$http.post(RootPath + "Backend/document/get_article", data).success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data.data;
					NG.totalPages = [];
					NG.totalPages2 = result.data.total_pages;
					
					for (var i=1; i<=result.data.total_pages; i++) {
						NG.totalPages.push(i);
					}
					
					NG.currentPage = result.data.current_page;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteArticle = function(id) {
		if (window.confirm('你真的删除这篇文章吗?')) {
			var data = {"id":id};
			$http.post(RootPath + "Backend/document/document_delete", data).success(function(result) {
					if(result.code == 200 ) {
						generate({'text':result.message, 'type':'success'});
						NG.getAllArticle();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.clearSearch = function() {
		NG.search = '';
		Cookies.remove('status');
		NG.currentPage = 1;
		NG.getAllArticle();
	}
	
	if (Cookies.get('status')) {
		var status = JSON.parse(Cookies.get('status'));
		console.log(status)
		NG.search = status.search;
		NG.getAllArticle(status.currentPage);
	} else {
		NG.getAllArticle();
	}
	
	
	if (NG.documentId != '') {
		NG.getSpecifyDocument();
	}
	
	NG.modifySort = function(id, sortValue) {
		sortValue = parseInt(sortValue);
		id = parseInt(id);
		var data = {"id":id, "sort":sortValue};
		var url = RootPath + "Backend/document/modify_sort";
		sort.modifySort(url, data);
	}
	
	
	
	List.getAllColumn(NG);
	
})

Module.controller('blackListCtrl', function($scope, $http) {
	var NG = $scope;
	
	NG.saveContent = function() {
		var data = {blackList:NG.blackList};
		$http.post(RootPath + 'Backend/tools/save_black_list', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				NG.getContent();
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getContent = function() {
		$http.post(RootPath + 'Backend/tools/get_black_list').success(function(result) {
			if(result.code == 200 ) {
				NG.blackList = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getContent();
});

Module.controller('searchEngineCtrl', function($scope, $http) {
	var NG = $scope;
	
	NG.searchengine = {'baidu':'baidu', 'google':'google', 'so':'so', 'sogou':'sogou', 'soso':'soso', 'bing':'bing'};
	
	NG.saveContent = function() {
		var data = {"search_engine":NG.searchengine};
		$http.post(RootPath + 'Backend/optimization/submit_to_sg', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
})

Module.controller('adPositionCtrl', function($scope, $http, template, $compile) {
	var NG = $scope;
	
	NG.position = {is_enable:1};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.isEdit = false;
		template.getTemplate('ad-position-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveAdPosition').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加广告位',
			'content' : $('#saveAdPosition'),
			'id' : 'saveAdPosition'
			
		}).show();
	}
	
	NG.addContent = function() {
		var data = NG.position;
		if (typeof data.name == 'undefined') {
			generate({'text':'广告位名称不能为空', 'type':'error'});
			return;
		}
		
		data = $.extend({}, data, {'is_edit':false});
		
		$http.post(RootPath + 'Backend/ad_position/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/ad_position/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyAdPosition(id);
		
		template.getTemplate('ad-position-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
		
	}
	
	NG.modifyContent = function(id) {
		var data = NG.position;
		data = $.extend({}, data, {'is_edit':true, id:id});
		
		$http.post(RootPath + 'Backend/ad_position/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/ad_position/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyAdPosition = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/ad_position/get_specify_ad_position', data).success(function(result) {
				if(result.code == 200 ) {
					NG.position = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('systemSetCtrl', function($scope, $http) {
	var NG = $scope;
	
	NG.saveContent = function() {
		var data = NG.system;
		$http.post(RootPath + 'Backend/system/save_base_set', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getContent = function() {
		$http.post(RootPath + 'Backend/system/get_base_set').success(function(result) {
				if(result.code == 200 ) {
					NG.system = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getContent();
})

Module.controller('waterImageCtrl', function($scope, $http, upload){
	var NG = $scope;
	
	NG.water = {'type':0, 'is_open':1, 'position':'middle_center'};
	
	NG.$watch('files', function () {
       upload.uploadFile(RootPath + 'Backend/system/upload_image', NG.files, NG, function(NG, data) {
		   NG.water = $.extend({}, NG.water, {'thumb':data.data.relative_path + data.data.file_name});
	   });
    });
	
	NG.setThumbOpacity = function (opacity) {
		if (typeof NG.water.thumb == 'undefined') {
			generate({'text':'请选择上传水印图片', 'type':'error'});
			return;
		}
		
		$('#fullPath').css('opacity', opacity / 100);
	}
	
	NG.saveContent = function() {
		var data = NG.water;
		
		$http.post(RootPath + 'Backend/system/save_water_set', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	
	NG.getContent = function() {
		$http.post(RootPath + 'Backend/system/get_water_set').success(function(result) {
				if(result.code == 200 ) {
					NG.water = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getContent();
})

Module.controller('rightCtrl', function($scope, $http, template, $compile) {
	var NG = $scope;
		
	NG.right = {};
	
	NG.isEdit = false;
	
	NG.rights = [];
	
	NG.showAddUI = function() {
		NG.right = {};
		NG.rights = [];
		NG.isEdit = false;
		template.getTemplate('right-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	
	
	NG.showAddUICallback = function(content) {
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加权限',
			'content' : $('#saveRight'),
			'id' : 'saveRight'
			
		}).show();
	}
	
	NG.addResource = function() {
		NG.rights.push({'resource':''});
	}
	
	NG.deleteResource = function(index) {
		NG.rights.splice(index, 1);
	}
	
	
	
	NG.addContent = function() {
		if (typeof NG.right.name == 'undefined') {
			generate({'text':'权限资源名称不能为空', 'type':'error'});
			return;
		}
		
		var rights = [];
		
		rights.push(NG.right.resource);
		
		for (var i in NG.rights) {
			if (typeof NG.rights[i] != 'undefined') {
				rights.push(NG.rights[i].resource);
			}
		}
		
		
		
		var data = {"name":NG.right.name, 'resource':rights};
		
		data = $.extend({}, data, {'is_edit':false});
		
		
		$http.post(RootPath + 'Backend/right/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/right/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyRight(id);
		
		template.getTemplate('right-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
	}
	
	NG.modifyContent = function(id) {
		if (typeof NG.right.name == 'undefined') {
			generate({'text':'权限资源名称不能为空', 'type':'error'});
			return;
		}
		
		var rights = [];
		
		rights.push(NG.right.resource);
		
		for (var i in NG.rights) {
			if (typeof NG.rights[i] != 'undefined') {
				rights.push(NG.rights[i].resource);
			}
		}
		
		
		var data = {"name":NG.right.name, 'resource':rights, 'id':NG.right.id};
		
		data = $.extend({}, data, {'is_edit':true});
		
		$http.post(RootPath + 'Backend/right/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/right/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyRight = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/right/get_specify_right', data).success(function(result) {
				if(result.code == 200 ) {
					NG.right.id = result.data.id;
					NG.right.name = result.data.name;
					NG.right.resource = result.data.resource.shift();
					NG.rights = [];
					for (var i in result.data.resource) {
						NG.rights.push({'resource':result.data.resource[i]});
					}
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('roleCtrl', function($scope, $http, template, $compile, List) {
	var NG = $scope;
		
	NG.right = {};
	
	NG.isEdit = false;
	
	NG.role = {};
	
	
	NG.showAddUI = function() {
		NG.role = {};
		NG.isEdit = false;
		template.getTemplate('role-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
		List.getAllRights(NG);
	}
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.rights) {
				NG.rights[i].is_chk = NG.rights[i].id;
			}
		} else {
			for (var i in NG.rights) {
				delete NG.rights[i].is_chk;
			}
		}
	}
	
	
	NG.showAddUICallback = function(content) {
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加权限',
			'content' : $('#saveRole'),
			'id' : 'saveRole'
			
		}).show();
	}
	
	
	NG.addContent = function() {
		if (typeof NG.role.name == 'undefined') {
			generate({'text':'权限资源名称不能为空', 'type':'error'});
			return;
		}
		
		var rids = [];
		
		
		
		for (var i in NG.rights) {
			if (typeof NG.rights[i].is_chk != 'undefined' && NG.rights[i].is_chk != '') {
				rids.push(NG.rights[i].id);
			}
		}
		
		
		var data = {"name":NG.role.name, 'rid':rids};
		
		data = $.extend({}, data, {'is_edit':false});
		
		
		$http.post(RootPath + 'Backend/role/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/role/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyRole(id);
		
		
		template.getTemplate('role-add', NG, function(content) {
			NG.showAddUICallback(content);
			
			
		});
		
	}
	
	if (typeof NG.rights == 'undefined') {
		List.getAllRights(NG);
	}
	
	NG.modifyContent = function(id) {
		if (typeof NG.role.name == 'undefined') {
			generate({'text':'权限资源名称不能为空', 'type':'error'});
			return;
		}
		
		var rids = [];
		
		
		
		for (var i in NG.rights) {
			if (typeof NG.rights[i].is_chk != 'undefined' && NG.rights[i].is_chk != '') {
				rids.push(NG.rights[i].id);
			}
		}
		
		
		var data = {"name":NG.role.name, 'rid':rids, 'id':NG.role.id};
		
		data = $.extend({}, data, {'is_edit':true});
		
		$http.post(RootPath + 'Backend/role/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/role/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyRole = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/role/get_specify_role', data).success(function(result) {
				if(result.code == 200 ) {
					
					NG.role.id = result.data.id;
					NG.role.name = result.data.name;
					for (var i in NG.rights) {
						if ($.inArray(NG.rights[i].id, result.data.rid) >= 0) {
							NG.rights[i].is_chk = NG.rights[i].id;
						}
					}
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('userCtrl', function($scope, $http, template, $compile, List) {
	var NG = $scope;
		
	NG.user = {};
	
	NG.isEdit = false;
	
	NG.role = {};
	
	if (typeof NG.roles == 'undefined') {
		List.getAllRoles(NG);
	}
	
	
	NG.showAddUI = function() {
		NG.role = {};
		NG.isEdit = false;
		template.getTemplate('user-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
		
	}
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.rights) {
				NG.rights[i].is_chk = NG.rights[i].id;
			}
		} else {
			for (var i in NG.rights) {
				delete NG.rights[i].is_chk;
			}
		}
	}
	
	
	NG.showAddUICallback = function(content) {
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加用户',
			'content' : $('#saveUser'),
			'id' : 'saveUser'
			
		}).show();
	}
	
	
	NG.addContent = function() {
		
		if (typeof NG.user.username == 'undefined') {
			generate({'text':'用户名不能为空', 'type':'error'});
			return;
		}
		
		if (typeof NG.user.password == 'undefined') {
			generate({'text':'密码不能为空', 'type':'error'});
			return;
		}
		
		if (typeof NG.user.rid == 'undefined') {
			generate({'text':'角色不能为空', 'type':'error'});
			return;
		}
		
		
		var data = NG.user;
		
		data = $.extend({}, data, {'is_edit':false});
		
		
		
		$http.post(RootPath + 'Backend/user/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/user/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyUser(id);
		
		
		template.getTemplate('user-add', NG, function(content) {
			NG.showAddUICallback(content);
			
			
		});
		
	}
	
	if (typeof NG.rights == 'undefined') {
		List.getAllRights(NG);
	}
	
	NG.modifyContent = function(id) {
		if (typeof NG.user.username == 'undefined') {
			generate({'text':'用户名不能为空', 'type':'error'});
			return;
		}
		
		
		if (typeof NG.user.rid == 'undefined') {
			generate({'text':'角色不能为空', 'type':'error'});
			return;
		}
		
		
		var data = NG.user;
		
		data = $.extend({}, data, {'is_edit':true});
		
		
		
		$http.post(RootPath + 'Backend/user/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/user/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyUser = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/user/get_specify_user', data).success(function(result) {
				if(result.code == 200 ) {
					NG.user = result.data;
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('adCtrl', function($scope, $http, template, $compile, List, upload) {
	var NG = $scope;
		
	NG.ad = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.ad = {};
		NG.isEdit = false;
		template.getTemplate('ad-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
		List.getAllAdPosition(NG);
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveAd').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加广告',
			'content' : $('#saveAd'),
			'id' : 'saveAd'
			
		}).show();
	}
	
	NG.$watch('files', function () {
       upload.uploadFile(RootPath + 'Backend/common/upload_image', NG.files, NG, function(NG, data) {
		   NG.ad = $.extend({}, NG.ad, {'thumb':data.data.relative_path + data.data.file_name});
	   });
    });
	
	NG.addContent = function() {
		var data = NG.ad;
		if (typeof NG.ad.name == 'undefined') {
			generate({'text':'广告名称不能为空', 'type':'error'});
			return;
		}
		
		if (typeof NG.ad.pid == 'undefined') {
			generate({'text':'请选择广告位', 'type':'error'});
			return;
		}
		
		data = $.extend({}, data, {'is_edit':false});
		
		$http.post(RootPath + 'Backend/ad/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/ad/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyAd(id);
		
		template.getTemplate('ad-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
		List.getAllAdPosition(NG);
	}
	
	NG.modifyContent = function(id) {
		var data = NG.ad;
		data = $.extend({}, data, {'is_edit':true, id:id});
		
		$http.post(RootPath + 'Backend/ad/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/ad/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyAd = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/ad/get_specify_ad', data).success(function(result) {
				if(result.code == 200 ) {
					NG.ad = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('orderCtrl', function($scope, $http, template, $compile, List, upload) {
	var NG = $scope;
		
	NG.member = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.member = {};
		NG.isEdit = false;
		template.getTemplate('member-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
		List.getAllProvinces(NG);
	}
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.data) {
				NG.data[i].is_chk = NG.data[i].id;
			}
		} else {
			for (var i in NG.data) {
				delete NG.data[i].is_chk;
			}
		}
	}
	

	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/order/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.order = {};
		NG.isEdit = true;
		NG.getSpecifyOrder(id);
		
		template.getTemplate('order-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
		
		
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveOrder').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '查看订单',
			'content' : $('#saveOrder'),
			'id' : 'saveOrder'
			
		}).show();
	}
	
	NG.setState = function(orderNumber) {
		var data = {order_number:orderNumber};
			
		$http.post(RootPath + 'Backend/order/set_state', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				NG.getAllContent();
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.download = function(orderNumber) {
		window.location.href = RootPath + 'Backend/order/download/'+orderNumber;
	}
	
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {order_number:id};
			
			$http.post(RootPath + 'Backend/order/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	
	
	NG.getSpecifyOrder = function(id) {
		var data = {order_number:id};
		$http.post(RootPath + 'Backend/order/get_specify_order', data).success(function(result) {
				if(result.code == 200 ) {
					NG.orders = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('memberCtrl', function($scope, $http, template, $compile, List, upload) {
	var NG = $scope;
		
	NG.member = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.member = {};
		NG.isEdit = false;
		template.getTemplate('member-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.chk_all = function(obj) {
		if ($(obj).prop('checked')) {
			for (var i in NG.data) {
				NG.data[i].is_chk = NG.data[i].id;
			}
		} else {
			for (var i in NG.data) {
				delete NG.data[i].is_chk;
			}
		}
	}
	
	
	
	NG.showSendMessageUI = function() {
		var count = 0;
		
		for (var i in NG.data) {
			NG.data[i].is_chk ? count++ : '';
		}
		
		if (count == 0) {
			generate({'text':'请至少选择一个会员', 'type':'error'});
			return;
		}
		
		template.getTemplate('send-message', NG, function(content) {
			NG.showSendMessageUICallBack(content);
		});
	}
	
	NG.sendMessage = function() {
		var data = NG.message;
		
		if (typeof data.title == 'undefined') {
			generate({'text':'标题不能为空', 'type':'error'});
			return;
		}
		
		if (typeof data.content == 'undefined') {
			generate({'text':'内容不能为空', 'type':'error'});
			return;
		}
		
		$http.post(RootPath + 'Backend/message/send_message', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				$('.ui-dialog-close').click();
				NG.getAllContent();
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.showSendMessageUICallBack = function(content) {
		$('.ui-popup').remove();
		$('#showSendMessage').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '发送留言',
			'content' : $('#showSendMessage'),
			'id' : 'showSendMessage'
			
		}).show();
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveMember').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加会员',
			'content' : $('#saveMember'),
			'id' : 'saveMember'
			
		}).show();
	}
	
	
	
	NG.addContent = function() {
		var data = NG.member;
		if (typeof NG.member.username == 'undefined') {
			generate({'text':'用户名不能为空', 'type':'error'});
			return;
		}
		
		if (typeof NG.member.password == 'undefined') {
			generate({'text':'密码不能为空', 'type':'error'});
			return;
		}
		
		if (typeof NG.member.email == 'undefined') {
			generate({'text':'邮箱地址不能为空', 'type':'error'});
			return;
		}
		
		data = $.extend({}, data, {'is_edit':false});
		
		$http.post(RootPath + 'Backend/member/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/member/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.member = {};
		NG.isEdit = true;
		NG.getSpecifyMember(id);
		
		template.getTemplate('member-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
		
		List.getAllProvinces(NG);
		
	}
	
	NG.modifyContent = function(id) {
		var data = NG.member;
		if (typeof NG.member.username == 'undefined') {
			generate({'text':'用户名不能为空', 'type':'error'});
			return;
		}
		
		
		if (typeof NG.member.email == 'undefined') {
			generate({'text':'邮箱地址不能为空', 'type':'error'});
			return;
		}
		
		data = $.extend({}, data, {'is_edit':true});
		
		$http.post(RootPath + 'Backend/member/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/member/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	
	
	NG.getSpecifyMember = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/member/get_specify_member', data).success(function(result) {
				if(result.code == 200 ) {
					NG.member = result.data;
					delete NG.member.password;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('navCtrl', function($scope, $http, template, $compile, List, sort) {
	var NG = $scope;
		
	NG.nav = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.nav = {position:1, pid:0};
		NG.isEdit = false;
		template.getTemplate('nav-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
		List.getAllNavs(NG);
	}
	
	NG.modifySort = function(id, sortValue) {
		sortValue = parseInt(sortValue);
		id = parseInt(id);
		var data = {"id":id, "sort":sortValue};
		var url = "/Backend/nav/modify_sort";
		sort.modifySort(url, data);
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveNav').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加导航',
			'content' : $('#saveNav'),
			'id' : 'saveNav'
			
		}).show();
	}
	
	
	NG.addContent = function() {
		var data = NG.nav;
		if (typeof NG.nav.name == 'undefined') {
			generate({'text':'导航名称不能为空', 'type':'error'});
			return;
		}
		
		
		data = $.extend({}, data, {'is_add':1});
		
		console.log(data)
		
		$http.post(RootPath + 'Backend/nav/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					List.getAllNavs(NG);
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyNav(id);
		
		template.getTemplate('nav-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
		List.getAllNavs(NG);
	}
	
	NG.modifyContent = function(id) {
		var data = NG.nav;
		data = $.extend({}, data, {'is_edit':1, id:id});
		
		$http.post(RootPath + 'Backend/nav/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					List.getAllNavs(NG);
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/nav/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						List.getAllNavs(NG);
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyNav = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/nav/get_specify_nav', data).success(function(result) {
				if(result.code == 200 ) {
					NG.nav = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	List.getAllNavs(NG);
	
	
})

Module.controller('flinkCtrl', function($scope, $http, template, $compile, List, upload) {
	var NG = $scope;
		
	NG.flink = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.flink = {};
		NG.isEdit = false;
		template.getTemplate('flink-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveFlink').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加友情链接',
			'content' : $('#saveFlink'),
			'id' : 'saveFlink'
			
		}).show();
	}
	
	NG.$watch('files', function () {
       upload.uploadFile(RootPath + 'Backend/common/upload_image', NG.files, NG, function(NG, data) {
		   NG.flink = $.extend({}, NG.flink, {'thumb':data.data.relative_path + data.data.file_name});
	   });
    });
	
	NG.addContent = function() {
		var data = NG.flink;
		if (typeof NG.flink.name == 'undefined') {
			generate({'text':'链接名称不能为空', 'type':'error'});
			return;
		}
		
		
		data = $.extend({}, data, {'is_edit':false});
		
		$http.post(RootPath + 'Backend/flink/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/flink/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyFlink(id);
		
		template.getTemplate('flink-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
	}
	
	NG.modifyContent = function(id) {
		var data = NG.flink;
		data = $.extend({}, data, {'is_edit':true, id:id});
		
		$http.post(RootPath + 'Backend/flink/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/flink/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyFlink = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/flink/get_specify_flink', data).success(function(result) {
				if(result.code == 200 ) {
					NG.flink = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('hotSearchCtrl', function($scope, $http, template, $compile) {
	var NG = $scope;
		
	NG.hotsearch = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.hotsearch = {};
		NG.isEdit = false;
		template.getTemplate('hot-search-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveHotSearch').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加热搜关键词',
			'content' : $('#saveHotSearch'),
			'id' : 'saveHotSearch'
			
		}).show();
	}
	
	
	NG.addContent = function() {
		var data = NG.hotsearch;
		if (typeof NG.hotsearch.keywords == 'undefined') {
			generate({'text':'链接名称不能为空', 'type':'error'});
			return;
		}
		
		data = $.extend({}, data, {'is_edit':false});
		
		$http.post(RootPath + 'Backend/hot_search/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/hot_search/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyFlink(id);
		
		template.getTemplate('hot-search-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
	}
	
	NG.modifyContent = function(id) {
		var data = NG.hotsearch;
		data = $.extend({}, data, {'is_edit':true, id:id});
		
		$http.post(RootPath + 'Backend/hot_search/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/hot_search/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyFlink = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/hot_search/get_specify_hot_search', data).success(function(result) {
				if(result.code == 200 ) {
					NG.hotsearch = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('pieceCtrl', function($scope, $http, template, $compile) {
	var NG = $scope;
		
	NG.piece = {};
	
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		$('.ui-dialog-close').click();
		NG.piece = {};
		NG.isEdit = false;
		template.getTemplate('piece-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.showAddUICallback = function(content) {
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加碎片',
			'content' : $('#savePiece'),
			'id' : 'savePiece',
			'align' : 'top center'
			
		}).show();
	}
	
	
	NG.addContent = function() {
		var data = NG.piece;
		if (typeof NG.piece.name == 'undefined') {
			generate({'text':'碎片名称不能为空', 'type':'error'});
			return;
		}
		
		
		data = $.extend({}, data, {'is_edit':false});
		
		$http.post(RootPath + 'Backend/piece/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/piece/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyPiece(id);
		
		template.getTemplate('piece-add', NG, function(content) {
			NG.showAddUICallback(content);
			
		});
	}
	
	NG.modifyContent = function(id) {
		var data = NG.piece;
		data = $.extend({}, data, {'is_edit':true, id:id});
		
		$http.post(RootPath + 'Backend/piece/save', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					$('.ui-dialog-close').click();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {id:id};
			
			$http.post(RootPath + 'Backend/piece/delete', data).success(function(result) {
					if(result.code == 200 ) {
						generate({"text":result.message, "type":"success"});
						NG.getAllContent();
					} else {
						generate({"text":result.message, "type":"error"});
					}
				});
		}
	}
	
	NG.getSpecifyPiece = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/piece/get_specify_piece', data).success(function(result) {
				if(result.code == 200 ) {
					NG.piece = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getAllContent();
	
	
})

Module.controller('formCtrl', function($scope, $http, template, $compile, sConfig) {
	var NG = $scope;
	
	NG.formArray = [];
	
	var isEdit = false;
	
	NG.showAddUI = function() {
		isEdit = false;
		NG.form = {};
		NG.isEdit = false;
		template.getTemplate('form-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.showAddUICallback = function(content) {
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加自定义表单',
			'content' : $('#saveForm'),
			'id' : 'saveForm',
			
		}).show();
	}
	
	NG.getForm = function() {
		$http.post(RootPath + "Backend/form/get_form").success(function(result) {
			if(result.code == 200 ) {
				
				NG.data = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.deleteForm = function(formId) {
		if (window.confirm('你真的要删除吗?')) {
			var data = {"form_id":formId};
			$http.post(RootPath + "Backend/form/delete_form", data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.buildCode = function(formId) {
		window.open(RootPath + 'Backend/form/build_form/'+formId);
	}
	
	NG.addForm = function() {
		var First = {'fields':NG.form.fields, 'label_fields':NG.form.label_fields, 'form_type':NG.form.form_type, 'values':NG.form.values};
		
		var data = {'table_struct':[First], 'form_name':NG.form.name, 'table_name':NG.form.table_name, 'recevied':NG.form.recevied};
		
		if (NG.formArray.length > 0) {
			for (var i in NG.formArray) {
				if (NG.formArray[i].fields) {
					data.table_struct.push({'fields':NG.formArray[i].fields, 'label_fields':NG.formArray[i].label_fields, 'form_type':NG.formArray[i].form_type, 'values':NG.formArray[i].values});
				}
			}
		}
		
		var url = isEdit ? RootPath + 'Backend/form/edit' : "/Backend/form/add";
		
		$http.post(url, data).success(function(result) {
				if(result.code == 200 ) {
					window.location.reload();
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		
	}
	
	NG.addTableTr = function() {
		NG.formArray.push({'fields':'', 'label_fields':'', 'values':'', 'form_type':'text'});
	}
	
	NG.deleteTableTr = function(index) {
		NG.formArray.splice(index, 1);
	}
	
	NG.getForm();
	
	sConfig.getFormTypeConfig(NG);
})


Module.controller('formManagementCtrl', function($scope, $http, List, template, $compile) {
	var NG = $scope;
	
	NG.showFormContent = function() {
		if (typeof NG.formId == 'undefined') {
			generate({'text':'请先选择一个表单', 'type':'error'});
			return;
		}
		var data = {"formId":NG.formId};
		$http.post(RootPath + 'Backend/form/get_form_content_list', data).success(function(result) {
			if(result.code == 200 ) {
				NG.data = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.deleteFormContent = function(id) {
		if (window.confirm('你确定要删除吗?')) {
			if (typeof NG.formId == 'undefined') {
				generate({'text':'请先选择一个表单', 'type':'error'});
				return;
			}
			
			var data = {"formId":NG.formId, "id":id};
			$http.post(RootPath + 'Backend/form/delete_form_content', data).success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
					NG.showFormContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
		
	}
	
	
	
	NG.showContentUICallback = function(content, id) {
		$('.ui-popup').remove();
		$('#showFormContent').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '表单内容',
			'content' : $('#showFormContent'),
			'id' : 'showFormContent'
			
		}).show();
		
		NG.getSpecifyFormContent(id);
	}
	
	
	NG.showContentUI = function(id) {
		
		
		template.getTemplate('form-content-show', NG, function(content) {
			NG.showContentUICallback(content, id);
		});
		
		
	}
	
	NG.getSpecifyFormContent = function(id) {
		if (typeof NG.formId == 'undefined') {
			generate({'text':'请先选择一个表单', 'type':'error'});
			return;
		}
		
		var data = {"formId":NG.formId, "id":id};
		
		$http.post(RootPath + 'Backend/form/show_form_content', data).success(function(result) {
			if(result.code == 200 ) {
				NG.fields = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	List.getAllForms(NG);
})

Module.controller('templatesCtrl', function($scope, $http, template, $compile) {
    var NG = $scope;
    NG.getData = function() {
		$http.post(RootPath + 'Backend/templates/get_templates').success(function(result) {
				if(result.code == 200 ) {
                    NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
    }

	NG.showEditorUI = function(filename) {
        var data = {"template":'template-edit'};
        $http.post(RootPath + "Backend/template/get_template", data).success(function(result) {
            if(result.code == 200 ) {
                return result;
            } else {
                generate({"text":result.message, "type":"error"});
            }
        }).then(function(data) {
            var content = $compile(data.data.data)(NG);
            $(content).appendTo('.content');
            dialog({
                'title' : '编辑模板',
                'content' : $('#editTemplate'),
                'id' : 'editTemplate'
                
            }).show();

        }).then(function() {
            var data = {filename:filename};
            NG.filename = filename;
            $http.post(RootPath + 'Backend/templates/get_template_content', data).success(function(result) {
                if(result.code == 200 ) {
                    return result;
                } else {
                    generate({"text":result.message, "type":"error"});
                }
            }).then(function(content) {
                editAreaLoader.setValue('template', content.data.data);
            });
        });
	}
	
    NG.saveTemplate = function() {
        var data = {content:editAreaLoader.getValue('template'), filename:NG.filename};
        $http.post(RootPath + 'Backend/templates/save_template', data).success(function(result) {
            if(result.code == 200 ) {
                dialog({id:'editTemplate'}).remove();
                editAreaLoader.delete_instance('template');
                window.location.reload();
            } else {
                generate({"text":result.message, "type":"error"});
            }
        });
    }

	NG.deleteTemplate = function(filename) {
		if (window.confirm('你确定要删除该模板吗?删除后不可恢复')) {
			var data = {"filename":filename};
			$http.post(RootPath + 'Backend/templates/delete_templates', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
                    NG.getData();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}

    NG.getData();
});

Module.controller('logCtrl', function($scope, $http) {
    var NG = $scope;
    NG.getData = function(page) {
		var data = NG.queryObj;
		page = typeof page == 'undefined' ? 1 : page;
		
		data = $.extend({}, data, {page:page});
		$http.post(RootPath + 'Backend/log/get_data', data).success(function(result) {
            if(result.code == 200 ) {
                NG.data = result.data.data;
                NG.totalPages = [];
                NG.totalPages2 = result.data.total_pages;
                
                for (var i=1; i<=result.data.total_pages; i++) {
                    NG.totalPages.push(i);
                }
                
                NG.currentPage = result.data.current_page;
            } else {
                generate({"text":result.message, "type":"error"});
            }
        });
    }

    NG.clean = function() {
        if (window.confirm('你真的要清空吗?')) {
            $http.post(RootPath + 'Backend/log/clean').success(function(result) {
                if(result.code == 200 ) {
                    generate({"text":result.message, "type":"success"});
                    NG.getData();
                } else {
                    generate({"text":result.message, "type":"error"});
                }
            });

        }
    }

    NG.deleteLog = function(id) {
        var data= {id:id};
		$http.post(RootPath + 'Backend/log/delete_data', data).success(function(result) {
            if(result.code == 200 ) {
                generate({"text":result.message, "type":"success"});
                NG.getData();
            } else {
                generate({"text":result.message, "type":"error"});
            }
        });
    }

    NG.getData();
})

Module.controller('databaseCtrl', function($scope, $http, List) {
	var NG = $scope;
	
	NG.backup = function(obj) {
		$(obj).html('备份中...').prop('disabled');
		$http.post(RootPath + 'Backend/tools/backup_database').success(function(result) {
				$(obj).html('一键备份').removeAttr('disabled');
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getBackup();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getBackup = function() {
		$http.post(RootPath + 'Backend/tools/get_backup_file').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteBackup = function(filename) {
		if (window.confirm('你确定要删除该备份吗?删除后不可恢复')) {
			var data = {"filename":filename};
			$http.post(RootPath + 'Backend/tools/delete_backup_file', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getBackup();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.restoreBackup = function(filename) {
		if (window.confirm('你确定要还原该备份文件吗?用户登录名和密码也会被还原')) {
			var data = {"filename":filename};
			$http.post(RootPath + 'Backend/tools/restore_backup_file', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.getBackup();
})

Module.controller('sitemapCtrl', function($http, $scope) {
	var NG = $scope;
	
	NG.buildMap = function() {
		var domain = window.location.protocol == 'https:' ? 'https://' : 'http://';
		domain += window.location.host;
		
		var data = {"domain":domain};
		$http.post(RootPath + 'Backend/tools/build_sitemap', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
})

Module.controller('buildHtmlCtrl', function($scope, $http, List) {
	var NG = $scope;
	
	NG.types = [{'id':"1", 'name':'单页'}, {'id':"2", 'name':'列表'}, {'id':"3", 'name':'详细'}]
	
	NG.data = [];
	
	NG.addRule = function() {
		NG.data.unshift({'destination_rule':'', 'source_rule':'', 'type':2})
		NG.changeAction();
	}
	
	NG.deleteContent = function(index) {
		NG.data.splice(index,1);
		NG.changeAction();
	}
	
	NG.getRule = function() {
		$http.post(RootPath + 'Backend/build_html/get_rule').success(function(result) {
				
			if(result.code == 200 ) {
				NG.data = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.buildRule = function() {
		if (window.confirm('此操作会覆盖以下所有规则, 你确定吗?')) {
			generate({"text":'生成中...', "type":"success"});
			$http.post(RootPath + 'Backend/build_html/build_rule').success(function(result) {
					
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.changeAction = function() {
		NG.isChanged = 1;
	}
	
	NG.buildSingleHtml = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/build_html/build_single_html',data).success(function(result) {
			NG.maskAndNoticeBoxShow();
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				NG.maskHide();
			} else if (result.code == 202) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.childProcess(result.data);
			} else {
				generate({"text":result.message, "type":"error"});
				NG.maskHide();
			}
		});
	}
	
	NG.buildIndex = function() {
		$http.post(RootPath + 'Backend/build_html/build_index_html').success(function(result) {
				
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.buildHtml = function() {
		NG.maskAndNoticeBoxShow();
		$http.post(RootPath + 'Backend/build_html/build_html').success(function(result) {
				
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
			} else if (result.code == 202) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.childProcess(result.data);
			} else if (result.code == 201) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.asynBuildHtml(result.data);
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.asynBuildHtml = function(data) {
		$http.post(RootPath + 'Backend/build_html/asyn_build_html', data).success(function(result) {
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.maskHide();
			} else if (result.code == 201) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.asynBuildHtml(result.data);
			} else if (result.code == 202) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.childProcess(result.data);
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.childProcess = function(data) {
		$http.post(data.url, data.data).success(function(result) {
			if (result.code == 200) {
				generate({"text":result.message, "type":"success"});
				NG.maskHide();
			} else if (result.code == 201) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.asynBuildHtml(result.data);
			} else if (result.code == 202) {
				$('<span>'+result.message+'</span>').appendTo('#noticeBox');
				NG.childProcess(result.data);
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.maskAndNoticeBoxShow = function() {
		$('<div id="mask"></div>').appendTo('body');
		$('<div id="noticeBox" style="overflow-y: scroll"><span>正在生成,请稍候...<br /></span></div>').appendTo('body');
	}
	
	NG.maskHide = function() {
		$('#mask').remove();
		$('#noticeBox').remove();
	}
	
	NG.saveRule = function() {
		var data = {'rules': NG.data};
		$http.post(RootPath + 'Backend/build_html/save_rule', data).success(function(result) {
					
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					delete NG.isChanged;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	
	List.getAllColumn(NG);
	
	NG.getRule();
})

Module.controller('keywordsCtrl', function($scope, $http, template, $compile) {
	var NG = $scope;
	NG.modelArray = [{}];
	NG.keyword = {target:1, url: '/', style:{fontsize: 14, color:'#ff0000', fontweight:'1'}};
	NG.isEdit = false;
	
	NG.showAddUI = function() {
		NG.keyword = {target:1, url: '/', style:{fontsize: 14, color:'#ff0000', fontweight:'1'}};
		NG.isEdit = false;
		template.getTemplate('keywords-add', NG, function(content) {
			NG.showAddUICallback(content);
		});
		
	}
	
	NG.showAddUICallback = function(content) {
		$('.ui-popup').remove();
		$('#saveHotSearch').remove();
		var content = $compile(content)(NG);
		$(content).appendTo('.content');
		dialog({
			'title' : '添加文章关键词',
			'content' : $('#saveHotSearch'),
			'id' : 'saveHotSearch'
			
		}).show();
	}
	
	NG.preview = function() {
		var keyword = NG.keyword;
		var target = ' target="'+(keyword.target==1?'_blank':'_self')+'"';
		var style = ' style="font-size:'+keyword.style.fontsize+'px; color:'+keyword.style.color+'; font-weight:' + (keyword.style.fontweight==1?'bold':'normal') +'"';
		var _html = '';
		_html = '<a href="'+keyword.url+'" '+target+style+'>'+keyword.keyword+'</a>';
		$('#fontPreview').html(_html);
	}
	
	NG.addContent = function() {
		var data = NG.keyword;
		if (typeof data.keyword == 'undefined' || data.keyword == '') {
			generate({'text':'关键词不能为空', 'type':'error'});
			return;
		}
		
		if (typeof data.url == 'undefined' || data.url == '') {
			generate({'text':'必须是合法的url', 'type':'error'});
			return;
		}
		
		$http.post(RootPath + 'Backend/keywords/add_content', data).success(function(result) {
			
			if(result.code == 200 ) {
				generate({"text":result.message, "type":"success"});
				dialog({'id':'saveHotSearch'}).remove();
				NG.getAllContent();
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.showModifyUI = function(id) {
		NG.isEdit = true;
		NG.getSpecifyKeyword(id);
		
	}
	
	NG.modifyContent = function(id) {
		var data = NG.keyword;
		if (typeof data.keyword == 'undefined' || data.keyword == '') {
			generate({'text':'关键词不能为空', 'type':'error'});
			return;
		}
		
		if (typeof data.url == 'undefined' || data.url == '') {
			generate({'text':'必须是合法的url', 'type':'error'});
			return;
		}
		
		
		$http.post(RootPath + 'Backend/keywords/edit', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					dialog({'id':'saveHotSearch'}).remove();
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.getSpecifyKeyword = function(id) {
		var data = {id:id};
		$http.post(RootPath + 'Backend/keywords/get_specify_keyword', data).success(function(result) {
				if(result.code == 200 ) {
					NG.keyword = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			}).then(function() {
				$http.post(RootPath + "Backend/template/get_template", {template:'keywords-add'}).success(function(result) {
					if(result.code == 200 ) {
						NG.showAddUICallback(result.data);
					} else {
						generate({"text":result.message, "type":"error"});
					}
				}).then(function() {
					NG.preview();
				});
				
			});
	}
	
	NG.deleteContent = function(id) {
		if (window.confirm('你确定要删除吗?')) {
			var data = {id:id};
			$http.post(RootPath + 'Backend/keywords/delete', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getAllContent();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.getAllContent = function() {
		$http.post(RootPath + 'Backend/keywords/get_all').success(function(result) {
			
			if(result.code == 200 ) {
				NG.data = result.data;
			} else {
				generate({"text":result.message, "type":"error"});
			}
		});
	}
	
	NG.getAllContent();
});

Module.controller('qrcodeCtrl', function($scope, $http) {
	var NG = $scope;
	
	NG.buildQrcode = function() {
		if (typeof NG.qrCode == 'undefined') {
			generate({'text':'请先输入内容', 'type':'error'});
		} else {
			var data = {'text':NG.qrCode};
			$http.post(RootPath + 'Backend/tools/build_qr_code', data).success(function(result) {
				
				if(result.code == 200 ) {
					$('<img src="'+result.data+'" id="qrCode" />').appendTo('#qrCodeArea');
					dialog({
						'title':'二维码',
						'content': $('#qrCode'),
						'id':'qrCode'
					}).show();
					
					NG.getQrfile();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.getQrfile = function() {
		$http.post(RootPath + 'Backend/tools/get_qrcode_file').success(function(result) {
				if(result.code == 200 ) {
					NG.data = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
	}
	
	NG.deleteQrcode = function(filename) {
		if (window.confirm('你确定要删除吗?')) {
			var data = {"filename":filename};
			$http.post(RootPath + 'Backend/tools/delete_qrcode_file', data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
					NG.getQrfile();
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	}
	
	NG.showQrCode = function(filename) {
		$('<img src="/uploads/qrcode/'+filename+'" id="qrCode" />').appendTo('#qrCodeArea');
		dialog({
				'title':'二维码',
				'content': $('#qrCode'),
				'id':'qrCode'
			}).show();
	}
	
	NG.getQrfile();
})

Module.service('upload', function($http, Upload) {
	var obj = {
		uploadFile:function(url, files, NG, callback) {
			if (files && files.length) {
				for (var i = 0; i < files.length; i++) {
					var file = files[i];
					Upload.upload({
						url: url,
						file: file
					}).progress(function (evt) {
						var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
						$('#process').show().find('span').css('width', progressPercentage + '%');
					}).success(function (data, status, headers, config) {
						$('#process').hide();
						if (data.code == 200) {
							
							(callback)(NG, data);
						} else {
							generate({'text':'上传失败', 'type':'error'});
						}
					});
				}
			}
		},
		
	};
	
	return obj;
});

Module.service('sort', function($http) {
	var obj = {
		modifySort:function(url, data) {
			$http.post(url, data).success(function(result) {
				if(result.code == 200 ) {
					generate({"text":result.message, "type":"success"});
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	};
	return obj;
})

Module.service('sConfig', function($http) {
	var obj = {
		getChannelTypeConfig:function(NG) {
			$http.post(RootPath + "Backend/channel/get_channel_type").success(function(result) {
				if(result.code == 200 ) {
					NG.channelType = [];
					for (var i in result.data) {
						NG.channelType.push({'name':i, 'value':result.data[i]});
					}
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getFormTypeConfig:function(NG) {
			$http.post(RootPath + "Backend/form/get_form_type").success(function(result) {
				if(result.code == 200 ) {
					NG.formType = [];
					for (var i in result.data) {
						NG.formType.push({'name':i, 'value':result.data[i]});
					}
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	};
	
	return obj;
	
});

Module.service('List', function($http) {
	var obj = {
		getChannelType:function(NG) {
			$http.post(RootPath + "Backend/channel/get_model").success(function(result) {
				if(result.code == 200 ) {
					NG.channels = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllColumn:function(NG) {
			$http.post(RootPath + "Backend/column/get_column").success(function(result) {
				if(result.code == 200 ) {
					NG.columns = result.data;
					for(var i in NG.columns) {
						NG.columns[i].space = "　".repeat(parseInt(NG.columns[i].level)*2);
					}
					
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllAdPosition:function(NG) {
			$http.post(RootPath + 'Backend/ad_position/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.adPositions = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllTables:function(NG) {
			$http.post(RootPath + 'Backend/tools/get_all_tables').success(function(result) {
				if(result.code == 200 ) {
					NG.tables = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllRights:function(NG) {
			$http.post(RootPath + 'Backend/right/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.rights = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllRoles:function(NG) {
			$http.post(RootPath + 'Backend/role/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.roles = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllNavs:function(NG) {
			$http.post(RootPath + 'Backend/nav/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.navs = result.data;
					for(var i in NG.navs) {
						NG.navs[i].space = "　".repeat(parseInt(NG.navs[i].level)*2);
					}
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllForms:function(NG) {
			$http.post(RootPath + 'Backend/form/get_form').success(function(result) {
				if(result.code == 200 ) {
					NG.forms = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllProvinces:function(NG) {
			$http.post(RootPath + 'Backend/member/get_provinces').success(function(result) {
				if(result.code == 200 ) {
					NG.provinces = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllCities:function(NG, provinceId) {
			var data = {"id":provinceId};
			$http.post(RootPath + 'Backend/member/get_cities', data).success(function(result) {
				if(result.code == 200 ) {
					NG.cities = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllAreas:function(NG, cityId) {
			var data = {"id":cityId};
			$http.post(RootPath + 'Backend/member/get_areas', data).success(function(result) {
				if(result.code == 200 ) {
					NG.areas = result.data;
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
		getAllMembers:function(NG) {
			$http.post(RootPath + 'Backend/member/get_all').success(function(result) {
				if(result.code == 200 ) {
					NG.members = result.data;
					NG.members.unshift({"id":0, "username":'system', "true_name":'系统'});
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		}
	};
	
	return obj;
});

Module.service('deleteFile', function($http) {
	var obj = {
		doIt:function(data, NG, callback) {
			callback = callback || function() {};
			data = {path:data};
			$http.post(RootPath + "Backend/common/delete_file", data).success(function(result) {
				if(result.code == 200 ) {
					(callback)(result.data);
				}
			});
		},
	};
	
	return obj;
})

Module.service('template', function($http) {
	var obj = {
		getTemplate:function(template, NG, callback) {
			var data = {"template":template};
			$http.post(RootPath + "Backend/template/get_template", data).success(function(result) {
				if(result.code == 200 ) {
					(callback)(result.data);
				} else {
					generate({"text":result.message, "type":"error"});
				}
			});
		},
	};
	
	return obj;
})
