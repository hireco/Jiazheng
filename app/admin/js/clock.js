setInterval(function(){showtime()},1000)       //每1000毫秒(即1秒) 执行一次本段代码 
function showtime () { 
var now = new Date();
var year = now.getYear();
var month = now.getMonth() + 1;
var date = now.getDate();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds();

var timevalue = year;
timevalue += ((month < 10) ? "年0" : "年") + month;
timevalue += ((date < 10) ? "月0" : "月") + date;
timevalue += ((hours < 10) ? "日0" : "日") + hours;
timevalue += ((minutes < 10) ? ":0" : ":") + minutes;
timevalue += ((seconds < 10) ? ":0" : ":") + seconds;
clock.innerText = timevalue;
} 
