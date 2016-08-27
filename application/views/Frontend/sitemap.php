
<style type="text/css">
    .map_main { overflow:hidden; border:solid 5px #F0F0F0; margin:10px 0; padding-bottom:10px; }
.sitemap_con { width:845px; margin:0 auto; color:#666;}
.sitemap_con .map_top { border-bottom:solid 1px #ccc; margin-top:35px; }
.sitemap_con .map_top img { float:left;}
.site_r_link { width:120px; margin-top:45px;/*上边界根据需要进行调整*/ border:1px solid #cdcdcd; background:#F8F8F8; padding:5px 10px; float:right; } /*网站地图，显示方式样式，上边界根据需要进行调整*/
.site_plc { background:url(/images/ico27.gif) no-repeat 0 8px; padding:5px 0; text-indent:10px;}
.sitemap_con h4 { line-height:30px; font-size:14px;}
.b4 { border:solid 1px #E0E0E0;}
.b4 ul { padding:15px;}
.b4 li { float:left ; line-height:30px;height:30px; width:180px; margin-right:20px;overflow:hidden; }
.b4 li a { color:#666;}
.b4 li a:hover { color:#0F6BD6;}

</style>
<div class="w1000">
    <div class="map_main">
        <div class="sitemap_con">
            <div class="map_top">
                <div class="site_r_link">
                    <a href="/sitemap">HTM地图</a>
                    |
                    <a href="/sitemap.xml">XML地图</a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="site_plc">
                您的位置：
                <a href="/" title="首页">首页</a>
                &gt; 网站地图
            </div>

             <h4>
                <a href="/" title="顶部导航" target="_blank">顶部导航</a>
            </h4>
                <div class="b4">
                    <ul>
                       <?php foreach($head_nav as $key =>$value) :?>
                        <li>
                             <a href="<?=$value['url']?>" title="<?=$value['name']?>" target="_blank"><?=$value['name']?></a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                    <div class="cl"></div>
                </div>
            <?php foreach($all_columns as $key=>$value) : ?>
            <h4>
                <a href="<?=build_url(1,$value['id'])?>" title="<?=$value['column_name']?>" target="_blank"><?=$value['column_name']?></a>
            </h4>
                <div class="b4">
                    <ul>
                    <?php if(!empty($value['children'])) : ?>
                        <?php foreach($value['children'] as $k=>$v) : ?>
                        <li>
                             <a href="<?=build_url(1,$v['id'])?>" title="<?=$v['column_name']?>" target="_blank"><?=$v['column_name']?></a>
                        </li>
                         <?php endforeach; ?>
                    <?php endif ;?>
                    </ul>
                    <div class="cl"></div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
