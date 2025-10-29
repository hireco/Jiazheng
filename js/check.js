function trim(str)
{ 
	return str.replace(/^\ +|\ +$/ig,"");
}

function checkusername()
{
	if(trim(document.form.username.value)=="")
	{
	   alert("请输入用户名！");
	   document.form.username.focus();
	   return false;
	}
	if(trim(document.form.username.value).length<=2)
	{
		alert("您的用户名太短了！");
		document.form.username.focus();
		return false;
	}
	if(document.form.username.value.match("^\\w+$")==null)   
	{   
		alert("用户名必须只包含英文、数字或下划线！") 
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
	   alert("请输入用户名！");
	   document.form.username.focus();
	   return false;
	}
	if(trim(document.form.username.value).length<=2)
	{
		alert("您的用户名太短了！");
		document.form.username.focus();
		return false;
	}
	if(document.form.username.value.match("^\\w+$")==null)
	{   
		alert("用户名必须只包含英文、数字或下划线！");
		document.form.username.value="";
		document.form.username.focus();
		return false;
	}

	if (document.form.password1.value=="")
	{
		alert("请输入密码！");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value.length<6)
	{
		alert("您的密码太短，有安全隐患！");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value!=document.form.password2.value )
	{
	   alert("验证密码不一致！");
	   document.form.password2.focus();
	   return false;
	}

	if(trim(document.form.question.value)=="")
	{
		alert("请输入问题！");
		document.form.question.focus();
		return false;
	}

	if(trim(document.form.answer.value)=="")
	{
		alert("请输入答案！");
		document.form.answer.focus();
		return false;
	}

	if(trim(document.form.name.value)=="")
	{
		alert("请输入真实姓名！");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("请输入固定电话或手机号码！");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("请输入详细联系地址！");
		document.form.address.focus();
		return false;
	}
	if (document.form.service.options.value=="")
	{
		alert("请选择服务类型！");
		document.form.service.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("请输入薪酬要求！");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.worktime.value)=="")
	{
		alert("请输入工作期限！");
		document.form.worktime.focus();
		return false;
	}
}

function editemployer()
{
	if(trim(document.form.name.value)=="")
	{
		alert("请输入真实姓名！");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match("/[^\u4e00-\u9fa5]/gi"))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("请输入固定电话或手机号码！");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("请输入详细联系地址！");
		document.form.address.focus();
		return false;
	}
}

function editrequirement()
{
	if (document.form.service.options.value=="")
	{
		alert("请选择服务类型！");
		document.form.service.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("请输入薪酬要求！");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.worktime.value)=="")
	{
		alert("请输入工作期限！");
		document.form.worktime.focus();
		return false;
	}
}

function checkemployee()
{
	if(trim(document.form.username.value)=="")
	{
	   alert("请输入用户名！");
	   document.form.username.focus();
	   return false;
	}
	if(trim(document.form.username.value).length<=2)
	{
		alert("您的用户名太短了！");
		document.form.username.focus();
		return false;
	}
	if(document.form.username.value.match("^\\w+$")==null)
	{   
		alert("用户名必须只包含英文、数字或下划线！");
		document.form.username.value="";
		document.form.username.focus();
		return false;
	}

	if (document.form.password1.value=="")
	{
		alert("请输入密码！");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value.length<6)
	{
		alert("您的密码太短，有安全隐患！");
		document.form.password1.focus();
		return false;
	}
	if(document.form.password1.value!=document.form.password2.value )
	{
	   alert("验证密码不一致！");
	   document.form.password2.focus();
	   return false;
	}

	if(trim(document.form.question.value)=="")
	{
		alert("请输入问题！");
		document.form.question.focus();
		return false;
	}

	if(trim(document.form.answer.value)=="")
	{
		alert("请输入答案！");
		document.form.answer.focus();
		return false;
	}

	if(trim(document.form.name.value)=="")
	{
		alert("请输入真实姓名！");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.birthyear.value)=="")
	{
		alert("请输入出生年份！");
		document.form.birthyear.focus();
		return false;
	}
	if(trim(document.form.identifyid.value)=="")
	{
		alert("请输入身份证号码！");
		document.form.identifyid.focus();
		return false;
	}
	if(trim(document.form.identifyid.value).length!=18 && trim(document.form.identifyid.value).length!=17)
	{
		alert("请输入正确的身份证号码！");
		document.form.identifyid.focus();
		return false;
	}
	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("请输入固定电话或手机号码！");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("请输入详细联系地址！");
		document.form.address.focus();
		return false;
	}
	if (document.form.service_area.options.value=="")
	{
		alert("请选择服务区域！");
		document.form.service_area.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("请输入薪酬要求！");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.experience.value)=="")
	{
		alert("请输入家政经验！");
		document.form.experience.focus();
		return false;
	}
	if (document.form.service.options.value=="")
	{
		alert("请选择服务类型！");
		document.form.service.focus();
		return false;
	}
}

function editemployee()
{
	if(trim(document.form.name.value)=="")
	{
		alert("请输入真实姓名！");
		document.form.name.focus();
		return false;
	}
		   
	if(document.form.name.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.birthyear.value)=="")
	{
		alert("请输入出生年份！");
		document.form.birthyear.focus();
		return false;
	}
	if(trim(document.form.identifyid.value)=="")
	{
		alert("请输入身份证号码！");
		document.form.identifyid.focus();
		return false;
	}
	if(trim(document.form.identifyid.value).length!=18 && trim(document.form.identifyid.value).length!=17)
	{
		alert("请输入正确的身份证号码！");
		document.form.identifyid.focus();
		return false;
	}
	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("请输入固定电话或手机号码！");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("请输入详细联系地址！");
		document.form.address.focus();
		return false;
	}
	if (document.form.service_area.options.value=="")
	{
		alert("请选择服务区域！");
		document.form.service_area.focus();
		return false;
	}
	if (trim(document.form.salary.value)=="")
	{
		alert("请输入薪酬要求！");
		document.form.salary.focus();
		return false;
	}
	if (trim(document.form.experience.value)=="")
	{
		alert("请输入家政经验！");
		document.form.experience.focus();
		return false;
	}
	if (document.form.service.options.value=="")
	{
		alert("请选择服务类型！");
		document.form.service.focus();
		return false;
	}
}

function checkreserve()
{
	if(trim(document.form.sname.value)=="")
	{
		alert("请输入姓名！");
		document.form.sname.focus();
		return false;
	}
		   
	if(document.form.sname.value.match(/[^\u4e00-\u9fa5]/gi))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.sname.value="";
		document.form.sname.focus();
		return false;   
	}
	if (document.form.service.options.value=="")
	{
		alert("请选择服务项目！");
		document.form.service.focus();
		return false;
	}
	if (trim(document.form.telephone.value)=="" && trim(document.form.mobile.value)=="")
	{
		alert("请输入固定电话或手机号码！");
		document.form.telephone.focus();
		return false;
	}
	if (trim(document.form.address.value)=="")
	{
		alert("请输入详细联系地址！");
		document.form.address.focus();
		return false;
	}
}

function checkfriend()
{
	if(trim(document.form.title.value)=="")
	{
		alert("请输入网站名称！");
		document.form.title.focus();
		return false;
	}

	if(trim(document.form.link.value)=="")
	{
		alert("请输入网站地址！");
		document.form.link.focus();
		return false;
	}
	if(document.form.link.value.match("^[a-zA-z]+://(\\w+(-\\w+)*)(\\.(\\w+(-\\w+)*))*(\\?\\S*)?$"))   
	{   
	}
	else
	{
		alert("请输入正确的网站地址，谢谢！");
		document.form.link.focus();
		return false;   
	}

	if(trim(document.form.name.value)=="")
	{
		alert("请输入姓名！");
		document.form.name.focus();
		return false;
	}
	if(document.form.name.value.match("/[^\u4e00-\u9fa5]/gi"))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.email.value)=="")
	{
		alert("请输入电子邮件！");
		document.form.email.focus();
		return false;
	}
	if(document.form.email.value.match("^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$"))   
	{   
	}
	else
	{
		alert("请输入正确的电子邮件，谢谢！");
		document.form.email.focus();
		return false;   
	}
}

function checkregister()
{
	if(trim(document.form.name.value)=="")
	{
		alert("请输入姓名！");
		document.form.name.focus();
		return false;
	}
	if(document.form.name.value.match("/[^\u4e00-\u9fa5]/gi"))   
	{   
		alert("姓名必须输入中文，谢谢！");
		document.form.name.value="";
		document.form.name.focus();
		return false;   
	}

	if(trim(document.form.telephone.value)=="")
	{
		alert("请输入电话号码！");
		document.form.telephone.focus();
		return false;
	}
	if(trim(document.form.note.value)=="")
	{
		alert("请输入详细说明！");
		document.form.note.focus();
		return false;
	}
}

function checkreg1()
{
	if (document.form1.type[0].checked == false && document.form1.type[1].checked == false)
	{
		alert("请选择是注册雇员还是注册雇主。");
		return false;
	}
}

function checkreg2()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("验证码填写不对，如果看不清，请刷新！");
		return false;
	}
	if (document.form1.type[0].checked == false && document.form1.type[1].checked == false)
	{
		alert("请选择是注册雇员还是注册雇主。");
		return false;
	}
}

function checkcomment1()
{
	if (trim(document.form1.content.value) == "")
	{
		alert("请填写评论！");
		return false;
	}
}

function checkcomment2()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("验证码填写不对，如果看不清，请刷新！");
		return false;
	}
	if (trim(document.form1.content.value) == "")
	{
		alert("请填写评论！");
		return false;
	}
}

function checknote1()
{
	if (trim(document.form1.name.value) == "")
	{
		alert("请填写姓名！");
		return false;
	}
	if (trim(document.form1.content.value) == "")
	{
		alert("请填写留言！");
		return false;
	}
}

function checknote2()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("验证码填写不对，如果看不清，请刷新！");
		return false;
	}
	if (trim(document.form1.name.value) == "")
	{
		alert("请填写姓名！");
		return false;
	}
	if (trim(document.form1.content.value) == "")
	{
		alert("请填写留言！");
		return false;
	}
}

function checkverity()
{
	if (document.code_check.form1.authnum.value!=document.code_check.form1.input_authnum.value)
	{
		alert("验证码填写不对，如果看不清，请刷新！");
		return false;
	}
}

function ifDel(delurl)
{
	var truthBeTold = window.confirm("您确定要删除吗？");
	if (truthBeTold)
	{
			location=delurl;
	}
	else
	{
		return;
	}
}
