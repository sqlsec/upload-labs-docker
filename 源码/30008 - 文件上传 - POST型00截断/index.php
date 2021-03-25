<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>古老的漏洞？</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("只允许上传 jpg jpeg png gif 类型的文件", "", "error");
        }
    </script>
    <script src="./attachs/sweetalert.min.js"></script>
    <link href="./attachs/bootstrap.sketchy.min.css" rel="stylesheet">
</head>
<body>
    <?php
        header("Content-type: text/html;charset=utf-8");
        error_reporting(0);
        define("WWW_ROOT",$_SERVER['DOCUMENT_ROOT']);
        define("UPLOAD_PATH", "./upload");
        
        $is_upload = false;
        if(isset($_POST['submit'])){
            $ext_arr = array('jpg','png','gif','jpeg');
            $file_ext = substr($_FILES['upload_file']['name'],strrpos($_FILES['upload_file']['name'],".")+1);
            if(in_array($file_ext,$ext_arr)){
                $temp_file = $_FILES['upload_file']['tmp_name'];
                $name = rand(10, 99).date("YmdHis").".".$file_ext;
                $img_path = $_POST['save_path']."/". $name;
        
                if(move_uploaded_file($temp_file,$img_path)){
                    $is_upload = true;
                } else {
                    $msg = "上传失败";
                }
            } else {
                $msg = "只允许上传.jpg|.png|.gif类型文件！";
            }
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/head.png" class="rounded mx-auto d-block" width="50%"><br>
            <p class="lead">
            PHP 内核是由 C 语言实现的，所以使用了 C 语言中的一些字符串处理函数。比如在连接字符串时候， 0 字节 (\x00) 将作为字符串结束符。所以在这个地方，攻击者只要在最后加入一个 0 字节，就能截断 file 变量之后的字符串<br><br>
            
            这种方法只适用于
            
            <ul>
                <li>magic_quotes_gpc = Off</li>
                <li>PHP 版本小于 5.3.4</li>
            </ul>
            </p><br>
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$name.'" class="rounded mx-auto d-block" width="100px">';
                    }
                ?>
            </div>
            <form method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="hidden" name="save_path" value="./upload/"/>  
                <input type="file" class="form-control-file" name="upload_file" id="file">
                <input type="submit" name="submit" value="Upload" />
              </div>
            </form>
        </div>
    </div>
</body>
</html>