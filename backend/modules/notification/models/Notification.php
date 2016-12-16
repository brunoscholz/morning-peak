<?php
namespace backend\modules\notification\models;
use backend\modules\notification\NotificationsModule;
use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "notification".
 *
 * @property integer $notificationId
 * @property integer $userId
 * @property string $key
 * @property string $keyId
 * @property string $type
 * @property boolean $seen
 * @property string $createdAt
 */
abstract class Notification extends ActiveRecord
{
    /**
     * Default notification
     */
    const TYPE_DEFAULT = 'default';
    /**
     * Error notification
     */
    const TYPE_ERROR   = 'error';
    /**
     * Warning notification
     */
    const TYPE_WARNING = 'warning';
    /**
     * Success notification type
     */
    const TYPE_SUCCESS = 'success';
    /**
     * @var array List of all enabled notification types
     */
    public static $types = [
        self::TYPE_WARNING,
        self::TYPE_DEFAULT,
        self::TYPE_ERROR,
        self::TYPE_SUCCESS,
    ];
    /**
     * Gets the notification title
     *
     * @return string
     */
    abstract public function getTitle();
    /**
     * Gets the notification description
     *
     * @return string
     */
    abstract public function getDescription();
    /**
     * Gets the notification route
     *
     * @return string
     */
    abstract public function getRoute();
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'userId', 'key', 'createdAt'], 'required'],
            [['notificationId', 'keyId', 'createdAt'], 'safe'],
            [['notificationId', 'userId', 'keyId', 'key'], 'string', 'max' => 21],
        ];
    }
    /**
     * Creates a notification
     *
     * @param string $key
     * @param integer $userId The user id that will get the notification
     * @param string $key_id The foreign instance id
     * @param string $type
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws \Exception
     */
    public static function notify($key, $userId, $keyId = null, $type = self::TYPE_DEFAULT)
    {
        $class = self::className();
        return NotificationsModule::notify(new $class(), $key, $userId, $keyId, $type);
    }
    /**
     * Creates a warning notification
     *
     * @param string $key
     * @param integer $userId The user id that will get the notification
     * @param string $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function warning($key, $userId, $keyId = null)
    {
        return static::notify($key, $userId, $keyId, self::TYPE_WARNING);
    }
    /**
     * Creates an error notification
     *
     * @param string $key
     * @param integer $userId The user id that will get the notification
     * @param string $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function error($key, $userId, $keyId = null)
    {
        return static::notify($key, $userId, $keyId, self::TYPE_ERROR);
    }
    /**
     * Creates a success notification
     *
     * @param string $key
     * @param integer $userId The user id that will get the notification
     * @param string $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function success($key, $userId, $keyId = null)
    {
        return static::notify($key, $userId, $keyId, self::TYPE_SUCCESS);
    }
}