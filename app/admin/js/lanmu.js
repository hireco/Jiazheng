function update_f( CatID1, subTypeForm ){
subTypeForm.length=0;
switch(CatID1){
case "-1":
subTypeForm.options[0]=new Option("--------","-1");
subTypeForm.options[0].selected=true;break;
case "0"://CN
subTypeForm.options[0]=new Option("У԰����","1");
subTypeForm.options[1]=new Option("������","2");
subTypeForm.options[2]=new Option("�����","3");
subTypeForm.options[3]=new Option("����֪ͨ","4");
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
case "1"://�㶫
subTypeForm.options[0]=new Option("ÿ������","0");
subTypeForm.options[1]=new Option("У԰׷��","1");
subTypeForm.options[0].selected=true;
break;
case "2"://����
subTypeForm.options[0]=new Option("����ר��","0");
subTypeForm.options[1]=new Option("��������","1");
subTypeForm.options[2]=new Option("��ѧ�ش�","2");
subTypeForm.options[0].selected=true;
break;
case "3"://����
subTypeForm.options[0]=new Option("��ҵ����","0");
subTypeForm.options[1]=new Option("˾�Ǵ���","0");
subTypeForm.options[2]=new Option("��ѧ���а�","0");
subTypeForm.options[3]=new Option("����ľ��","0");
subTypeForm.options[4]=new Option("�����Ļ���","0");
subTypeForm.options[0].selected=true;
break;
case "4"://����
subTypeForm.options[0]=new Option("�Ԥ��","0");
subTypeForm.options[0].selected=true;
break;
}
break;}
return -1;
}