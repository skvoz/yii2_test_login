<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * EmailForm is the model behind the login form.
 */
class EmailForm extends Model
{
    public $email;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email  is required
            ['email', 'required'],
            ['email', 'email'],

        ];
    }

    /**
     * sent email to user
     * @param $email
     */
    public function email_send()
    {
        if ($this->validate()) {
        /*send email*/
        Yii::$app->mailer
            ->compose('mail',array('token'=>$this->get_token($this->email), 'email'=>$this->email))
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('subject')
            ->send();
            return true;
        }else{
            return false;
        }
    }

    /**
     * генерацыя токена
     * @param $mail
     */
    private function get_token($mail)
    {
        return md5($mail.Yii::$app->params['token_email_login']);
    }

}
