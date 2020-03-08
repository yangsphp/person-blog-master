<form class="bt-form pd20 pb70" id="form">
    <div class="line ">
        <span class="tname">名称 <span style="color: #f00;">*</span></span>
        <div class="info-r ">
            <input name="post[name]" required placeholder="请输入链接名称" class="bt-input-text mr5 " type="text" style="width:330px" value="<?php echo @$data['name']?>">
        </div>
    </div>
    <div class="line ">
        <span class="tname">地址 <span style="color: #f00;">*</span></span>
        <div class="info-r ">
            <input name="post[url]" required placeholder="请输入链接地址" class="bt-input-text mr5 " type="text" style="width:330px" value="<?php echo @$data['url']?>">
        </div>
    </div>
    <div class="line ">
        <span class="tname">描述</span>
        <div class="info-r ">
            <input name="post[desc]" required placeholder="请输入链接描述" class="bt-input-text mr5 " type="text" style="width:330px" value="<?php echo @$data['desc']?>">
        </div>
    </div>
    <div class="bt-form-submit-btn">
        <button type="button" class="btn btn-sm btn-my" id="close-modal">关闭</button>
        <button type="button" class="btn btn-sm btn-success" id="submit-form">提交</button>
    </div>
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
</form>
<script>

</script>