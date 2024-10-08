<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "pemesanan".
 *
 * @property int $pemesanan_id
 * @property int $user_id
 * @property string $tanggal
 * @property float $total_item
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property PesanDetail[] $pesanDetails
 * @property User $user
 */
class Pemesanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pemesanan';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'), // or date('Y-m-d H:i:s')
            ],
        ];
    }
    public function rules()
    {
        return [
            [['user_id', 'tanggal', 'total_item'], 'required'],
            [['user_id'], 'integer'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['total_item'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pemesanan_id' => 'Pemesanan ID',
            'user_id' => 'User ID',
            'tanggal' => 'Tanggal',
            'total_item' => 'Total Item',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[PesanDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPesanDetails()
    {
        return $this->hasMany(PesanDetail::class, ['pemesanan_id' => 'pemesanan_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }
    public function getFormattedOrderId()
    {
        return 'FPB-' . str_pad($this->pemesanan_id, 3, '0', STR_PAD_LEFT);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Mengubah format tanggal dari dd-mm-yyyy ke yyyy-mm-dd sebelum disimpan
            $this->tanggal = Yii::$app->formatter->asDate($this->tanggal, 'php:Y-m-d');
            return true;
        } else {
            return false;
        }
    }

    public function updateTotalItem($pemesanan_id)
    {
        // Menghitung total item dari semua detail pembelian menggunakan relasi
        $totalItem = $this->getPesanDetails()
            ->where(['pemesanan_id' => $pemesanan_id])
            ->count();

        // Update total item pada tabel pembelian
        $this->total_item = $totalItem;
        return $this->save();
    }
}
