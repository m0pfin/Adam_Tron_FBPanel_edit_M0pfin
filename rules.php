<html>
<head>
    <title>Autorules by TRON</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <meta charset="utf8">
    <link href="styles/signin.css" rel="stylesheet">
</head>
    <body class="text-center">
<?
include 'functions.php';
if($_GET["act"]=="preadd"){
	$html = "<script src='js.js'></script><div align='center'><form method='POST' action='rules.php?act=add'><input name='token' placeholder= 'Токен' class='form-control'><br><br><input name='nname' placeholder='Имя' class='form-control'><br><br><input type='submit' class='btn btn-primary'></form><br><br><input type=\"button\" class='btn btn-danger' value=\"Назад\" href='rules.php'></div>";
	
	die($html);
}
if($_GET["act"]=="add"){
	$token = $_POST["token"];
	$nname = $_POST["nname"];
	AddAcc($token,$nname);
	header("location: rules.php");
	die();
}
if($_GET["act"]=="delete"){
	$text = file_get_contents("base.txt");
	$array = explode("\r\n",$text);
	$numstroki = $_GET["line"];
	unset($array[$numstroki]);	
	$text = implode("\r\n",$array);
	file_put_contents("base.txt",$text);
	$text = file_get_contents("base.txt");
	header("location: rules.php");
	die();
}
if($_GET["act"]=="reload"){
	$text = file_get_contents("base.txt");
	$array = explode("\r\n",$text);
	$numstroki = $_GET["line"];
	$token = $_GET["token"];
	$nname = $_GET["nname"];
	$url = "https://graph.facebook.com/v6.0/me/adaccounts?fields=business{name},name,account_id,created_time,adrules_library&access_token=".$token;
	$parametrs = array(
		'http' => array(
		'ignore_errors' => true,
		'method'  => 'GET'
		)
	);
	$result = file_get_contents($url, false, stream_context_create($parametrs));
		$json = json_decode($result,true);
		if(isset($json["error"])){
			$text = $json["error"]["message"];
			$html = '<script src="js.js"></script><div align="center">'.$text.'<br><br><br><input type="button" value="Назад" onclick="GoToMain();"></div>';
			die($html);
		}
		$line = array();
		for($i=0;$i<count($json["data"]);$i++){
			if(!isset($json["data"][$i]["business"])){
				$temparr["name"] = $json["data"][$i]["name"];
				$temparr["id"] = $json["data"][$i]["account_id"];
				$temparr["countadr"] = count($json["data"][$i]["adrules_library"]["data"]);
				$temp = $json["data"][$i]["created_time"];
				$temp = str_replace("T"," ",$temp);
				$temp = substr($temp, 0, -5);
				$temp = strtotime($temp);
				$temparr["created_time"] = $temp;
				$qwerty["1soc"][] = $temparr;
			
			} else {
				$bname = $json["data"][$i]["business"]["name"];
				$bid = $json["data"][$i]["business"]["id"];
				$temparr["name"] = $json["data"][$i]["name"];
				$temparr["id"] = $json["data"][$i]["account_id"];
				$temparr["countadr"] = count($json["data"][$i]["adrules_library"]["data"]);
				$temp = $json["data"][$i]["created_time"];
				$temp = str_replace("T"," ",$temp);
				$temp = substr($temp, 0, -5);
				$temp = strtotime($temp);
				$temparr["created_time"] = $temp;
				$temparr["bid"] = $bid;
				$line[$bname][] = $temparr;
			}
		}
		if($qwerty==""){
			$qwerty["1soc"][0]["name"] = "NOT FOUND";
			$qwerty["1soc"][0]["id"] = "0";
			$qwerty["1soc"][0]["countadr"] = 0;
			$qwerty["1soc"][0]["created_time"] = "1";
		}
		$line = $qwerty + $line + array("token"=>$token) + array("nname"=>$nname);
		foreach($line as $key => $value){
			if(($key!="token")&&($key!="nname")){
				$data_year=array();
				foreach($line[$key] as $key2=>$arr2){
					$data_year[$key2]=$arr2["created_time"];
				}
				array_multisort($data_year,SORT_ASC, SORT_NUMERIC, $line[$key]);
			}
		}
		$text = json_encode($line);
		$text = base64_encode($text);
		$array[$numstroki] = $text;
		$text = implode("\r\n",$array);
		file_put_contents("base.txt",$text);
		

		header("location: rules.php");
		die();
}
if($_GET["act"]=="read"){
	$token = $_GET["token"];
	$aid = $_GET["aid"];
	if(($_POST["name"]!="")&&($_POST["data"]!="")){
		file_put_contents("presets/".$_POST["name"],$_POST["data"]);
		header("location: rules.php");
		die();
	}
	$adrules = ReadAdrules($aid,$token);
	$str = ArrToStr($adrules,true);
	//echo "<pre>";
	//print_r($adrules);
	//echo "</pre>";
	echo '<script src="js.js"></script><div align="center"><form method="post"><textarea rows="20" cols="150" class="form-control" name="data">'.$str.'</textarea><br><input name="name" class="form-control" placeholder="Имя пресета"><input type="submit" class="btn btn-primary" value="Сохранить в пресет"></form><br><br><input type="button" class="btn btn-danger" value="Назад" onclick="GoToMain();"></div>';
	die();
}
if($_GET["act"]=="write"){
	$token = $_GET["token"];
	$aid = $_GET["aid"];
	echo '<script src="js.js"></script><div align="center"><form method="POST"><textarea name="rules" rows="20" cols="150"></textarea><br><br><input type="submit" value="Применить"></form><br><br><input type="button" value="Назад" onclick="GoToMain();"></div>';
	if(isset($_POST["rules"])){
		$rules = StrToArr($_POST["rules"], true);
		for($i=0;$i<count($rules);$i++){
			$rule = $rules[$i];
			WriteAdrules($rule,$token,$aid);
			sleep(2);
		}
		echo var_dump($rules);
	}
	
	die();
}
if($_GET["act"]=="writemult"){
	$filename = $_POST["preset"];
	$error_text = "";
	$array = array();
	for($i=0;$i<count($_POST["check"]);$i++){
		$array[$i]["id"] = explode("|",$_POST["check"][$i])[0];
		$array[$i]["token"] = explode("|",$_POST["check"][$i])[1];
	}
	$data = file_get_contents("./presets/".$filename);
	for($j=0;$j<count($array);$j++){
		$rules = StrToArr($data, true);
		for($i=0;$i<count($rules);$i++){
			$rule = $rules[$i];
			$error = WriteAdrules($rule,$array[$j]["token"],$array[$j]["id"]);
			$json = json_decode($error,true);
			if(isset($json["error"])){
				$error_text .= $array[$j]["id"].": ".$json["error"]["message"]."<br>";
			}
			//echo $array[$j]["id"]." - ".$array[$j]["token"]."<br>";
			//echo var_dump($rule);
			sleep(2);
		}
	}
	if($error_text!=""){
		$error_text = "<script src=\"js.js\"></script><div align=\"center\">Ошибки:<br><br>".$error_text."<br><br><br><input type=\"button\" value=\"Назад\" onclick=\"GoToMain();\"></div>";
		die($error_text);
	}
	header("location: rules.php");
}
$rand = rand(1000,999999999);
$html = "<script src='js.js?v=".$rand."'></script>";
$base = file_get_contents("base.txt");
$base = explode("\r\n",$base);
$data = "";
$i2=0;
for($i=0;$i<count($base)-1;$i++){
	$base[$i] = base64_decode($base[$i]);
	$base[$i] = json_decode($base[$i],true);
	$data .= "<tr><td></td></tr>";
	foreach($base[$i] as $key => $value){
		if(($key!="token")&&($key!="nname")){
			$trans = $key;
			if($trans=="1soc"){
				$link_read = "<a href='rules.php?act=read&aid=".$base[$i][$key][0]["id"]."&token=".$base[$i]["token"]."'>[Read]</a>";
				$link_reload = "<a href='rules.php?act=reload&nname=".$base[$i]["nname"]."&line=".$i."&token=".$base[$i]["token"]."'>[Update]</a>";
				$link_delete = "<a href='rules.php?act=delete&line=".$i."'>[Delete]</a>";
				$link = $link_read." ".$link_reload." ".$link_delete;
				$trans = "Соц.";
				$tempi = $i+1;
				$countalladr = 0;
				foreach($base[$i] as $key222 => $value222){
					for($tttempi2=0;$tttempi2<count($base[$i][$key222]);$tttempi2++){
						if(($key222!="token")&&($key222!="nname")){
							$countalladr = $countalladr + $base[$i][$key222][$tttempi2]["countadr"];
						}
					}
				}
				if(count($base[$i])>2){
					$linkcolone = "<a href=\"#\" onclick=\"colapse1('".$i."',this);\">+</a>";
				}
				$checkname = $base[$i][$key][0]["id"]."|".$base[$i]["token"];
				$data .= "<tr $style><td>$linkcolone $tempi <input type='checkbox' name='check[]' value='".$checkname."'></td><td>Соц</td><td>".$base[$i][$key][0]["id"]."</td><td>".$base[$i][$key][0]["name"]."</td><td>".$base[$i]["nname"]."</td><td>".$countalladr." (".$base[$i][$key][0]["countadr"].")</td><td>".$link."</td></tr>";
			} else {
				if(count($base[$i][$key])>=1){
					$linkcolone = "<a href=\"#\" onclick=\"colapse2('".$i2."',this);\">+</a>";
				}
				$style = "style=\"display: none;\" name=\"one_".$i."\"";
				$tempi22 = 0;
				for($tttempi=0;$tttempi<count($base[$i][$key]);$tttempi++){
					$tempi22 = $tempi22 + $base[$i][$key][$tttempi]["countadr"];
				}
				$data .= "<tr $style><td>$linkcolone $tempi</td><td>БМ</td><td>".$base[$i][$key][0]["bid"]."</td><td>".$trans."</td><td></td><td>".$tempi22."</td><td> </td></tr>";
			}
			
			$linkcolone = "";
			//$trans = "";
			$tempi = "";
			$style = "style=\"display: none;\" name=\"two_".$i2."\"";
			$i2++;
			for($j=0;$j<count($base[$i][$key]);$j++){
				$link_read = "<a href='rules.php?act=read&aid=".$base[$i][$key][$j]["id"]."&token=".$base[$i]["token"]."'>[Read]</a>";
				$link = $link_read." ".$link_write;
				$checkname = $base[$i][$key][$j]["id"]."|".$base[$i]["token"];
				$data .= "<tr $style><td><input type='checkbox' name='check[]' value='".$checkname."'></td><td>РА</td><td>".$base[$i][$key][$j]["id"]."</td><td>".$base[$i][$key][$j]["name"]."</td><td></td><td>".$base[$i][$key][$j]["countadr"]."</td><td>".$link."</td></tr>";
			}
			$style = "";
			
		}
		
	}
	//echo $base[$i]["token"];
	
	
	

}
$html .= '<style>a{text-decoration:none;}</style><div align="center"><form method="POST" action="rules.php?act=writemult"><table class="table table-dark table-hover" style="font-size: 16px;"><tr><th>#</th><th>Type</th><th>Id</th><th>Name</th><th>Name2</th><th>А.П.</th><th>Act</th></tr>%data%</table></div>';
$html = str_replace("%data%",$data,$html);

$html.= '<br><div align="center"><input type="button" class="btn btn-primary" onclick="AddAcc();" value="Добавить аккаунт"><br><br>';
/*

for($i=0;$i<count($qqq);$i++){
	$tempi = $i+1;
	for($i2=0;$i2<count($qqq[$i][1]);$i2++){
		$temp = explode("!q1q1!",$qqq[$i][1][$i2]);
		$link_read = "<a href='rules.php?act=read&aid=".$temp[0]."&token=".$qqq[$i][0]."'>[Read]</a>";
		$link_del = "<a href='rules.php?act=del&line=".$base[$i]."'>[Del]</a>";
		$link_reload = "<a href='rules.php?act=reload&token=".$qqq[$i][0]."&line=".$base[$i]."'>[Update]</a>";
		//$link_write = "<a href='rules.php?act=write&token=".$qqq[$i][0]."&aid=".$qqq[$i]["aid"]."'>[Write]</a>";
		if($i2==0){
			$data .= "<tr><td>".$tempi."</td><td>".$temp[0]."</td><td>".$temp[1]."</td><td>".$link_read." ".$link_write."</td><td>".$link_del." ".$link_reload."</td></tr>";
		} else {
			$data .= "<tr><td> </td><td>".$temp[0]."</td><td>".$temp[1]."</td><td>".$link_read." ".$link_write."</td></tr>";
		}
	}	
}
*/

$dir    = './presets';
$files = scandir($dir);
$html.= "<select name='preset' class='form-control' size='8'style='width:900;' required>";
for($i=0;$i<count($files);$i++){
	if(($files[$i]!=".")&&($files[$i]!=".."))
	$html.= "<option>".$files[$i]."</option>";
}
$html.= "</select><br><br><input type='submit' class='btn btn-success' value='Применить выбранный пресет'></form></div>";

echo "<a href='index.php'>Статистика</a> / <a href='rules.php'>Автоправила</a>";
echo $html;
echo "<a href=\"https://vk.com/tron_cpa\">©ТРОН </a>|<a href='https://teleg.run/adamusfb'> Scripts by Adam</a>";
die();
?>
     </body>
</html>