<?
define('TOKEN', 'youtoken');

function getView()
{
	$url = 'https://www.youtube.com/c/youChanell/about';

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$html = curl_exec($ch);
	curl_close($ch);
	
	$dataView = explode('<', $html);
	$num = count($dataView);

	if(mb_strpos($html, 'просмотр'))
	{
		$pd = 2;
		for ($i = 0; $i < $num; $i++)
		{
			if(mb_strpos($dataView[$i], 'просмотр'))
			{
				$dataNum = explode('{', $dataView[$i]);
				$numDataNum = count($dataNum);
				for($j = 0; $j < $numDataNum; $j++)
				{
					if(mb_strpos($dataNum[$j], 'просмотр'))
					{
						$strView = $dataNum[$j];
						break;
					}
				}
			}
		}
	}

	$data = explode('"', $strView);
	return $data[3];
}

function getSub()
{
	$url = 'https://www.youtube.com/c/youChanell/about';

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$html = curl_exec($ch);
	curl_close($ch);
	
	$pd = true;
	
	$find = mb_strpos($html, 'подписчиков');
	$dataView = explode('<', $html);
	$num = count($dataView);

	if($find)
	{
		$pd = true;
		for ($i = 0; $i < $num; $i++)
		{
			if(mb_strpos($dataView[$i], 'подписчиков'))
			{
				$dataNum = explode('{', $dataView[$i]);
				$numDataNum = count($dataNum);
				for($j = 0; $j < $numDataNum; $j++)
				{
					if(mb_strpos($dataNum[$j], 'подписчиков'))
					{
						$strView = $dataNum[$j];
						break;
					}
				}
			}
		}
	}
	else if(mb_strpos($html, 'подписчик'))
	{
		$pd = false;
		for ($i = 0; $i < $num; $i++)
		{
			if(mb_strpos($dataView[$i], 'подписчик'))
			{
				$dataNum = explode('{', $dataView[$i]);
				$numDataNum = count($dataNum);
				for($j = 0; $j < $numDataNum; $j++)
				{
					if(mb_strpos($dataNum[$j], 'подписчик'))
					{
						$strView = $dataNum[$j];
						break;
					}
				}
			}
		}
	}
	$data = explode('"', $strView);
	return $data[3];
}

function SendSticker($send_data)
{
	$url = "https://api.telegram.org/bot".TOKEN."/sendSticker";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
	curl_setopt($ch, CURLOPT_TIMEOUT, 5); // times out after 4s
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$send_data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch); // run the whole process
	curl_close($ch);
	echo $result;
}

function SendMessage($send_data)
{
	$url = "https://api.telegram.org/bot".TOKEN."/sendMessage";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
	curl_setopt($ch, CURLOPT_TIMEOUT, 5); // times out after 4s
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$send_data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch); // run the whole process
	echo $result;
	curl_close($ch);
}
?>
