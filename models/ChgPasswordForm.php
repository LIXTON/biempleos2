<?php
namespace app\models;

use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class ChgPasswordForm extends Model
{
    public $contrasena;
    public $new_contrasena;
    public $recontrasena;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Simplificacion de codigo y se agrego el campo repetir contraseña //
            [['contrasena', 'new_contrasena', 'recontrasena'], 'required'],
            // password is validated by validatePassword()
            ['contrasena', 'validatePassword'],

            // Repetir contraseña tiene las mismas reglas que nueva contraseña //
            [['new_contrasena', 'recontrasena'], 'string', 'min' => 6],
            ['recontrasena', 'compare', 'compareAttribute' => 'new_contrasena', 'message' => 'Las contraseñas no coinciden'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!\Yii::$app->user->identity->validatePassword($this->contrasena)) {
                $this->addError($attribute, 'Contraseña incorrecta.');
            }
        }
    }
}
