var http_request = false;
function createXMLHttpRequest() {
http_request = false;
if(window.XMLHttpRequest) { //Mozilla 浏览器
http_request = new XMLHttpRequest();
if (http_request.overrideMimeType) {//设置MiME 类别
http_request.overrideMimeType("text/xml");
}
}
else if (window.ActiveXObject) { // IE 浏览器
try {
http_request = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
http_request = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}
if (!http_request) { // 异常，创建对象实例失败
window.alert("不能创建XMLHttpRequest 对象实例.");
return;
}
}

function send_http(purl){
createXMLHttpRequest();
if (!http_request) { // 异常，创建对象实例失败
window.alert("不能创建XMLHttpRequest 对象实例.");
return false;
}
http_request.onreadystatechange = processhttp;
// 确定发送请求的方式和URL 以及是否同步执行下段代码
http_request.open("GET", purl, true);
http_request.send(null);
}

function processhttp() {
if (http_request.readyState == 4) { // 判断对象状态
if (http_request.status == 200) { // 信息已经成功返回，开始处理信息
//alert(http_request.responseText);
eval(http_request.responseText);
} else { //页面不正常
alert("您所请求的页面有异常。");
}
}
}

function send(){
   send_http("check.php?check="+document.getElementByid("check").value);
}
