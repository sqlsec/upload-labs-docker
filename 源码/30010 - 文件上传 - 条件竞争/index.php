<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>条件竞争</title>
    <script>
        function error(){
            swal("上传失败", "", "error");
        }
        
        function black(){
            swal("只允许上传.jpg|.png|.gif类型文件", "", "error");
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
            $upload_file = UPLOAD_PATH . '/' . $name;
            $whitelist = array('jpg','png','gif','jpeg');
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . $name)) {
                if(in_array($ext,$whitelist)){
                    $rename_file = rand(10, 99).date("YmdHis").".".$ext;
                    $img_path = UPLOAD_PATH . '/'. $rename_file;
                    rename($upload_file, $img_path);
                    $is_upload = true;
                }else{
                    echo "<script>black();</script>";
                    unlink($upload_file);
                }
            } 
        }
    ?>

    <div class="container">
        <div class="jumbotron">
            <img src="./imgs/head.png" class="rounded mx-auto d-block" width="100%"><br>
            <p class="lead">
                
            条件竞争是指一个系统的运行结果依赖于不受控制的事件的先后顺序。当这些不受控制的事件并没有按照开发者想要的方式运行时，就可能会出现 bug。尤其在当前我们的系统中大量对资源进行共享，如果处理不当的话，就会产生条件竞争漏洞。<br><br>
                
            攻击者上传了一个用来生成恶意 shell 的文件，在上传完成和安全检查完成并删除它的间隙，攻击者通过不断地发起访问请求的方法访问了该文件，该文件就会被执行，并且在服务器上生成一个恶意 shell 的文件。至此，该文件的任务就已全部完成，至于后面发现它是一个不安全的文件并把它删除的问题都已经不重要了，因为攻击者已经成功的在服务器中植入了一个 shell 文件，后续的一切就都不是问题了。<br><br>
            
            不过竞争的马因为生存周期短的原因，所以和普通的 Webshell 不太一样，他的使命是在有限的生命中等待一个有缘人的光顾，然后快速生成一个小 Webshell，落红不是无情物，化作春泥更护花（泪目）。这类的 Webshell 内容大体上如下：
            <pre>&lt;?php fputs(fopen(&#39;xiao.php&#39;,&#39;w&#39;),&#39;&lt;?php eval($_REQUEST[1]);?&gt;&#39;);?&gt;</pre>
            </p><br>
            <div>
                <?php
                    if($is_upload){
                        echo '<img src="./upload/'.$rename_file.'" class="rounded mx-auto d-block" width="auto">';
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