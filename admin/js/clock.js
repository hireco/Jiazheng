setInterval(function(){showtime()},1000)       //ÿ1000����(��1��) ִ��һ�α��δ��� 
function showtime () { 
var now = new Date();
var year = now.getYear();
var month = now.getMonth() + 1;
var date = now.getDate();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds();

var timevalue = year;
timevalue += ((month < 10) ? "��0" : "��") + month;
timevalue += ((date < 10) ? "��0" : "��") + date;
timevalue += ((hours < 10) ? "��0" : "��") + hours;
timevalue += ((minutes < 10) ? ":0" : ":") + minutes;
timevalue += ((seconds < 10) ? ":0" : ":") + seconds;
clock.innerText = timevalue;
} 
