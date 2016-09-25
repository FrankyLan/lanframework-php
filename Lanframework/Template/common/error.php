<?php include_once(ROOT.'/Application/backend/common/header.php');
?>
<style>
a:hover{
  color:#05B3D5;
}
a{
  text-decoration:underline;
}
</style>
<div class="main_form">
<div class="jump_content">
<?="错误信息:".$error['info']."<br />错误代码:".$error['code']."<br />错误行:".$error['line']."<br />错误文件:".$error['file']?><br />
<a href='/'>点此返回主页</a>
</div>
</div>

<?php include_once(ROOT.'/Application/backend/common/footer.php');
?>
