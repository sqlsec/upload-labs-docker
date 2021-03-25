<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MIME 绕过</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("文件类型不正确", "", "error");
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
            if (!in_array($_FILES['file']['type'], ["image/jpeg", "image/png", "image/gif", "image/jpg"])) {
                echo "<script>black();</script>";
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

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/mime.png" class="rounded mx-auto d-block" width="100%"><br>
            <p class="lead">
            <b>媒体类型</b>（通常称为 <b>Multipurpose Internet Mail Extensions</b> 或 <b>MIME</b> 类型 ）是一种标准，用来表示文档、文件或字节流的性质和格式。<br><br>
            
            MIME的组成结构非常简单；由类型与子类型两个字符串中间用 '/' 分隔而组成。不允许空格存在。type 表示可以被分多个子类的独立类别。subtype 表示细分后的每个类型。
            </p><br>
            通用的结构为：<pre>type/subtype</pre>
            <p>MIME类型对大小写不敏感，但是传统写法都是小写。</p><br>
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