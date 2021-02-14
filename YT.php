<!--Проверяет канал на новые видео и оповещает о новинках-->
<meta charset="utf-8">
<?
	include('func.php');
	$url = 'https://www.youtube.com/c/youChanell/videos';
	header('Content-Type: text/html; charset=utf-8');	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$html = curl_exec($ch);
	curl_close($ch);

	$data = explode('"title":{"runs":[{"text":"', $html);
	$dyt = explode('"', $data[1]);
	echo '<pre>';
	print_r($dyt);
	$Title = $dyt[0];
	$count = Count($dyt);

	for($i = 0; $i < $count; $i++)
	{
		if(strpos($dyt[$i], 'watch') != false)
		{
			$urly = $dyt[$i];
			break;
		}
	}
	$YTurl = "https://www.youtube.com".$urly;
	$link = mysqli_connect('127.0.0.1', 'lig', 'pas', 'DateBase');
	$res = mysqli_query($link, "SELECT `url` FROM `Table`");
	while($Data = mysqli_fetch_assoc($res))
	{
		if ($Data['url'] == $YTurl)
			$pd = true;
	}

	echo $myUrl."<br>";

	if(!$pd)
	{
		$sql = "INSERT INTO `Table` SET `url` = '$YTurl'";
		echo $sql;
		mysqli_query($link, $sql);

		$res2 = mysqli_query($link, "SELECT * FROM `BOOL` WHERE `id` = 1");
		$Data2 = mysqli_fetch_assoc($res2);
		if($Data2['bool'] == 'true')
		{
			$send_data = [
				'chat_id' => '-1001394123280',
				'text' => "Какой то кипишь на вашем канале!"."\n".$Title."\nСсылка: ".$YTurl
			];
			SendMessage($send_data);
		}
	}
	mysqli_close($link);
?>
