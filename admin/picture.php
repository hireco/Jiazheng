<?php 
//������֤��ͼƬ 
Header("Content-type: image/PNG");  
srand((double)microtime()*1000000);//����һ������������ֵ����ӣ��Է���������������ɵ�ʹ��

session_start();//�����������session��
$_SESSION['authnum']="";
$im = imagecreate(62,20); //�ƶ�ͼƬ������С

$black = ImageColorAllocate($im, 0,0,0); //�趨������ɫ
$white = ImageColorAllocate($im, 255,255,255); 
$gray = ImageColorAllocate($im, 200,200,200); 

imagefill($im,0,0,$gray); //����������䷨���趨��0,0��

while(($authnum=rand()%10000)<1000);
//����λ������֤�����ͼƬ 
$_SESSION['authnum']=$authnum;
imagestring($im, 5, 10, 3, $authnum, $black);
// �� col ��ɫ���ַ��� s ���� image �������ͼ��� x��y ���괦��ͼ������Ͻ�Ϊ 0, 0����
//��� font �� 1��2��3��4 �� 5����ʹ����������

for($i=0;$i<200;$i++)   //����������� 
{ 
    $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
} 


ImagePNG($im); 
ImageDestroy($im); 

?> 
