<html>
<head>

<style>

body {margin:0;}


#main {height:500px;width:600px;background:#00a;margin:auto;}
#left {height:500px;width:200px;background:#aaa;float:left;}
#right {height:500px;width:200px;background:#a00;float:right;}
#head {height:200px;width:600px;background:#0a0;margin:auto;}
#center {height:500px;width:300px;background:#aa0;margin-left: auto;margin-right: auto}
#menu{width:600px;height: 100px}
#menu ul {list-style:none;margin:0;padding:0;}
#menu ul li {
    background:#cc0;
    line-height:40px;
    height:40px;
    padding-left:10px;
    float:left;
    background:url('/image/bg.jpg');
    background-size: cover;
    margin-left:90px;
    width: 90px;

}
#menu ul li:hover{
    background:#cc0;
    background:url('/image/bg1.jpg');
}
#foot {height:500px;background:#ffa;}
</style>

</head>
<body bgcolor="pink">
 


<div id=head><h1>亲，你好:</h1>
     <h1>让我们一起来欣赏这两首诗吧!</h1>
    <div id=menu>
        <ul>
            <li><a href="#">唐诗</a></li>
            <li><a href="#">宋词</a></li>
            <li><a href="#">元曲</a></li>
        </ul>
    </div>
</div>
<div id=main>
   



<div id=right>
      <h1>青玉案</h1>
      <p><a href="诗歌.htm#zhushuzhen">朱淑真</a>
<img src="tupian.jpg" width="150px">
<a href="http://www.baibu.com">江城子</a>

年年社日停针线。

怎忍见、双飞燕。

今日江城春已半。

一身犹在，乱山深处，

寂寞溪桥畔。　

春衫著破谁针线。

点点行行泪痕满。

落日解鞍芳草岸。

花无人戴，酒无人劝，

醉也无人管。
   </div>
  











<div id=left>
<form>
   用户名：<input type="text"value="何立同"name="username"><p>
   密码：<input type="password"name="password"><p>
   个人简历：<textarea row="6"></textarea><p>
   性别：<input type="radio"name="sex"checked>男<input type="radio"name="sex"checked>女<p>
   爱好：<input type="checkbox"name="hobby"checked>运动<input type="checkbox"name="hobby"checked>阅读<input type="checkbox"name="hobby"checked>唱歌
   籍贯：<select name="address">
           <option value="天津">天津
           <option value="北京">北京
           <option value="上海">上海
           <option value="深圳">深圳
         </select><p>
  <input type="submit"value="确定"><input type="reset"value="重置"><input type="reset"value="取消">
  </form>
 
      <p>
   </div>



<div id=center>

<h1 style="margin-top: 0">江城子</h1>

斜风细雨作春寒，

对尊前，忆前欢。<p>

曾把梨花，

寂寞泪澜干。<p>

芳草断烟南浦路，

和别泪，看青山。<p>

昨宵结得梦夤缘，

水去间，悄无言。<p>

争奈醒来，

愁恨又依然。<p>

展转衾[衤周]空懊恼，

天易见，见伊难。
</div>



<div id=foot> 
<%  =server.HTMLEncode("<form action='http://www.baidu.com/s'  method='get'>") %>

<%  =server.MapPath("shuju.mdb")  %>

<% set conn = Server.CreateObject("ADODB.Connection") 

conn.open "Provider = Microsoft.Jet.OLEDB.4.0;Data Source ="& server.MapPath("shuju.mdb")


set rs = conn.execute("yonghu")


response.write rs("username")

%>


<table border="1" width="600px" align="center">
  <tr>
    <td width="200px" align="center">姓名</td>
    <td width="200px" align="center">性别</td>
    <td align="center">年龄</td>
 </tr>  
 

<%  do while not rs.eof %>


<tr>
    <td width="200px" align="center"><%=rs("username")%></td>
    <td width="200px" align="center"><%=rs("xingbie")%></td>
    <td align="center"><%=rs("nianling")%></td>
 </tr>
  

<% 

rs.MoveNext
loop %>

</table>
   </div>
</div>


</body>
</html>