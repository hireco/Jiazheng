function update_f( CatID1, subTypeForm ){
subTypeForm.length=0;
switch(CatID1){
case "-1":
subTypeForm.options[0]=new Option("--------","-1");
subTypeForm.options[0].selected=true;break;
case "0"://CN
subTypeForm.options[0]=new Option("校园新闻","1");
subTypeForm.options[1]=new Option("待命名","2");
subTypeForm.options[2]=new Option("活动新闻","3");
subTypeForm.options[3]=new Option("事务通知","4");
subTypeForm.options[0].selected=true;
break;
}
return -1;
}
function update_s( CatID1, CatID2, subTypeForm ){
subTypeForm.length=0;
switch(CatID1){
case "-1":
subTypeForm.options[0]=new Option("--------","-1");
subTypeForm.options[0].selected=true;break;
case "0"://CN
switch ( CatID2 ){
case "1"://广东
subTypeForm.options[0]=new Option("每日新闻","0");
subTypeForm.options[1]=new Option("校园追击","1");
subTypeForm.options[0].selected=true;
break;
case "2"://广西
subTypeForm.options[0]=new Option("人物专访","0");
subTypeForm.options[1]=new Option("新闻评论","1");
subTypeForm.options[2]=new Option("文学地带","2");
subTypeForm.options[0].selected=true;
break;
case "3"://北京
subTypeForm.options[0]=new Option("创业大赛","0");
subTypeForm.options[1]=new Option("司仪大赛","0");
subTypeForm.options[2]=new Option("文学排行榜","0");
subTypeForm.options[3]=new Option("世纪木绵","0");
subTypeForm.options[4]=new Option("宿舍文化节","0");
subTypeForm.options[0].selected=true;
break;
case "4"://海南
subTypeForm.options[0]=new Option("活动预告","0");
subTypeForm.options[0].selected=true;
break;
}
break;}
return -1;
}