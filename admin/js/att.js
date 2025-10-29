function editatt(id,order,intro){
x = document.getElementById('editDIV');
x.style.display = "";
editform.attid.value = id;
editform.order.value = order;
editform.intro.value = intro;
framechange();
}
function editclose(){
x = document.getElementById('editDIV');
x.style.display = "none";
framechange();
}
function framechange(){
parent.document.all("attlist").style.width=document.body.scrollWidth; parent.document.all("attlist").style.height=document.body.scrollHeight;
}