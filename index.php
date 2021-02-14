<?
include('func.php');
define('TOKEN', 'youtoken');

$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);

$msg = mb_strtolower($data['message']['text'], 'utf-8');
$chat_id = $data['message']['chat']['id'];
$DataUser = [
	'idUser'     => $data['message']['from']['id'],
	'first_name' => $data['message']['from']['first_name'],
	'last_name'  => $data['message']['from']['last_name'],
	'username'   => $data['message']['from']['username']
	];

setUserToSheep($DataUser);

$msgSize = mb_strlen($msg, 'utf-8');

$aFizruk = [
	'Оставьте меня в покое, пожалуйста:(',
	'Сколько еще можно меня доставать?',
	'Еще одно слово, и эта тарелка полетит вам в голову',
	'Физрук да физрук, надоели уже'
	];



$id = $data['message']['from']['id'];
if ($id == 'Чей-то id')
{
	if(($msgSize >= 20) or (mb_strpos($msg, ":(") > -1))
	{
		$r = rand(1, 10);
		if($r < 6)
		{
			$method = 'sendSticker';
			$send_data = [
					'chat_id' => $chat_id,
					'sticker' => 'Какой-то стикер'
					];
			goto link;
		}
	}
}

if(mb_strpos($msg, "физр") > -1)
{
	$rand = rand(0, 3);
	$method = 'sendMessage';
	$send_data = [
			'chat_id' => $chat_id,
			'text' => $aFizruk[$rand]
			];
	goto link;
}

switch ($msg) 
{
	case '/cat':
		$method = 'sendSticker';
		$send_data = [
			'chat_id' => $chat_id,
			'sticker' => 'CAACAgIAAxkBAAP6X9CD5pc5m-Ffgz-AOhI6gD4OePYAAg0AA1rIcxmvriQ5nXSOzB4E'
		];
		break;
	case '/stat':
		$method = 'sendMessage';
		$send_data = [
			'chat_id' => $chat_id,
			'text' => "У Вас аж ".getView()."!\nИ целых ".getSub()."!"
		];
		break;
}
link: 

if($method == 'sendMessage')
	SendMessage($send_data);
else if($method == 'sendSticker')
	SendSticker($send_data);
?>
