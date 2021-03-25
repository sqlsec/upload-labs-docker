<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文件头绕过</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("只允许上传 jpeg jpg png gif 类型的文件", "", "error");
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
            if (!$_FILES['file']['size']) {
                echo "<script>error();</script>";
            } else {
                $file = fopen($_FILES['file']['tmp_name'], "rb");
                $bin = fread($file, 4);
                fclose($file);
                if (!in_array($_FILES['file']['type'], ["image/jpeg", "image/jpg", "image/png", "image/gif"])) {
                    echo "<script>black();</script>";
                } else if (!in_array(bin2hex($bin), ["89504E47", "FFD8FFE0", "47494638"])) {
                    echo "<script>black();</script>";
                } else {
                    $name = basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . $name)) {
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
            <img src="./imgs/header.png" class="rounded mx-auto d-block" width="100%"><br>
            <p class="lead">
            一个文件里面的内容到底是啥？用惯了Windows的人肯定是看后缀。但是后缀这个东西说改就改，不可靠。所以，最保险的还是把文件类型信息写到文件里面，通常来说，也就是写到文件开头的那几个字节。这是最方便，最快捷的用来辨别一个文件真实内容的方法。<br><br>
            
            常见的文件头标志如下：<br><br>
            
            JPEG (jpg)，文件头：<code>FFD8FF</code><br>
            PNG (png)，文件头：<code>89504E47</code><br>
            GIF (gif)，文件头：<code>47494638</code><br>
            HTML (html)，文件头：<code>68746D6C3E</code><br>
            ZIP Archive (zip)，文件头：<code>504B0304</code><br>
            RAR Archive (rar)，文件头：<code>52617221</code><br>
            Adobe Acrobat (pdf)，文件头：<code>255044462D312E</code><br>
            MS Word/Excel (xls.or.doc)，文件头：<code>D0CF11E0</code><br>

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