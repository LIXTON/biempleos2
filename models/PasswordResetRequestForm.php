<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $correo;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['correo', 'trim'],
            ['correo', 'required'],
            ['correo', 'email'],
            ['correo', 'exist',
                'targetClass' => 'app\models\User',
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'correo' => $this->correo,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->correo)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
