<link rel="stylesheet" href="<?php echo base_url() ?>static/plugins/bootstrap-fileinput/css/fileinput.min.css">
<style>
    .half {
        display: flex;
    }

    .half .left, .half .right {
        flex: 1;
    }
</style>
<form class="bt-form pd20 pb70" id="form" style="max-height: 800px;overflow-y: auto;">
    <div class="line half">
        <div class="left">
            <span class="tname">所属栏目 <span style="color: #f00;">*</span></span>
            <div class="info-r ">
                <select name="post[category_id]" id="category_id" class="bt-input-text " style="width:230px">
                    <option value="0">请选择栏目</option>
                    <?php foreach ($category as $k => $v) { ?>
                        <option value="<?php echo $v['id'] ?>" <?php if (@$data['category_id'] == $v['id']) {
                            echo "selected";
                        } ?>><?php echo $v['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="right">
            <span class="tname">文章标题 <span style="color: #f00;">*</span></span>
            <div class="info-r ">
                <input name="post[title]" required placeholder="请输入文章标题" class="bt-input-text " type="text"
                       style="width:230px" value="<?php echo @$data['title'] ?>">
            </div>
        </div>
    </div>
    <div class="line half">
        <div class="left">
            <span class="tname">文章作者</span>
            <div class="info-r ">
                <input name="post[author]" required placeholder="请输入文章作者" class="bt-input-text " type="text"
                       style="width:230px" value="<?php echo @$data['author'] ?>">
            </div>
        </div>
        <div class="right">
            <span class="tname">关键字 </span>
            <div class="info-r ">
                <input name="post[keywords]" required placeholder="请输入关键字" class="bt-input-text " type="text"
                       style="width:230px" value="<?php echo @$data['keywords'] ?>">
            </div>
        </div>
    </div>
    <div class="line ">
        <span class="tname">文章描述</span>
        <div class="info-r ">
            <textarea draggable="false" name="post[desc]" required placeholder="请输入文章描述" class="bt-input-text mr5 "
                      type="text"
                      style="width: 100%;height: 50px;resize: none;line-height: 20px;"><?php echo @$data['desc'] ?></textarea>
        </div>
    </div>
    <div class="line ">
        <span class="tname">缩略图 <span style="color: #f00;">*</span></span>
        <div class="info-r ">
            <input id="txt_file" onchange="uploadImg()" name="file" required class="mr5 " type="file"
                   style="width:330px;border: none;" value="<?php echo @$data['pic'] ?>">
            <input type="hidden" name="post[pic]" id="thumb" value="<?php echo @$data['pic'] ?>">
        </div>
    </div>
    <div class="line ">
        <span class="tname">文章内容 <span style="color: #f00;">*</span></span>
        <div class="info-r " id="editor">
            <textarea name="post[content]" id="content" style="width: 100%;"
                      class="mr5"><?php echo @$data['content'] ?></textarea>
        </div>
    </div>
    <div class="bt-form-submit-btn">
        <button type="button" class="btn btn-sm btn-my" id="close-modal">关闭</button>
        <button type="button" class="btn btn-sm btn-success" id="submit-form">提交</button>
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">
</form>
<script>
    $(function () {
        // UE.getEditor('content', {
        //     initialFrameWidth: 'auto',
        //     initialFrameHeight: '100',
        //     autoHeightEnabled: false,
        //     zIndex: 887
        // });
    });
    UE.delEditor('content');
    UE.getEditor('content', {
        initialFrameWidth: 'auto',
        initialFrameHeight: '100',
        autoHeightEnabled: false
    });

    function uploadImg() {
        $.ajaxFileUpload({
            type: 'post',
            url: siteUrl + '/upload/doUpload',
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'txt_file', //文件上传域的ID
            data: {
                width: 230,
                height: 200,
                '<?php echo $csrf["name"];?>': '<?php echo $csrf["hash"];?>'
            },
            dataType: 'text',
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                if (data.code == 1) {
                    layer.msg("上传文件失败", {icon: 2})
                } else if (data.code == 0) {
                    layer.msg("上传文件成功", {icon: 1});
                    $("#thumb").val(data.path);
                }
            }
        });
    }
</script>