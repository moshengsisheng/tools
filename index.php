<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>我的导航</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" charset="gbk">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery.tipsy/1.0.3/jquery.tipsy.css" charset="gbk">
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/remarkable/1.7.1/remarkable.min.js"></script>
    <script src="//cdn.bootcss.com/keymaster/1.6.1/keymaster.min.js"></script>
    <script src="//cdn.bootcss.com/jquery.tipsy/1.0.3/jquery.tipsy.min.js"></script>
    <style>
        .list-group-item{padding:0; float:left;margin:6px;}
        .list-group-item-hidden{border:1px solid #fff;}
        .list-group-item p{margin:0; width:128px;height:40px;line-height:40px;text-align:center;}
        .list-group-item p a{width:100%;height:100%;display:block;}
        a[tabindex]{color:#f00; font-weight:800;}
    </style>
    <base target="_blank"></base>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>我的导航<small></small></h1>
        </div>
        <div id="myGongju_body"></div>
    </div>
    <script>
        key('ctrl+shift+m', function(){ $('#myModal').modal('show'); return false });
        key('ctrl+shift+k', function(){ $('#myGongju').modal('show'); return false });
        var md = new Remarkable();
        var str = [];
        <?php 
            $file = @file("link.md");
            $html = array();
            $index = -1;
            foreach($file as $k=>$v){
                $class = "";
                if($v{0}=="\r"){continue;}
                if($v{0}=="*"){$class="list-group-item-success";$index++;}
                if($v){
                    $html[$index][] = 'str.push("<li class=\"list-group-item '.$class.'\" style=\"float:left;margin:6px;\">"+md.render("'.trim($v).'")+"</li>");';
                }
            }
            //一行几个
            $line_num = 8;
            //空隔
            $none = 'str.push("<li class=\"list-group-item list-group-item-hidden\" style=\"float:left;margin:6px;\"><p></p></li>");';
            foreach($html as $k=>&$v){
                //先取出第一行，并填写相应的数量的空格。
                echo implode("",array_pad(array_splice($v,0,$line_num),$line_num,$none));
                //按相应的数量-1切分。
                $v = array_chunk($v,$line_num-1);
                //循环，头部插入一个空格，填充相应的空格。
                foreach($v as $tk=>&$tv){
                    array_unshift($tv,$none);
                    $tv = array_pad($tv,$line_num,$none);
                    $tv = implode("",$tv);
                }
                echo implode("",$v);
            }
        ?>
        $("#myGongju_body").html('<ul  class="list-group">'+str.join("")+'</ul><div style="clear:both;"></div>');
        $("#myGongju_body").find("a[title]").addClass("show_tipsy");
        $(".show_tipsy").tipsy({gravity: 's'});
    </script>
</body>
</html>