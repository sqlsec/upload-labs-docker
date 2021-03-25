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

        function success(){
            swal("上传成功", "", "success");
        }
    </script>
    <script src="./attachs/sweetalert.min.js"></script>
    <link href="./attachs/bootstrap.sketchy.min.css" rel="stylesheet">
</head>
<body>
    <?php
        header("Content-type: text/html;charset=utf-8");
        error_reporting(0);
        //设置上传目录
        define("UPLOAD_PATH", dirname(__FILE__) . "/upload/");
        define("UPLOAD_URL_PATH", str_replace($_SERVER['DOCUMENT_ROOT'], "", UPLOAD_PATH));
        if (!file_exists(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755);
        }
        $is_upload = false;
        if (!empty($_POST['submit'])) {
            $name = basename($_FILES['file']['name']);
            $info = pathinfo($name);
            $ext = $info['extension'];
            $whitelist = array("jpg", "jpeg", "png", "gif");
            if (in_array($ext, $whitelist)) {
                
                $filename = rand(10, 99) . date("YmdHis") . "." . $ext;
                $des = $_GET['road'] . "/" . $filename;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $des)) {
                    $is_upload = true;
                } else {
                    echo "<script>black();</script>";
                }
            } else {
                echo "文件类型不匹配";
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
                        echo '<script>success();</script>';
                        echo '<img src="./upload/'. $filename .'" class="rounded mx-auto d-block" width="100px">';
                    }
                ?>
            </div>
            <form action=<?php echo "?road=" . UPLOAD_PATH; ?> method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" class="form-control-file" name="file" id="file">
                <input type="submit" name="submit" value="Upload" />
              </div>
            </form>
        </div>
    </div>
</body>
</html>