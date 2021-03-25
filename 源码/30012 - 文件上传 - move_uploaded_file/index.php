<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>move_uploaded_file 绕过</title>
    <script>
        function error(){
            swal("请选择文件和填写要保存的文件名称", "", "error");
        }
        
        function black(){
            swal("不允许上传的文件类型", "", "error");
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
            $deny_ext = array("php","php5","php4","php3","php2","html","htm","phtml","pht","jsp","jspa","jspx","jsw","jsv","jspf","jtml","asp","aspx","asa","asax","ascx","ashx","asmx","cer","swf","htaccess");
    
            $file_name = $_POST['save_name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
            if(!in_array($file_ext, $deny_ext)) {
                $temp_file = $_FILES['file']['tmp_name'];
                $img_path = UPLOAD_PATH . '/' .$file_name;
                if (move_uploaded_file($temp_file, $img_path)) { 
                    $is_upload = true;
                }else{
                    echo "<script>error();</script>";
                }
            }else{
                echo "<script>black();</script>";
            }
    
        } else {
            $msg = UPLOAD_PATH . '文件夹不存在,请手工创建！';
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/head.png" class="rounded mx-auto d-block" width="85%"><br>
            <p class="lead">
                
            <code>move_uploaded_file($temp_file, $img_path)</code><br><br>
            上述函数除了 PHP 5.3.4 以下的版本可以用 00 截断绕过，就真的没有其他缺陷了吗？
            </p><br>
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
                    <input type="file" class="form-control-file" name="file" id="file">
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