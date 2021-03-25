<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>黑名单缺陷</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("不允许上传 asp aspx php jsp 的文件后缀", "", "error");
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
            $ext = pathinfo($name)['extension'];
            $blacklist = array("asp","aspx","php","jsp","htaccess");
            
            if (!in_array($ext, $blacklist)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . $name)) {
                    $is_upload = true;
                } else {
                    echo "<script>error();</script>";
                }
            } else {
                    echo "<script>black();</script>";
            }
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/head.png" class="rounded mx-auto d-block" width="100%"><br>
            <p class="lead">
            白名单是设置能通过的用户，白名单以外的用户都不能通过。<br>
            黑名单是设置不能通过的用户，黑名单以外的用户都能通过。<br>
            所以一般情况下白名单比黑名单限制的用户要更多一些
            </p><br>
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$name.'" class="rounded mx-auto d-block" width="100px">';
                    }
                ?>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" class="form-control-file" name="file" id="file">
                <input type="submit" name="submit" value="Upload" />
              </div>
            </form>
        </div>
    </div>
</body>
</html>