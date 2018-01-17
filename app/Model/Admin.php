<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * 关联到模型的数据表
     * 默认规则是模型类名的复数作为与其对应的表名
     * @var string
     */
    protected $table = 'admin';

    public $primaryKey = 'adid';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    //protected $dateFormat = 'U';

    /**
     * 避免转换时间戳为时间字符串
     *
     * @param DateTime|int $value
     * @return DateTime|int
     */
    public function fromDateTime($value) {
        return strtotime(parent::fromDateTime($value));
    }

    //自定义用于存储时间戳的字段名称，可以在模型中设置 CREATED_AT 和 UPDATED_AT 常量：
    //const CREATED_AT = 'regtime';
    //const UPDATED_AT = '';

    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
    public function getDateFormat() {
        return 'U';
    }

    //批量赋值白名单($fillable)   黑名单(guarded)    create
    protected $guarded = [];
}
