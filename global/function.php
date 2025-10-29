<?php
//显示IP（例如211.66.17.*)
function showip($ip)
{
	$ip_slice = explode('.', $ip);
	$ips = $ip_slice[0].".".$ip_slice[1].".".$ip_slice[2].".*";
	return $ips;
}

//截取字符串
function gbsubstr($str,$start,$len)
{
	$strlen=strlen($str);
	$clen=0;
	for($i=0;$i<$strlen;$i++,$clen++)
	{
		if ($clen>=$start+$len)
		{
			$tmpstr.="..";
			break;
		}
		if(ord(substr($str,$i,1))>0xa0)
		{
			if ($clen >= $start)
				$tmpstr.=substr($str,$i,2);
			$i++;$clen++;
		}
		else
		{
			if ($clen>=$start)
				$tmpstr.=substr($str,$i,1);
		}
	}
	return $tmpstr;
}
// 获取客户端IP
function getip() {
	if (isset($_SERVER)) {
		if (isset($_SERVER[HTTP_X_FORWARDED_FOR])) {
			$realip = $_SERVER[HTTP_X_FORWARDED_FOR];
		} elseif (isset($_SERVER[HTTP_CLIENT_IP])) {
			$realip = $_SERVER[HTTP_CLIENT_IP];
		} else {
			$realip = $_SERVER[REMOTE_ADDR];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$realip = getenv( "HTTP_X_FORWARDED_FOR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
		} else {
			$realip = getenv("REMOTE_ADDR");
		}
	}
	return $realip;
}
//随机字符串
function M_random($length) {
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}
//格式化时间
function oadate($format, $timestamp) {
	global $clienttimezone,$servertimezone;
	$time = $timestamp + ($clienttimezone - $servertimezone) * 3600;
	if ($time < 0) {
		$time = 0;
	}
	return date($format, $time);
}

//AddSlashes
function checkPost($data)
{
	if(!get_magic_quotes_gpc()) {
		return is_array($data)?array_map('AddSlashes',$data):addslashes($data);
	} else {
		Return $data;
	}
}
//检查字符串
function checkStr($data)
{
	if (strstr($data,'<') || strstr($data,'>') || strstr($data,'\\') || strstr($data,'&') || strstr($data,"'") || strstr($data,'"')) 
		oa_exit("文本框中不允许出现 &lt; &gt; &quot; &amp; 半角单双引号 等特殊字符");
	else
		return trim($data);
}
//
function html2str($data)
{
	$data = strip_tags($data);
	$data = str_replace("&amp;","&",$data);
	$data = str_replace("&quot;","\"",$data);
	$data = str_replace("&lt;","<",$data);
	$data = str_replace("&gt;",">",$data);
	$data = str_replace("&nbsp;"," ",$data);
	return ($data);
}
function str2html($data)
{
	return checkPost(nl2br(htmlspecialchars(trim($data))));
}

// 分页
function page($num, $perpage, $curr_page, $mpurl) {
	if (substr($mpurl, -1) == "?")
	{
		$add = "";
	}
	else
	{
		$add = "&amp;";
	}
	$multipage = '';
	if($num > $perpage) {
		$page = 10;
		$offset = 2;

		$pages = ceil($num / $perpage);
		$from = $curr_page - $offset;
		$to = $curr_page + $page - $offset - 1;
			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				if($from < 1) {
					$to = $curr_page + 1 - $from;
					$from = 1;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $curr_page - $pages + $to;
					$to = $pages;
						if(($to - $from) < $page && ($to - $from) < $pages) {
							$from = $pages - $page + 1;
						}
				}
			}
			$pre_page = ($curr_page > 1) ? $curr_page - 1 : 1;
			$next_page = ($curr_page < $to) ? $curr_page + 1 : $to;
			$multipage .= "<a href=\"".$mpurl.$add."page=1\" class=\"multi_page\"><b>&laquo;</b></a> <a href=\"".$mpurl.$add."page=".$pre_page."\" class=\"multi_page\"><b>&#8249;</b></a> ";
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) {
					$multipage .= "<a href=\"".$mpurl.$add."page=$i\" class=\"multi_page\">$i</a> ";
				} else {
					$multipage .= '<u><b>'.$i.'</b></u> ';
				}
			}
			$multipage .= $pages > $page ? " ... <a href=\"".$mpurl.$add."page=$pages\" class=\"multi_page\">$pages</a> <a href=\"".$mpurl.$add."page=$next_page\" class=\"multi_page\"><b>&#8250;</b></a> <a href=\"".$mpurl.$add."page=$pages\" class=\"multi_page\"><b>&raquo;</b></a>" : " <a href=\"".$mpurl.$add."page=$next_page\" class=\"multi_page\"><b>&#8250;</b></a> <a href=\"".$mpurl.$add."page=$pages\" class=\"multi_page\"><b>&raquo;</b></a>";
	}
	return $multipage;
}
?>