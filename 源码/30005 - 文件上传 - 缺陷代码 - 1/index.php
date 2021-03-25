<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>有缺陷的代码 1</title>
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
            $name = basename($_FILES['file']['name']);
            $blacklist = array("php", "php5", "php4", "php3", "phtml", "pht", "jsp", "jspa", "jspx", "jsw", "jsv", "jspf", "jtml", "asp", "aspx", "asa", "asax", "ascx", "ashx", "asmx", "cer", "swf", "htaccess", "ini");
            
            $name = str_ireplace($blacklist, "", $name);
        
            if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . $name)) {
                $is_upload = true;
            } else {
                echo "<script>error();</script>";
            }
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/replace.png" class="rounded mx-auto d-block" width="100%"><br>
            <p class="lead">
            网络安全永远处于一个发展更新的状态。因为漏洞是依赖于产品的，产品更新换代，漏洞也会更新换代。而且安全，实际上它是一个博弈的过程，永远有更强的聪明小伙想要制造点新麻烦。如果要是想一劳永逸的话，这个行业可能并不适合。<br><br>
            
            热爱和天赋自然会带领你走向你该去的地方，JUST DO IT！
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