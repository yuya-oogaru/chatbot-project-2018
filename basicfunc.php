<?php
/******���b�Z�[�W�����`��******/
function replyMultiMessage($bot, $replyToken, ...$msgs) {
	// MultiMessageBuilder���C���X�^���X��
	$builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
	// �r���_�[�Ƀ��b�Z�[�W��S�Ēǉ�
	foreach($msgs as $value) {
		$builder->add($value);
	}
	$response = $bot->replyMessage($replyToken, $builder);
	
	if (!$response->isSucceeded()) {
		error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
	}
}

// Confirm�e���v���[�g��ԐM�B������LINEBot�A�ԐM��A��փe�L�X�g�A
// �{���A�A�N�V����(�ϒ�����)
function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {
  $actionArray = array();
  foreach($actions as $value) {
    array_push($actionArray, $value);
  }
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
    $alternativeText,
    // Confirm�e���v���[�g�̈����̓e�L�X�g�A�A�N�V�����̔z��
    new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder ($text, $actionArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

/*�f�[�^�x�[�X�ڑ��N���X*/

class dbConnection{
	// �C���X�^���X
	protected static $db;
	// �R���X�g���N�^
	private function __construct() {
		try {
			// ���ϐ�����f�[�^�x�[�X�ւ̐ڑ������擾��
			$url = parse_url(getenv('DATABASE_URL'));
			// �f�[�^�\�[�X
			$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
			// �ڑ����m��
			self::$db = new PDO($dsn, $url['user'], $url['pass']);
			// �G���[����O�𓊂���悤�ɐݒ�
			self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $e) {
			error_log('Connection Error: ' . $e->getMessage());
		}
	}

	// �V���O���g���B���݂��Ȃ��ꍇ�̂݃C���X�^���X��
	public static function getConnection() {
		if (!self::$db) {
			new dbConnection();
		}
		return self::$db;
	}
}



?>
