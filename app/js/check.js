function trim(str)
{ 
	return str.replace(/^\ +|\ +$/ig,"");
}

function checkusername()
{
	if(trim(document.form.username.value)=="")
	{
	   alert("�������û�����");
	   document.form.username.focus();
	   return false;
	}
	if(trim(document.form.username.value).length<=2)
	{
		alert("�����û���̫���ˣ�");
		document.form.username.focus();
		return false;
	}
	if(document.form.username.value.match("^\\w+$")==null)   
	{   
		alert("�û�������ֻ����Ӣ�ġ����ֻ��»��ߣ�") 
		document.form.username.value="";
		document.form.username.focus();
		return false;
	}
	var url = 'checkusername.php?username=' + document.form.username.value;
	window.open(url, 'hidden_frame', 'height=0, width=0, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	return true;
}

function checkemployer()
{
	if(trim(document.form.username.value)=="")
	{
	   alert("�������û�����");
	   document.form.username.focus();
	   return false;
	}
	if(trim(document.form.username.value).length<=2)
	{
		alert("�����û���̫���ˣ�");
		document.form.username.focus();
		return false;
	}
	if(document.form.username.value.match("^\\w+$")==null)
	{   
		alert("�û�������ֻ����Ӣ�ġ����ֻ��»��ߣ�");
		document.form.username.value="";
		document.form.username.focus();
		return false;
	}

	if (document.form.password1.value=="")
	{
		alert("���������룡");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value.length<6)
	{
		alert("��������̫�̣��а�ȫ������");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value!=document.form.password2.value )
	{
	   alert("��֤���벻һ�£�");
	   document.form.password2.focus();
	   return false;
	}

	if(trim(document.form.question.value)=="")
	{
		alert("���������⣡");
		document.form.question.focus();
		return false;
	}

	if(trim(document.form.answer.value)=="")
	{
		alert("������𰸣�");
		document.form.answer.focus();
		return false;
	}

	if(trim(document.form.name.value)=="")
	{
		alert("��������ʵ������");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("���������������ģ�лл��");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("������̶��绰���ֻ����룡");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("��������ϸ��ϵ��ַ��");
		document.form.address.focus();
		return false;
	}
	if (document.form.service.options.value=="")
	{
		alert("��ѡ��������ͣ�");
		document.form.service.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("������н��Ҫ��");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.worktime.value)=="")
	{
		alert("�����빤�����ޣ�");
		document.form.worktime.focus();
		return false;
	}
}

function editemployer()
{
	if(trim(document.form.name.value)=="")
	{
		alert("��������ʵ������");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match("/[^\u4e00-\u9fa5]/gi"))   
	{   
		alert("���������������ģ�лл��");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("������̶��绰���ֻ����룡");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("��������ϸ��ϵ��ַ��");
		document.form.address.focus();
		return false;
	}
}

function editrequirement()
{
	if (document.form.service.options.value=="")
	{
		alert("��ѡ��������ͣ�");
		document.form.service.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("������н��Ҫ��");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.worktime.value)=="")
	{
		alert("�����빤�����ޣ�");
		document.form.worktime.focus();
		return false;
	}
}

function checkemployee()
{
	if(trim(document.form.username.value)=="")
	{
	   alert("�������û�����");
	   document.form.username.focus();
	   return false;
	}
	if(trim(document.form.username.value).length<=2)
	{
		alert("�����û���̫���ˣ�");
		document.form.username.focus();
		return false;
	}
	if(document.form.username.value.match("^\\w+$")==null)
	{   
		alert("�û�������ֻ����Ӣ�ġ����ֻ��»��ߣ�");
		document.form.username.value="";
		document.form.username.focus();
		return false;
	}

	if (document.form.password1.value=="")
	{
		alert("���������룡");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value.length<6)
	{
		alert("��������̫�̣��а�ȫ������");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value!=document.form.password2.value )
	{
	   alert("��֤���벻һ�£�");
	   document.form.password2.focus();
	   return false;
	}

	if(trim(document.form.question.value)=="")
	{
		alert("���������⣡");
		document.form.question.focus();
		return false;
	}

	if(trim(document.form.answer.value)=="")
	{
		alert("������𰸣�");
		document.form.answer.focus();
		return false;
	}

	if(trim(document.form.name.value)=="")
	{
		alert("��������ʵ������");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("���������������ģ�лл��");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.birthyear.value)=="")
	{
		alert("�����������ݣ�");
		document.form.birthyear.focus();
		return false;
	}
	if(trim(document.form.identifyid.value)=="")
	{
		alert("���������֤���룡");
		document.form.identifyid.focus();
		return false;
	}
	if(trim(document.form.identifyid.value).length!=18 && trim(document.form.identifyid.value).length!=17)
	{
		alert("��������ȷ�����֤���룡");
		document.form.identifyid.focus();
		return false;
	}
	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("������̶��绰���ֻ����룡");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("��������ϸ��ϵ��ַ��");
		document.form.address.focus();
		return false;
	}
	if (document.form.service_area.options.value=="")
	{
		alert("��ѡ���������");
		document.form.service_area.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("������н��Ҫ��");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.experience.value)=="")
	{
		alert("������������飡");
		document.form.experience.focus();
		return false;
	}
	if (document.form.service.options.value=="")
	{
		alert("��ѡ��������ͣ�");
		document.form.service.focus();
		return false;
	}
}

function editemployee()
{
	if(trim(document.form.name.value)=="")
	{
		alert("��������ʵ������");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("���������������ģ�лл��");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.birthyear.value)=="")
	{
		alert("�����������ݣ�");
		document.form.birthyear.focus();
		return false;
	}
	if(trim(document.form.identifyid.value)=="")
	{
		alert("���������֤���룡");
		document.form.identifyid.focus();
		return false;
	}
	if(trim(document.form.identifyid.value).length!=18 && trim(document.form.identifyid.value).length!=17)
	{
		alert("��������ȷ�����֤���룡");
		document.form.identifyid.focus();
		return false;
	}
	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("������̶��绰���ֻ����룡");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("��������ϸ��ϵ��ַ��");
		document.form.address.focus();
		return false;
	}
	if (document.form.service_area.options.value=="")
	{
		alert("��ѡ���������");
		document.form.service_area.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("������н��Ҫ��");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.experience.value)=="")
	{
		alert("������������飡");
		document.form.experience.focus();
		return false;
	}
	if (document.form.service.options.value=="")
	{
		alert("��ѡ��������ͣ�");
		document.form.service.focus();
		return false;
	}
}

function checkreserve()
{
	if(trim(document.form.sname.value)=="")
	{
		alert("������������");
		document.form.sname.focus();
		return false;
	}
		   
	if(document.form.sname.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("���������������ģ�лл��");
		document.form.sname.value="";
		document.form.sname.focus();
		return false;   
	}
	if (document.form.service.options.value=="")
	{
		alert("��ѡ�������Ŀ��");
		document.form.service.focus();
		return false;
	}
	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("������̶��绰���ֻ����룡");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("��������ϸ��ϵ��ַ��");
		document.form.address.focus();
		return false;
	}
}

function checkfriend()
{
	if(trim(document.form.title.value)=="")
	{
		alert("��������վ���ƣ�");
		document.form.title.focus();
		return false;
	}

	if(trim(document.form.link.value)=="")
	{
		alert("��������վ��ַ��");
		document.form.link.focus();
		return false;
	}
	if(document.form.link.value.match("^[a-zA-z]+://(\\w+(-\\w+)*)(\\.(\\w+(-\\w+)*))*(\\?\\S*)?$"))   
	{   
	}
	else
	{
		alert("��������ȷ����վ��ַ��лл��");
		document.form.link.focus();
		return false;   
	}

	if(trim(document.form.name.value)=="")
	{
		alert("������������");
		document.form.name.focus();
		return false;
	}
	if(document.form.name.value.match("/[^\u4e00-\u9fa5]/gi"))   
	{   
		alert("���������������ģ�лл��");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.email.value)=="")
	{
		alert("����������ʼ���");
		document.form.email.focus();
		return false;
	}
	if(document.form.email.value.match("^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$"))   
	{   
	}
	else
	{
		alert("��������ȷ�ĵ����ʼ���лл��");
		document.form.email.focus();
		return false;   
	}
}

function checkregister()
{
	if(trim(document.form.name.value)=="")
	{
		alert("������������");
		document.form.name.focus();
		return false;
	}
	if(document.form.name.value.match("/[^\u4e00-\u9fa5]/gi"))   
	{   
		alert("���������������ģ�лл��");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.telephone.value)=="")
	{
		alert("������绰���룡");
		document.form.telephone.focus();
		return false;
	}
	if(trim(document.form.note.value)=="")
	{
		alert("��������ϸ˵����");
		document.form.note.focus();
		return false;
	}
}

function checkreg1()
{
	if (document.form1.type[0].checked == false && document.form1.type[1].checked == false)
	{
		alert("��ѡ����ע���Ա����ע�������");
		return false;
	}
}

function checkreg2()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("��֤����д���ԣ���������壬��ˢ�£�");
		return false;
	}
	if (document.form1.type[0].checked == false && document.form1.type[1].checked == false)
	{
		alert("��ѡ����ע���Ա����ע�������");
		return false;
	}
}

function checkcomment1()
{
	if (trim(document.form1.content.value) == "")
	{
		alert("����д���ۣ�");
		return false;
	}
}

function checkcomment2()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("��֤����д���ԣ���������壬��ˢ�£�");
		return false;
	}
	if (trim(document.form1.content.value) == "")
	{
		alert("����д���ۣ�");
		return false;
	}
}

function checknote1()
{
	if (trim(document.form1.name.value) == "")
	{
		alert("����д������");
		return false;
	}
	if (trim(document.form1.content.value) == "")
	{
		alert("����д���ԣ�");
		return false;
	}
}

function checknote2()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("��֤����д���ԣ���������壬��ˢ�£�");
		return false;
	}
	if (trim(document.form1.name.value) == "")
	{
		alert("����д������");
		return false;
	}
	if (trim(document.form1.content.value) == "")
	{
		alert("����д���ԣ�");
		return false;
	}
}

function checkverity()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("��֤����д���ԣ���������壬��ˢ�£�");
		return false;
	}
}

function ifDel(delurl)
{
	var truthBeTold = window.confirm("��ȷ��Ҫɾ����");
	if (truthBeTold)
	{
			location=delurl;
	}
	else
	{
		return;
	}
}
