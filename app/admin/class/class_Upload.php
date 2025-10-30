<?php
// ��ȡ������С
class cUpload
{
	function sizecount($filesize) 
	{
		if($filesize >= 1073741824) 
		{
			$filesize = round($filesize / 1073741824 * 100) / 100 . ' G';
		} 
		elseif($filesize >= 1048576)
		{
			$filesize = round($filesize / 1048576 * 100) / 100 . ' M';
		} 
		elseif($filesize >= 1024)
		{
			$filesize = round($filesize / 1024 * 100) / 100 . ' K';
		} 
		else 
		{
			$filesize = $filesize . ' bytes';
		}
		return $filesize;
	}

	// ����ļ���չ��
	function getext($filename)
	{
		return strtolower(substr(strrchr($filename, "."), 1));
	}
	// �ϴ��ļ�����
	function upload($filetmp,$uploadpath)
	{
		$ext = $this->getext($uploadpath);
		if (strlen($ext)==0 || !in_array($ext,array('exe','txt','rar','zip','doc','xls','gif', 'jpg', 'jpeg', 'png', 'swf', 'ppt', 'pdf')))
			return 1;
		if (copy($filetmp,$uploadpath))
		{
			@chmod ($uploadpath, 0666);
			unlink ($filetmp);
			return 0;
		}
		else
		{
			return 2;
		}
	}
	//��������ͼ
	function makeThumb($srcFile,$dstPath,$dstW=180,$dstH=150,$lock=0) //lock��Դͼ��Сʱ���Ƿ�ǿ�б��0Ϊ����ԭ��1Ϊǿ������
	{ 
		$data = getimagesize($srcFile); 
		$srcW = $data[0]; $srcH= $data[1]; 
		$dstFile = $dstPath.basename($srcFile);
		switch ($data[2]) 
		{ 
		case 1: //gif 
			$img = imagecreatefromgif($srcFile); 
			break; 
		case 2: //jpg 
			$img = imagecreatefromjpeg($srcFile); 
			break; 
		case 3: //png 
			$img = imagecreatefrompng($srcFile); 
			break; 
		default: 
			return 0; 
			break; 
		} 
		if (!$img) 
		return 0; 

		$dstX=0; $dstY=0; 

		if ($srcW * $dstH > $srcH * $dstW) //ƫ��
		{
			$fdstW = $dstW;
			$fdstH = round($srcH * $dstW / $srcW);
			$dstY = floor(($dstH - $fdstH) / 2);
		}

		else //ƫ��
		{
			$fdstW = round($srcW * $dstH / $srcH); 
			$fdstH = $dstH;
			$dstX = floor(($dstW - $fdstW) / 2);
		}
		$dstX = ($dstX<0) ? 0 : $dstX; 
		$dstY = ($dstX<0) ? 0 : $dstY; 
		if (function_exists("imagecreatetruecolor")) //GD2.0.1 
		{ 
			if ($lock == 1)
			{
				$new = imagecreatetruecolor($dstW, $dstH); 
				$black = ImageColorAllocate($new, 255,255,255); //���ı���ɫ�������õ��ǰ�ɫ 
				imagefilledrectangle($new,0,0,$dstW,$dstH,$black);
				ImageCopyResampled($new, $img, $dstX, $dstY, 0, 0, $fdstW, $fdstH, $srcW, $srcH); 
			}
			else
			{
				if ($srcW<$dstW && $srcH<$dstH) {$fdstW=$srcW;$fdstH=$srcH;}//ͼ�Ƚ�Сʱ����
				$new = imagecreatetruecolor($fdstW, $fdstH); 
				$black = ImageColorAllocate($new, 255,255,255); //���ı���ɫ�������õ��ǰ�ɫ 
				imagefilledrectangle($new,0,0,$dstW,$dstH,$black);
				ImageCopyResampled($new, $img, 0, 0, 0, 0, $fdstW, $fdstH, $srcW, $srcH); 
			}
		} 
		else 
		{ 
			if ($lock == 1)
			{
				$new = imagecreate($dstW, $dstH); 
				$black = ImageColorAllocate($new, 0,0,0); //���ı���ɫ�������õ��Ǻ�ɫ 
				imagefilledrectangle($new,0,0,$dstW,$dstH,$black);
				ImageCopyResized($new, $img, $dstX, $dstY, 0, 0, $fdstW, $fdstH, $srcW, $srcH); 
			}
			else
			{
				if ($srcW<$dstW && $srcH<$dstH) {$fdstW=$srcW;$fdstH=$srcH;}//ͼ�Ƚ�Сʱ����
				$new = imagecreate($fdstW, $fdstH); 
				$black = ImageColorAllocate($new, 0,0,0); //���ı���ɫ�������õ��Ǻ�ɫ 
				imagefilledrectangle($new,0,0,$dstW,$dstH,$black);
				ImageCopyResized($new, $img, 0, 0, 0, 0, $fdstW, $fdstH, $srcW, $srcH); 
			}
		}
		ImageJPEG($new,$dstFile); 
		ImageDestroy($new); 
		ImageDestroy($img); 
	} 
}
?>