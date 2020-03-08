<div class="left">
        <?php foreach ($article as $k => $v){?>
        <div class="xnews2">
            <div class="pic"><a target="_blank" href="<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$v['category_id'])?>">
                    <img src="<?php echo base_url().$v['pic']?>" alt="<?php echo $v['title']?>"/></a></div>
            <div class="dec">
                <h3><a target="_blank" href="<?php echo site_url('home/article/info?id='.$v['id'].'&catid='.$v['category_id'])?>"><?php echo $v['title']?></a></h3>
                <div class="time">发布时间：<?php echo $v['date_entered']?></div>
                <p><?php echo $v['desc']?></p>
                <div class="time">
                <?php
                    if ($v['keywords']) {
                        $arr=explode(',', $v['keywords']);
                        foreach ($arr as $key=>$value) {
                            echo "<a href='".site_url('home/index/index?search='.$value.'&catid='.$v['category_id'])."'>$value</a>";
                        }
                    }
                    
                ?>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="pages">
            <div class="plist">
                <?php echo $link;?>
            </div>
        </div>
    </div>