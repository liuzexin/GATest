<html>
<head>

    <style>

        body {margin:0;}

        #content {width:800px;margin:auto;}
        #head {height:1000px;background:#faf;}
        #left {float:left;width:120px;height:400px;background:#aaf;}
        #main {height:400px;background:#aaffaa;margin-left:120px;margin-right:200px;}
        #right {width:200px;height:400px;background:#aaf;float:right;}
        #foot {height:100px;background:#ffa;}

        #menu {width:800px;}
        #menu ul {list-style:none;margin:0;padding:0;}
        #menu ul li {
            background:#cc0;
            line-height:40px;
            height:40px;
            padding-left:10px;
            float:left;
            background:url('/image/bg.jpg');
            margin:0px;

        }

        li a {background:url('/imge/bg.jpg') no-repeat right 0;display:block;height:40px;padding-right:10px;}
        li a:hover {background:url('/image/bg1.jpg') no-repeat right 0;display:block;height:40px;padding-right:10px;}

        #menu ul li:hover{
            background:#cc0;
            line-height:40px;
            height:40px;
            padding-left:10px;
            float:left;
            background:url('/image/bg1.jpg');
            margin:0px;

        }


        a {text-decoration:none;color:#000;}
        a:hover{color:#f00;}


    </style>

</head>
<body>

<div id=content>
    <div id=head>

        <div id=menu>
            <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">个人简历</a></li>
                <li><a href="#">联系方式</a></li>
                <li><a href="#">个人简历</a></li>
                <li><a href="#">联系方式</a></li>
                <li><a href="#">个人简历</a></li>
                <li><a href="#">联系方式</a></li>
                <li><a href="#">个人简历</a></li>
                <li><a href="#">联系方式</a></li>
            </ul>
        </div>

        <ul>
            <li>首页</li>
            <li>个人简历</li>
            <li>联系方式</li>
        </ul>

    </div>
    <div id=left> 左侧内容  </div>
    <div id=right>右侧内容</div>
    <div id=main>这是中间内容</div>
    <div id=foot>页脚</div>
</div>

</body>
</html>