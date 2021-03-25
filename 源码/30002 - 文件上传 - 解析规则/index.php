<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>解析上传</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("不允许上传的文件格式", "", "error");
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
            $blacklist = array("php", "php7", "php5", "php4", "php3", "phtml", "pht", "jsp", "jspa", "jspx", "jsw", "jsv", "jspf", "jtml", "asp", "aspx", "asa", "asax", "ascx", "ashx", "asmx", "cer", "swf");
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
            <img src="./imgs/htaccess.jpg" class="rounded mx-auto d-block" width="300px"><br>
            <p class="lead">
            htaccess 文件是 Apache 服务器中的一个配置文件，它负责相关目录下的网页配置。通过 htaccess 文件，可以帮我们实现：网页301重定向、自定义 404 错误页面、改变文件扩展名、允许/阻止特定的用户或者目录的访问、禁止目录列表、配置默认文档等功能</p><br>
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$name.'" class="rounded mx-auto d-block" width="100px">';
                    }
                ?>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleFormControlFile1">文章插入图片</label>
                <input type="file" class="form-control-file" name="file" id="file">
                <input type="submit" name="submit" value="Upload" />
              </div>
            </form>
        </div>
    </div>
</body>
</html>