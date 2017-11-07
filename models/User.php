<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $correo
 * @property string $contrasena_hash
 * @property string $reset_token
 * @property string $auth_key
 * @property string $rol
 * @property string $contrasena write-only password
 * 
 * @property Aspirante $aspirante
 * @property Empresa $empresa
 */
class User extends ActiveRecord implements IdentityInterface
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usuario}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by correo
     *
     * @param string $correo
     * @return static|null
     */
    public static function findByCorreo($correo)
    {
        return static::findOne(['correo' => $correo]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'reset_token' => $token,
        ]);
    }
    
    /**
     * Finds user by email reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByEmailResetToken($token)
    {
        if (!static::isEmailResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token) || substr($token, 0, 1) != "P") {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.resetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    /**
     * Finds out if email reset token is valid
     *
     * @param string $token email reset token
     * @return bool
     */
    public static function isEmailResetTokenValid($token)
    {
        if (empty($token) || substr($token, 0, 1) != "E") {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.resetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($contrasena)
    {
        return Yii::$app->security->validatePassword($contrasena, $this->contrasena_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($contrasena)
    {
        $this->contrasena_hash = Yii::$app->security->generatePasswordHash($contrasena);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->reset_token = "P" . Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    /**
     * Generates new email reset token
     */
    public function generateEmailResetToken()
    {
        $this->reset_token = "E" . Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removeResetToken()
    {
        $this->reset_token = null;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAspirante()
    {
        return $this->hasOne(Aspirante::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id_usuario' => 'id']);
    }
}
