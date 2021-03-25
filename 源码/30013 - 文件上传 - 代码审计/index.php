<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>代码审计</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("禁止上传该图片类型以外的文件", "", "error");
        }
    </script>
    <script src="./attachs/sweetalert.min.js"></script>
    <link href="./attachs/bootstrap.sketchy.min.css" rel="stylesheet">
    <link href="./attachs/prism.css" rel="stylesheet" >
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
            $allow_type = array('image/jpeg','image/png','image/gif');
            if(!in_array($_FILES['upload_file']['type'],$allow_type)){
                echo "<script>black();</script>";
            } else {
                $file = empty($_POST['save_name']) ? $_FILES['upload_file']['name'] : $_POST['save_name'];
                if (!is_array($file)) {
                    $file = explode('.', strtolower($file));
                }
                
                $ext = end($file);
                $allow_suffix = array('jpg','png','gif');
                
                if (!in_array($ext, $allow_suffix)) {
                    echo "<script>black();</script>";
                } else {
                    $file_name = reset($file) . '.' . $file[count($file) - 1];
                    $temp_file = $_FILES['upload_file']['tmp_name'];
                    $img_path = UPLOAD_PATH . '/' .$file_name;
                    if (move_uploaded_file($temp_file, $img_path)) {
                        $is_upload = true;
                    } else {
                        echo "<script>error();</script>";
                    }
                }
            }
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/head.png" class="rounded mx-auto d-block" width="100%"><br>
            
            <center><button type="button" class="btn btn-success" onclick="window.location.href=('?file=code.html')">点击查看 “提示”</button></center><br>
            
            <p class="lead">
                本地不属于常见的文件上传漏洞，主要考擦选手的代码审计能力。如果配置好 Xdebug 调试 PHP 的话，那么本题理解起来就会很简单，具体细节可以参考我的这篇文章：<a href="https://www.sqlsec.com/2020/09/xdebug.html" target="_blank">Xdebug+宝塔+PHPStudy+VScode PHP</a><br/><br/>
            </p><br>
                        
            <?php
                if ($_GET['file'] === 'code.html'){
                    include($_GET['file']);
                }
            ?>
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$file_name.'" class="rounded mx-auto d-block" width="50%">';
                    }
                ?>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <div class="col-md-4 col-lg-4">
                    <input class="form-control" type="text" name="save_name" placeholder="填写要保存的文件名称"/><br/>
                </div>
                <div class="col-md-4 col-lg-4">
                    <input type="file" class="form-control-file" name="upload_file" id="file">
                </div>
                <div class="col-md-4 col-lg-4">
                    <input type="submit" name="submit" value="上传" />
                </div>
              </div>
            </form>
        </div>
    </div>
</body>
</html>