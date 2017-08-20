<?php
namespace app\models;

use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $correo;
    public $contrasena;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['correo', 'trim'],
            ['correo', 'required'],
            ['correo', 'email'],
            ['correo', 'string', 'max' => 255],
            ['correo', 'unique', 'targetClass' => '\models\User', 'message' => 'This email address has already been taken.'],

            ['contrasena', 'required'],
            ['contrasena', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->correo = $this->correo;
        $user->setPassword($this->contrasena);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
