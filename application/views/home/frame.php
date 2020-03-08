<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>个人博客</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="个人博客"/>
    <meta name="description" content="个人博客"/>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <link href="<?php echo base_url()?>static/home/style/lady.css" type="text/css" rel="stylesheet"/>
    <script type='text/javascript' src='<?php echo base_url()?>static/home/style/ismobile.js'></script>
</head>

<body>

<div class="ladytop">
    <div class="nav">
        <div class="left"><a href="" style="font-size:25px;color: #fff;">个人博客</a></div>
        <div class="right">
            <div class="box">
                <a href="<?php echo base_url();?>" rel=''>首页</a>
                <?php foreach ($category as $k => $v) {?>
                <a href="<?php echo base_url('home/index/index?catid='.$v['id']);?>" rel='dropmenu209'><?php echo $v['name']?></a>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<div class="hotmenu">
    <div class="con">热门标签：
        <?php foreach ($tags as $k => $v) {?>
        <a href="<?php echo site_url('home/index/index?search='.$v['name'].'&catid='.@$_GET['catid'])?>"><?php echo $v['name'];?></a>
        <?php }?>
    </div>
</div>

<!--顶部通栏-->
<div class="position">
    <?php if ($catname){?>
    <a href='<?php echo base_url();?>'>主页</a> > <a href=''><?php echo $catname;?></a>
    <?php }?>
</div>

<div class="overall">
    
    <?php echo $layout;?>

    <div class="right">
        <!--右侧各种广告-->
        <!--猜你喜欢-->
        <div id="hm_t_57953">
            <div style="display: block; margin: 0px; padding: 0px; float: none; clear: none; overflow: hidden; position: relative; border: 0px none; background: transparent none repeat scroll 0% 0%; max-width: none; max-height: none; border-radius: 0px; box-shadow: none; transition: none 0s ease 0s ; text-align: left; box-sizing: content-box; width: 300px;">
                <div class="hm-t-container" style="width: 298px;">
                    <div class="hm-t-main">
                        <div class="hm-t-header">热门点击</div>
                        <div class="hm-t-body">
                            <ul class="hm-t-list hm-t-list-img">
                                <?php foreach ($clicks as $k => $v){?>
                                <li class="hm-t-item hm-t-item-img">
                                    <a data-pos="<?php echo $k?>" title="<?php echo $v['title'].' ('.$v['click'].')'?>" target="_blank" href="<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$v['category_id'])?>" class="hm-t-img-title" style="visibility: visible;">
                                        <span><?php echo $v['title'].' ('.$v['click'].')'?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div style="height:15px"></div>
        <div id="hm_t_57953">
            <div style="display: block; margin: 0px; padding: 0px; float: none; clear: none; overflow: hidden; position: relative; border: 0px none; background: transparent none repeat scroll 0% 0%; max-width: none; max-height: none; border-radius: 0px; box-shadow: none; transition: none 0s ease 0s ; text-align: left; box-sizing: content-box; width: 300px;">
                <div style="width: 298px;" class="hm-t-container">
                    <div class="hm-t-main">
                        <div class="hm-t-header">推荐阅读</div>
                        <div class="hm-t-body">
                            <ul class="hm-t-list hm-t-list-img">
                                <?php foreach ($tuijians as $k => $v){?>
                                <li class="hm-t-item hm-t-item-img">
                                    <a style="visibility: visible;" class="hm-t-img-title" href="<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$v['category_id'])?>" target="_blank" title="<?php echo $v['title']?>" data-pos="<?php echo $k?>">
                                        <span><?php echo $v['title']?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div style="height:15px"></div>

        <div id="bdcs">
            <div class="bdcs-container">
                <meta content="IE=9" http-equiv="x-ua-compatible">   <!-- 嵌入式 -->
                <div id="default-searchbox" class="bdcs-main bdcs-clearfix">
                    <div id="bdcs-search-inline" class="bdcs-search bdcs-clearfix">
                        <form id="bdcs-search-form" autocomplete="off" class="bdcs-search-form" target="_blank" method="get" action="">
                            <input type="hidden" value="<?php echo @$this->input->get("catid");?>" name="catid">
                            <input type="text" placeholder="请输入关键词" id="bdcs-search-form-input" class="bdcs-search-form-input" name="search" autocomplete="off" style="line-height: 30px; width:220px;">
                            <input type="submit" value="搜索" id="bdcs-search-form-submit" class="bdcs-search-form-submit bdcs-search-form-submit-magnifier" style="height: 34px;">
                        </form>
                    </div>
                    <div id="bdcs-search-sug" class="bdcs-search-sug" style="top: 552px; width: 239px;">
                        <ul id="bdcs-search-sug-list" class="bdcs-search-sug-list"></ul>
                    </div>
                </div>
            </div>
        </div>

        <div style="height:15px"></div>


    </div>

</div>


<div class="footerd">
    <ul>
        <li>Copyright &#169; 2008-2016 all rights reserved 版权所有 <a href="http://www.miibeian.gov.cn" target="_blank"
                                                                   rel="nofollow">蜀icp备08107937号</a></li>
    </ul>
</div>

<div style="display:none;">
    <script src='goto/my-65537.js' language='javascript'></script>
    <script src="images/js/count_zixun.js" language="JavaScript"></script>
</div>

</body>
</html>