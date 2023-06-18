<?php

namespace app\models;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_category
 * @property string $name
 * @property string $description
 * @property string $image
 * @property int $status
 * @property string $date
 * @property string|null $fater_image
 * @property string|null $after_description
 *
 * @property Category $category
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_category', 'name', 'description', 'image', 'imageFile'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['id_user', 'id_category', 'status'], 'integer'],
            [['description', 'after_description'], 'string'],
            [['date'], 'safe'],
            [['name', 'image', 'fater_image'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_category' => 'Категория',
            'name' => 'Название',
            'description' => 'Описание',
            'image' => 'Изображение',
            'imageFile' => 'Изображение',
            'status' => 'Статус',
            'date' => 'Дата',
            'after_image' => 'Изображение после',
            'after_description' => 'Причина отклонения заявки',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'id_category']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function upload()
    {
        $this->image = $this->imageFile->baseName . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $this->imageFile->saveAs('web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }
}
