

<div class="commonform" ng-controller="documentCtrl">
<input type="hidden"/>
  <div class="formtitle">文档添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>

  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>标题</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="article.title" ng-model="article.title" placeholder="标题" /></td>
      <td>&nbsp;</td>
    </tr>




	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>所属栏目</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<select name="" id="" ng-model="article.cid" ng-change="getStruct(article.cid)" ng-options="c.id as c.space+c.column_name for c in columns" placeholder="父栏目ID">
			<option value="">请选择栏目</option>
		</select>
	  </td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>排序</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="排序" ng-model="article.sort"  />
	  </td>
      <td>&nbsp;</td>
    </tr>

	 <tr id="thumb">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>缩略图</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="width:330px;">
		<input type="text" ng-model="article.thumb" placeholder="缩略图"   />


		<button class="button" ngf-select ng-model="files">上传</button>
	  </td>
       <td>
      <button class="button" ng-click="article.thumb=''">删除</button>
      <imageselect ng-model="article.thumb"></imageselect>
      <div id="process" style="width:200px; height:12px; border:1px solid #ccc; padding:0; position:relative; display:none;"><span style="width:10%; height:100%; display:inline-block; background:green; margin:0; position:absolute; "></span></div>

    <img ng-show="article.thumb" ng-model="article.thumb" id="fullPath" src="{{article.thumb}}"  alt="" width="80" /></td>
    </tr>



	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>TAG标签</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text"  ng-model="article.tag" placeholder="TAG标签" cols="40" rows="3" />
	  </td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>文章摘要</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea  ng-model="article.abstract" placeholder="文章摘要" cols="40" rows="3"></textarea>
	  </td>
      <td>&nbsp;</td>
    </tr>


	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SEO标题</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" name="" id="" ng-model="article.seo_title" placeholder="seo标题" />
	  </td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SEO关键词</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" name="" id="" ng-model="article.seo_keywords" placeholder="SEO关键词" />
	  </td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SEO描述</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea  ng-model="article.seo_description" placeholder="SEO描述" cols="40" rows="3"></textarea>
	  </td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>副标题</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="article.sub_title" ng-model="article.sub_title" placeholder="副标题" /></td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>作者</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="article.author" ng-model="article.author" placeholder="作者" /></td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>来源</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="article.source" ng-model="article.source" placeholder="来源" /></td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>推荐类型</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:None!important;">
		<?php foreach ($recommend_types as $k=>$v) : ?>
			<input type="checkbox" ng-model="article.recommend_type.<?=$k?>" ng-true-value="<?=$k?>" ng-false-value="" /> <?=$v?>
		<?php endforeach ?>
	  </td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>创建时间</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:None!important;"><quick-datepicker ng-model='article.create_time' placeholder="点击设置时间" date-format="M/d/yyyy"></quick-datepicker></td>
      <td>&nbsp;</td>
    </tr>

	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>是否延迟发布</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:None!important;"><input type="checkbox" value="1" ng-true-value="1" ng-false-value="0" ng-model="delayRelease" /><quick-datepicker ng-model='article.delay_time' ng-hide="delayRelease==0" placeholder="点击设置时间" date-format="M/d/yyyy"></quick-datepicker></td>
      <td>&nbsp;</td>
    </tr>



  </table>


  <table border="0" cellpadding="1" cellspacing="1" style="width:650px;">
    <tbody><tr>
      <td style="width:5px;"></td>
      <td style="width:100px" align="right">&nbsp;</td>
      <td style="width:10px;">&nbsp;</td>
      <td style="width:200px;">&nbsp;</td>
      <td style="width:3px">&nbsp;</td>
      <td style="width:100px" align="right">&nbsp;</td>
      <td style="width:10px">&nbsp;</td>
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="columnId" value="保存" ng-click="addContent();"><input type="button" id="submitform" class="buttons button2" ng-show="columnId" value="保存" ng-click="modifyContent();"></td>
    </tr>
  </tbody>
	</table>


</div>
