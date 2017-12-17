<?php
!function_exists('adminmsg') && exit('Forbidden');
if($right<3) $lever="普通管理员"; 
elseif($adminuser==$manager) $lever="网站创始人";
else $lever="超级管理员";

require GetLang('left');

$leftdb=$lang;
unset($lang);
$leftinfo='';
$i=3;

$imgtype=$styletype=array();
list($imgtype[a0],$styletype[a0])=GetDeploy('a0');
list($imgtype[a1],$styletype[a1])=GetDeploy('a1');

foreach($leftdb as $key=>$left){
	$id='a'.$i;
	list($imgname,$style)=GetDeploy($id);
	
	$left && $output1="<table width=95% align=center cellspacing=1 cellpadding=3 class=tableborder>
		<tr class=header><td><a style=\"float:right\" href=\"#\" onclick=\"return IndexDeploy('$id',1)\"><img id=\"img_$id\" src=\"$skinpath/admin/images/$imgname.gif\"></a>
		<b>$key</b></td></tr>
		<tbody id=\"cate_$id\" class=bg>
		";
	$output2='';
	foreach($left as $key=>$value){
			if(is_array($value)){
				foreach($value as $k=>$v){
					$output2 .= "<tr><td onmouseover=\"this.className='tableborder';\" onmouseout=\"this.className='bg'\">".$v."</td>";
				}
			}else{
				$output2 .= "<tr><td onmouseover=\"this.className='tableborder';\" onmouseout=\"this.className='bg'\">".$value."</td>";
			}
 	}
	if($output2){
		$output1 .= $output2."</tr></td></tr></tbody></table><br>";
	}else{
		unset($output1);
	}
	$leftinfo .= $output1;
	$i++;
}

function GetDeploy($name){
	global $_COOKIE;
	if(strpos($_COOKIE['deploy'],"\t".$name."\t")===false){
		$type='nofold';
	}else{
		$type='fold';
		$style='display:none;';
	}
	return array($type,$style);
}

include PrintEot('adminleft');exit;
?>