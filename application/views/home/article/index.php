<div class="left">
    <div class="scrap">
        <h1><?php echo $info['title']?></h1>
        <div class="spread">
            <span class="writor">发布时间：<?php echo $info['date_entered']?></span>
            <span class="writor">编辑：<?php echo $info['author']?></span>
            <span class="writor">标签：<?php
                $arr=explode(',', $info['keywords']);
                foreach ($arr as $k=>$v) {
                    echo "<a href='#'>$v</a>";
                }
                ?></span>
            <span class="writor">热度：<?php echo $info['click']?></span>
        </div>
    </div>

    <!--百度分享-->
    <script src='/jiehun/goto/my-65542.js' language='javascript'></script>

    <div class="takeaway">
        <span class="btn arr-left"></span>
        <p class="jjxq"><?php echo $info['desc']?>
        </p>
        <span class="btn arr-right"></span>
    </div>

    <script src='/jiehun/goto/my-65541.js' language='javascript'></script>

    <div class="substance">
        <?php echo $info['content']?>
    </div>
    <div class="biaoqian">

    </div>


    <!--相关阅读 -->
    <div class="xgread">
        <div class="til"><h4>相关阅读</h4></div>
        <div class="lef"><!--相关阅读主题链接-->
            <script src='/jiehun/goto/my-65540.js' language='javascript'></script>
        </div>
        <div class="rig">
            <ul>
                <?php foreach ($about as $k => $v){?>
                <li><a href="<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$info['category_id'])?>" target="_blank"><?php echo $v['title']?></a></li>
                <?php }?>
            </ul>
        </div>
    </div>

    <!--频道推荐-->
    <div class="hotsnew">
        <div class="til"><h4>频道推荐</h4></div>
        <ul>
            <?php foreach ($recommend as $k => $v){?>
            <li>
                <div class="tu">
                    <a href='<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$v['category_id'])?>' target="_blank">
                        <img src="<?php echo base_url($v['pic'])?>" alt="<?php echo $v['title']?>"/></a></div>
                <p><a href='<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$info['category_id'])?>'><?php echo $v['title']?></a></p>
            </li>
            <?php }?>
        </ul>
    </div>
</div>