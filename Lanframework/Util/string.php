<?php
class String{
function sub_str($str, $length = 0, $append = true)
{
    $str = trim($str);
    $strlength = strlen($str);

    if ($length == 0 || $length >= $strlength)
    {
        return $str;  //截取长度等于0或大于等于本字符串的长度，返回字符串本身
    }
    elseif ($length < 0)  //如果截取长度为负数
    {
        $length = $strlength + $length;//那么截取长度就等于字符串长度减去截取长度
        if ($length < 0)
        {
            $length = $strlength;//如果截取长度的绝对值大于字符串本身长度，则截取长度取字符串本身的长度
        }
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, 0, $length, "utf-8");
    }
    elseif (function_exists('iconv_substr'))
    {
        $newstr = iconv_substr($str, 0, $length, "utf-8");
    }
    else
    {
        //$newstr = trim_right(substr($str, 0, $length));
        $newstr = substr($str, 0, $length);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }

    return $newstr;
}
//验证是否为空
function check_blank(obj, obj_name){
if(obj.value != ''){
return true;
}else{
alert(obj_name + "所填不能为空！");
obj.value = "";
return false;
}
}

//过滤输入字符的长度
function check_str_len(name,obj,maxLength){
obj.value=obj.value.replace(/(^\s*)|(\s*$)/g, "");
var newvalue = obj.value.replace(/[^\x00-\xff]/g, "**");
var length11 = newvalue.length;
if(length11>maxLength){
alert(name+"的长度不能超过"+maxLength+"个字符！");
obj.value="";
obj.focus();
}
}

//验证只能为数字
function checkNumber(obj){
var reg = /^[0-9]+$/;
if(obj.value!=""&&!reg.test(obj.value)){
alert('只能输入数字！');
obj.value = "";
obj.focus();
return false;
}
}

//验证数字大小的范围

function check_num_value(obj_name,obj,minvalue,maxvalue){
var reg = /^[0-9]+$/;
if(obj.value!=""&&!reg.test(obj.value)){
alert(obj_name+'只能输入数字！');
obj.value = "";
obj.focus();
return false;
}else if(minvalue>obj.value||obj.value>maxvalue){
alert(obj_name+"的范围是"+minvalue+"-"+maxvalue+"!");
obj.value="";
obj.focus();
return false;
}

}

//验证只能是字母和数字
function checkZmOrNum(zmnum){
var zmnumReg=/^[0-9a-zA-Z]*$/;
if(zmnum.value!=""&&!zmnumReg.test(zmnum.value)){
alert("只能输入是字母或者数字,请重新输入");
zmnum.value="";
zmnum.focus();
return false;
}
}

//验证双精度数字
function check_double(obj,obj_name){
var reg = /^[0-9]+(\.[0-9]+)?$/;
if(obj.value!=""&&!reg.test(obj.value)){
alert(obj_name+'所填必须为有效的双精度数字');
obj.value = "";
obj.focus();
return false;
}
}


//复选框全选
function checkboxs_all(obj,cName){
var checkboxs = document.getElementsByName(cName);
for(var i=0;i<checkboxs.length;i++){
checkboxs[i].checked = obj.checked;
}
}


//验证邮政编码
function check_youbian(obj){
var reg=/^\d{6}$/;
if(obj.value!=""&&!reg.test(obj.value)){
alert('邮政编码格式输入错误！');
obj.value = "";
obj.focus();
return false;
}
}

//验证邮箱格式
function check_email(obj){
var reg = /^[a-zA-Z0-9_-]+(\.([a-zA-Z0-9_-])+)*@[a-zA-Z0-9_-]+[.][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*$/;
if(obj.value!=""&&!reg.test(obj.value)){
obj.select();
alert('电子邮箱格式输入错误！');
obj.value = "";
obj.focus();
return false;
}
}

/*验证固定电话号码
0\d{2,3} 代表区号
[0\+]\d{2,3} 代表国际区号
\d{7,8} 代表7－8位数字(表示电话号码)
正确格式：区号-电话号码-分机号(全写|只写电话号码)
*/

function check_phone(obj){
var reg=/^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
if(obj.value!=""&&!reg.test(obj.value)){
alert('电话号码格式输入错误！');
obj.value = "";
obj.focus();
return false;
}
}

//验证手机号码(检验13,15,18开头的手机号！)
function isMobileNO(mobileNum){
    var pattern = new RegExp("^((13[0-9])|(14[57])|(17[0-9])|(15[^4,\\D])|(18[0-9]))\\d{8}$");
    if(!pattern.test(mobileNum)){
      return false;
    }
    return true;
  }
//验证是否为中文
function isChinese(obj,obj_name){
var reg=/^[\u0391-\uFFE5]+$/;
if(obj.value!=""&&!reg.test(obj.value)){
alert(obj_name+'必须输入中文！');
obj.value = "";
obj.focus();
return false;
}
}

//判断是否是IE浏览器

function checkIsIE(){
if(-[1,]){
alert("这不是IE浏览器！");
}else{
alert("这是IE浏览器！");
}
}

//验证是否为正确网址
function check_IsUrl(obj){


}

//检验时间大小(与当前时间比较)
function checkDate(obj,obj_name){
var obj_value=obj.value.replace(/-/g,"/");//替换字符，变成标准格式(检验格式为：'2009-12-10')
// var obj_value=obj.value.replace("-","/");//替换字符，变成标准格式(检验格式为：'2010-12-10 11:12')
var date1=new Date(Date.parse(obj_value));
var date2=new Date();//取今天的日期
if(date1>date2){
alert(obj_name+"不能大于当前时间！");
return false;
}
}
}
 ?>
