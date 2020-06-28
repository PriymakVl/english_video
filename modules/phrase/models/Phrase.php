<?php

namespace app\modules\phrase\models;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\SoundUpload;
use app\models\Sound;
use app\modules\text\models\Text;

/**
 * This is the model class for table "strings".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property int|null $id_text
 * @property int|null $status
 */
class Phrase extends \app\models\ModelApp
{
    use \app\traits\SoundTrait, \app\traits\BreakTextTrait, \app\traits\PhraseTrait;
    
    public $sound_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phrases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['engl', 'ru'], 'required'],
            [['text_id', 'status', 'sound_id'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['engl', 'ru'], 'trim'],
            [['sound_file'], 'file',  'extensions' => 'wav, mp3'],
            ['parent_id', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'engl' => 'Engl',
            'ru' => 'Ru',
            'text_id' => 'Id Text',
            'status' => 'Status',
            'prev' => 'Предыдущая фраза',
            'next' => 'Следующая фраза',
        ];
    }

    public function beforeSave($insert) 
    {
        if ($this->sound_file) {
            $file = new SoundUpload();
            $sound = $this->sound_id ? Sound::findOne($this->sound_id) : new Sound();
            $sound->filename = $file->uploadFile($this->sound_file, $sound->filename); 
            $sound->save(false);
            $this->sound_id = $sound->id;
        }
        return parent::beforeSave($insert);
    }

    public function getText()
    {
        return $this->hasOne(Text::className(), ['id' => 'text_id']);
    }

    public function getSubstr()
    {
        return self::findAll(['parent_id' => $this->id, 'status' => STATUS_ACTIVE]);
    }

    public function templateSubstr()
    {
        if (!$this->substr) return '';
        $template = '<ul>';
        foreach ($this->substr as $sub) {
            $template .= sprintf('<li title="%s">%s</li>', $sub->ru, $sub->engl);
        }
        return $template . '</ul>';
    }



    

    



}
