var http_request = false;
function createXMLHttpRequest() {
http_request = false;
if(window.XMLHttpRequest) { //Mozilla �����
http_request = new XMLHttpRequest();
if (http_request.overrideMimeType) {//����MiME ���
http_request.overrideMimeType("text/xml");
}
}
else if (window.ActiveXObject) { // IE �����
try {
http_request = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
http_request = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}
if (!http_request) { // �쳣����������ʵ��ʧ��
window.alert("���ܴ���XMLHttpRequest ����ʵ��.");
return;
}
}

function send_http(purl){
createXMLHttpRequest();
if (!http_request) { // �쳣����������ʵ��ʧ��
window.alert("���ܴ���XMLHttpRequest ����ʵ��.");
return false;
}
http_request.onreadystatechange = processhttp;
// ȷ����������ķ�ʽ��URL �Լ��Ƿ�ͬ��ִ���¶δ���
http_request.open("GET", purl, true);
http_request.send(null);
}

function processhttp() {
if (http_request.readyState == 4) { // �ж϶���״̬
if (http_request.status == 200) { // ��Ϣ�Ѿ��ɹ����أ���ʼ������Ϣ
//alert(http_request.responseText);
eval(http_request.responseText);
} else { //ҳ�治����
alert("���������ҳ�����쳣��");
}
}
}

function send(){
   send_http("check.php?check="+document.getElementByid("check").value);
}
