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
    public $recontrasena;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Simplificacion de codigo y se agrego el campo repetir contraseña //
            [['correo', 'contrasena', 'recontrasena'], 'required'],
            ['correo', 'trim'],
            ['correo', 'email'],
            ['correo', 'string', 'max' => 255],
            ['correo', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            // Repetir contraseña tiene las mismas reglas que contraseña //
            [['contrasena', 'recontrasena'], 'string', 'min' => 6],
            ['recontrasena', 'compare', 'compareAttribute' => 'contrasena', 'message' => 'Las contraseñas no coinciden'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($rol)
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->correo = $this->correo;
        $user->setPassword($this->contrasena);
        $user->generateAuthKey();
        $user->rol = $rol;
        
        return $user->save() ? $user : null;
    }
}
