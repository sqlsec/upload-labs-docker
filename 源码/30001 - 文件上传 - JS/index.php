<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(0);

//设置上传目录
define("UPLOAD_PATH", dirname(__FILE__) . "/upload/");
define("UPLOAD_URL_PATH", str_replace($_SERVER['DOCUMENT_ROOT'], "", UPLOAD_PATH));

$is_upload = false;
if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755);
}
if (!empty($_POST['submit'])) {
    if (!$_FILES['file']['size']) {
        echo "<script>alert('请添加上传文件')</script>";
    } else {
        $name = basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . $name)) {
            $is_upload = true;
        } else {
            echo "<script>alert('上传失败')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>JavaScript 绕过</title>
    <link href="./attachs/bootstrap.sketchy.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center">永远不要相信用户的输入</h1>
            <img src="./imgs/js.png" class="rounded mx-auto d-block" width="auto"><br>
            <p class="lead">
            “永远不要相信用户的输入” 是进行安全设计和安全编码的重要准则。换句话说，任何输入数据在证明其无害之前，都是有害的。许多危险的漏洞就是因为过于相信用户的输入是善意的而导致的。</p><br>
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$name.'" class="rounded mx-auto d-block" width="100px">';
                    }
                ?>
            </div>
            <form action="" method="post" enctype="multipart/form-data" onsubmit="return checkfilesuffix()">
              <div class="form-group">
                <label for="exampleFormControlFile1">文章插入图片</label>
                <input type="file" class="form-control-file" name="file" id="file">
                <input type="submit" name="submit" value="Upload" />
              </div>
            </form>
        </div>
    
    </div>
<script>
function checkfilesuffix()
{
    var file=document.getElementsByName('file')[0]['value'];
    if(file==""||file==null)
    {
        swal("请添加上传文件", "", "error");
        return false;
    }
    else
    {
        var whitelist=new Array(".jpg",".png",".gif",".jpeg");
        var file_suffix=file.substring(file.lastIndexOf("."));
        if(whitelist.indexOf(file_suffix) == -1)
        {
            swal("只允许上传图片类型的文件!", "", "error");
            return false;
        }
    }
}

function error(){
    swal("上传失败", "", "error");
}
</script>
<script src="./attachs/sweetalert.min.js"></script>
</body>
</html>