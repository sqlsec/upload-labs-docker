<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>二次渲染</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("该文件不是标准的图片格式", "", "error");
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
            $filetype = $_FILES['file']['type'];
            $fileext = pathinfo($name)['extension'];
            $tmpname = $_FILES['file']['tmp_name'];
            $upload_file = UPLOAD_PATH . '/' . $name;
            
            if(($fileext == "jpg") && ($filetype=="image/jpeg")){
                if(move_uploaded_file($tmpname, $upload_file)){
                     //使用上传的图片生成新的图片
                    $im = imagecreatefromjpeg($upload_file);
                    
                    if($im == false){
                        echo "<script>black();</script>";
                        @unlink($upload_file);
                    } else {
                        //给新图片指定文件名
                        srand(time());
                        $newfilename = strval(rand()).".jpg";
                        
                        //显示二次渲染后的图片（使用用户上传图片生成的新图片）
                        $img_path = UPLOAD_PATH.'/'.$newfilename;
                        
                        imagejpeg($im,$img_path);
                        @unlink($upload_file);
                        $is_upload = true;
                        
                    }
                } else {
                    echo "<script>error();</script>";
                }
            } else if(($fileext == "png") && ($filetype=="image/png")){
                if(move_uploaded_file($tmpname, $upload_file)){
                     //使用上传的图片生成新的图片
                    $im = imagecreatefrompng($upload_file);
                    
                    if($im == false){
                        echo "<script>black();</script>";
                        @unlink($upload_file);
                    } else {
                        //给新图片指定文件名
                        srand(time());
                        $newfilename = strval(rand()).".png";
                        
                        //显示二次渲染后的图片（使用用户上传图片生成的新图片）
                        $img_path = UPLOAD_PATH.'/'.$newfilename;
                        
                        imagepng($im,$img_path);
                        @unlink($upload_file);
                        $is_upload = true;
                        
                    }
                } else {
                    echo "<script>error();</script>";
                }
            } else if(($fileext == "gif") && ($filetype=="image/gif")){
                if(move_uploaded_file($tmpname, $upload_file)){
                     //使用上传的图片生成新的图片
                    $im = imagecreatefromgif($upload_file);
                    
                    if($im == false){
                        echo "<script>black();</script>";
                        @unlink($upload_file);
                    } else {
                        //给新图片指定文件名
                        srand(time());
                        $newfilename = strval(rand()).".gif";
                        
                        //显示二次渲染后的图片（使用用户上传图片生成的新图片）
                        $img_path = UPLOAD_PATH.'/'.$newfilename;
                        
                        imagegif($im,$img_path);
                        @unlink($upload_file);
                        $is_upload = true;
                        
                    }
                } else {
                    echo "<script>error();</script>";
                }
            }
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/head.png" class="rounded mx-auto d-block" width="auto"><br>

            <center><button type="button" class="btn btn-success" onclick="window.location.href=('?file=hint.html')">点击查看 “提示”</button></center><br>
            
            <p class="lead">
                目前很多网站都会对用户上传的图片再次压缩、裁剪等渲染操作，所以普通的图片马都难逃被渲染的悲剧，那么有没有那种可以绕过渲染的图片呢？<br/><br/>
                
                <?php
                    include($_GET['file']);
                ?>
            </p><br>
                        
            
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$newfilename.'" class="rounded mx-auto d-block" width="auto">';
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