

<div class="commonform" id="saveOrder">
<input type="hidden"/> 
  <div class="formtitle">查看订单</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="1" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    
	<thead>
		<tr>
			<th>序号</th>
			<th width="200">商品名</th>
			<th>商品缩略图</th>
			<th>数量</th>
			<th>小计</th>
		</tr>
	</thead>
	
	<tbody>
		<tr ng-repeat="order in orders">
			<td ng-bind="$index+1"></td>
			<td ng-bind="order.title"></td>
			<td><img src="{{order.thumb}}" width="80" /></td>
			<td ng-bind="order.amount"></td>
			<td ng-bind="order.price*order.amount"></td>
		</tr>
	</tbody>
	
	
	
   
  </table>
  

</div>
