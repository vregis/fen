<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $email_to
 * @property integer $subject
 * @property string $message
 */
class QuickEmail extends \yii\db\ActiveRecord
{
    public $email_to;
    public $subject;
    public $message;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_to', 'subject', 'message'], 'required'],
            [['message', 'subject'], 'string'],
            [['email_to'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email_to' => 'Email',
            'subject' => 'Тема сообщения',
            'message' => 'Сообщение',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email_to => Yii::$app->user->identity->name])
            ->setSubject($this->subject)
            ->setHtmlBody($this->message)
            ->send();
    }

}
