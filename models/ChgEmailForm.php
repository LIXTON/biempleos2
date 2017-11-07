<?php
namespace app\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use yii\web\ForbiddenHttpException;
use app\models\User;

/**
 * Password reset form
 */
class ChgEmailForm extends Model
{
    public $email;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Change Email.
     * User must be login
     *
     * @return bool if password was reset.
     */
    public function changeEmail($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token cannot be blank.');
        }
        
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to perform this action. Login and try again.');
        }
        
        Yii::$app->user->identity->refresh();
        $user = Yii::$app->user->identity;
        if ($user->reset_token == $token) {
            throw new InvalidParamException('Wrong Token.');
        }
        
        $user->correo = $this->email;
        $user->removeResetToken();

        return $user->save(false);
    }
    
    /**
     * Sends an email with a link, for changing the email.
     * User must be login
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to perform this action. Login and try again.');
        }
        
        $user = Yii::$app->user->identity;
        
        if (!User::isEmailResetTokenValid($user->reset_token)) {
            $user->generateEmailResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailResetToken-html', 'text' => 'emailResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->correo)
            ->setSubject('Email reset for ' . Yii::$app->name)
            ->send();
    }
}
