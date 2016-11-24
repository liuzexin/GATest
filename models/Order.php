<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $channel_id
 * @property string $transaction_id
 * @property integer $impp_order_id
 * @property string $phone_num
 * @property integer $status
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $price
 * @property integer $settlement_status
 * @property integer $statement_status
 * @property string $fail_reason
 */
class Order extends ActiveRecord
{
    //订单类型
    const ORDER_TYPE_NORMAL = 1;
    const ORDER_TYPE_EXCEPTION = 2;
    const ORDER_TYPE_RETURN = 3;
    //结算状态
    const SETTLEMENT_STATUS_NO = 1;
    const SETTLEMENT_STATUS_YES = 2;
    //对账状态
    const STATEMENT_STATUS_NO = 1;      //末对账
    const STATEMENT_STATUS_YES = 2;     //已经对账

    //订单对账状态
    const ORDER_STATUS_PAY_WAIT = 1;
    const ORDER_STATUS_PAY_SUCC = 2;
    const ORDER_STATUS_PAY_FAIL = 3;
    const ORDER_STATUS_PROCESS = 4;
    const ORDER_STATUS_OPEN_SUCC = 5;
    const ORDER_STATUS_OPEN_FAIL = 6;
    const ORDER_STATUS_PASS_SUCC = 7;
    const ORDER_STATUS_PASS_FAIL = 8;

    //订单下单状态
    const ORDER_STATUS_NEW = 101;
    const ORDER_STATUS_PRE = 102;
    const ORDER_STATUS_FAIL = 103;

    //订单失败原因
    //00：订购成功
    //01：实体卡错误
    //02：手机号段查不到归属省
    //03：BOSS无响应；
    //04：用户已订业务与现有业务互斥，不能同时订购-
    //05：用户已订购该业务
    //06：用户未订购该业务或已退订
    //07：到达充值限额，开通失败
    //08：用户不存在
    //09：用户状态错误
    //10：落地方内部错误
    const FR_SUC = 0;
    const FR_CARD_ERR = 1;
    const FR_PN_AREA_ERR = 2;
    const FR_BOSS_ERR = 3;
    const FR_CONFLICT = 4;
    const FR_ALREADY_ORDER = 5;
    const FR_RETURN = 6;
    const FR_LIMIT = 7;
    const FR_USER_NOTEXIST = 8;
    const FR_USER_STATUS_ERR = 9;
    const FR_BYL = 10;
    //订单返回结果 rsp_code rc
    const RC_SUC = '0000';
    const RC_TID_ERR = '0001';
    const RC_CARD_ERR = '0002';
    const RC_PHONENUM_ERR = '0003';
    const RC_CHANNEL_NULL = '0004';
    const RC_CHANNEL_ERR = '0005';
    const RC_STOCK_ERROR = '0006';
    const RC_REQUEST_ERR = '0007';
    const RC_ACCESS_ERR = '0008';
    const RC_DUPLICATE_RES = '0009';
    const RC_NE_BALANCE = '0010';
    const RC_UNKNOW_ERR = '0011';
    const RC_PARAMS_ERR  = '0012';
    const RC_SERVER_ERR = '0013';
    const RC_IMPP_ERR = '0014';
    const RC_FUNC_ERR = '0015';
    const RC_UF_TM = '0016';
    const RC_IP_ERR = '0017';

    public static $rspCodes = [
        self::RC_SUC => '成功',
        self::RC_TID_ERR => '流水号为空，流水号不合法',
        self::RC_CARD_ERR => '非法卡品',
        self::RC_PHONENUM_ERR => '非法手机号',
        self::RC_CHANNEL_NULL => '渠道订单号为空',
        self::RC_CHANNEL_ERR => '非法渠道',
        self::RC_STOCK_ERROR => '库存不足',
        self::RC_REQUEST_ERR => '请求包为空',
        self::RC_ACCESS_ERR => '平台鉴权失败',
        self::RC_DUPLICATE_RES => '重复的交易流水号',
        self::RC_NE_BALANCE => '账户余额不足',
        self::RC_UNKNOW_ERR => '其他失败',
        self::RC_PARAMS_ERR  => '解析参数错误',
        self::RC_SERVER_ERR => '服务器错误',
        self::RC_IMPP_ERR => '充值平台错误',
        self::RC_FUNC_ERR => '业务类型错误',
        self::RC_UF_TM => '用户当日已经多次失败',
        self::RC_IP_ERR => 'IP不合法',
    ];

    public static $failReasons = [
        self::FR_SUC => '订购成功',
        self::FR_CARD_ERR => '实体卡错误',
        self::FR_PN_AREA_ERR => '手机号段查不到归属省',
        self::FR_BOSS_ERR => 'BOSS无响应',
        self::FR_CONFLICT => '用户已订业务与现有业务互斥，不能同时订购',
        self::FR_ALREADY_ORDER => '用户已订购该业务',
        self::FR_RETURN => '用户未订购该业务或已退订',
        self::FR_LIMIT => '到达充值限额，开通失败',
        self::FR_USER_NOTEXIST => '用户不存在',
        self::FR_USER_STATUS_ERR => '用户状态错误',
        self::FR_BYL => '落地方内部错误',
    ];
    public static $types = [
        self::ORDER_TYPE_NORMAL => "正常订单",
        self::ORDER_TYPE_EXCEPTION => "异常订单",
        self::ORDER_TYPE_RETURN => "退货单",
    ];

    public static $settlements = [
        self::SETTLEMENT_STATUS_NO => '末结算',
        self::SETTLEMENT_STATUS_YES => '已结算',
    ];

    public static $statements = [
        self::STATEMENT_STATUS_NO => '末对账',
        self::STATEMENT_STATUS_YES => '已对账',
    ];

    public static $statuses = [
        self::ORDER_STATUS_PAY_WAIT => '等待支付',
        self::ORDER_STATUS_PAY_SUCC => '支付成功',
        self::ORDER_STATUS_PAY_FAIL => '支付失败',
        self::ORDER_STATUS_PROCESS => '处理中',
        self::ORDER_STATUS_OPEN_SUCC => '开卡成功',
        self::ORDER_STATUS_OPEN_FAIL => '开卡失败',
        self::ORDER_STATUS_PASS_SUCC => '卡密下发成功',
        self::ORDER_STATUS_PASS_FAIL => '卡密下发失败',

        self::ORDER_STATUS_NEW => '新建订单',
        self::ORDER_STATUS_PRE => '预处理订单',
       // self::ORDER_STATUS_TEST =>'测试订单',
        self::ORDER_STATUS_FAIL => '订单失败'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function getTypeText()
    {
        return isset(self::$types[$this->type]) ? self::$types[$this->type] : '';
    }

    public function getSettlementText()
    {
        return isset(self::$settlements[$this->settlement_status]) ? self::$settlements[$this->settlement_status] : '';
    }

    public function getStatementText()
    {
        return isset(self::$statements[$this->statement_status]) ? self::$statements[$this->statement_status] : '';
    }

    public function getStatusText()
    {
        return isset(self::$statuses[$this->status]) ? self::$statuses[$this->status] : '';
    }

    public function getRspCodeText()
    {
        return isset(self::$rspCodes[$this->rsp_code]) ? self::$rspCodes[$this->rsp_code] : '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'transaction_id', 'phone_num'], 'required'],
            [['channel_id', 'status', 'type', 'created_at', 'updated_at', 'updated_by', 'settlement_status', 'statement_status'], 'integer'],
            [['transaction_id','impp_order_id'], 'string', 'max' => 50],
           // [['fail_reason'],'string','max' => 255 ],
            [['phone_num'], 'string', 'max' => 32],

        ];
    }

    public function getChannel()
    {
        return $this->hasOne(Channel::className(),['channel_id'=>'channel_id']);
    }

    public function getNotify()
    {
        return $this->hasOne(Notify::className(),['order_id'=>'id']);
    }

    public function getCards()
    {
        //return $this->hasMany(OrderCardItem::className(),['order_id'=>'id']);
        return $this->hasOne(OrderCardItem::className(),['order_id'=>'id']);
    }
   /* public function getInfo()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过子表的customer_id，关联主表的id字段
        return $this->hasOne(OrderAll::className(),['id'=>'order_id'] );
    }*/
    //先不实现 订单最终价格
    public function getTotalAmount()
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/orders', 'ID'),
            'channel_id' => Yii::t('app/orders', 'Channel ID'),
            'transaction_id' => Yii::t('app/orders', 'Transaction ID'),
            'impp_order_id' => Yii::t('app/orders', 'Impp Order ID'),
            'phone_num' => Yii::t('app/orders', 'Phone Num'),
            'status' => Yii::t('app/orders', 'Status'),
            'statustext' => Yii::t('app/orders', 'Status'),
            'orderstatus' => Yii::t('app/orders', 'Status'),
            'type' => Yii::t('app/orders', 'Type'),
            'typetext' => Yii::t('app/orders', 'Type'),
            'created_at' => Yii::t('app/orders', 'Created At'),
            'updated_at' => Yii::t('app/orders', 'Updated At'),
            'updated_by' => Yii::t('app/orders', 'Updated By'),
            'price' => Yii::t('app/orders', 'Price'),
            'settlementtext' => Yii::t('app/orders', 'Settlement Status'),
            'statementtext' => Yii::t('app/orders', 'Statement Status'),
            'fail_reason' => Yii::t('app/orders', 'Fail Reason'),
            'order_time' => Yii::t('app/orders', 'Order Time'),
            'rspcodetext' => Yii::t('app/orders', 'Rsp Code'),
        ];
    }
    public  function getLockedOrdersAmount($channelId)
    {
        return (new \yii\db\Query())
            ->select(['sum'=>'sum(price)'])
            ->from(self::tableName())
            ->where(['status' => self::ORDER_STATUS_PRE,'channel_id' => $channelId])
            ->one(static::getDb());
    }

    public function beforeSave($insert)
    {
        //初始化订单类型
        if(!in_array($this->type, [self::ORDER_TYPE_NORMAL, self::ORDER_TYPE_RETURN, self::ORDER_TYPE_EXCEPTION]))
        {
            $this->type = self::ORDER_TYPE_NORMAL;
        }
        //
        if(!in_array($this->settlement_status, [self::SETTLEMENT_STATUS_NO, self::SETTLEMENT_STATUS_YES]))
        {
            $this->settlement_status = self::SETTLEMENT_STATUS_NO;
        }
        //
        if(!in_array($this->statement_status, [self::STATEMENT_STATUS_NO, self::STATEMENT_STATUS_YES]))
        {
            $this->statement_status = self::STATEMENT_STATUS_NO;
        }

        return parent::beforeSave($insert);
    }

}
