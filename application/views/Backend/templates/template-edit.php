


<div class="commonform" id="editTemplate">
<input type="hidden"/> 
  <div class="formtitle">模板编辑</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <div>
	<textarea id="template" style="height: 350px; width: 100%;" name="test_1"></textarea>
	
	<button class="buttons button2" ng-click="saveTemplate()">保存</button>
  </div>
	
	<script type="text/javascript">
		editAreaLoader.init({
				id: "template"	// id of the textarea to transform		
				,start_highlight: true	// if start with highlight
				,allow_resize: "both"
				,allow_toggle: true
				,word_wrap: true
				,language: "zh"
				,syntax: "html"	
			});
	</script>

</div>

