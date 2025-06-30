<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\validate\config;


use app\common\validate\BaseValidate;


/**
 * 轮播图管理验证器
 * Class TenantBannerValidate
 * @package app\platform\validate\config
 */
class TenantBannerValidate extends BaseValidate
{

    /**
     * 设置校验规则
     * @var string[]
     */
    protected $rule = [
        'id'         => 'require',
        'is_show'    => 'require',
        'sort'       => 'require',
        'position'   => 'require',
        'client'     => 'require',
        'image_type' => 'require',
    ];


    /**
     * 参数描述
     * @var string[]
     */
    protected $field = [
        'id'         => 'id',
        'is_show'    => '显示状态',
        'sort'       => '显示权重',
        'position'   => '显示位置',
        'client'     => '显示平台',
        'title'      => '图片',
        'image_type' => '图片类型'
    ];


    /**
     * @notes 添加场景
     * @return TenantBannerValidate
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function sceneAdd()
    {
        return $this->only(['is_show', 'sort', 'position', 'client', 'image_type']);
    }


    /**
     * @notes 编辑场景
     * @return TenantBannerValidate
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function sceneEdit()
    {
        return $this->only(['id', 'is_show', 'sort', 'position', 'client', 'image_type']);
    }


    /**
     * @notes 删除场景
     * @return TenantBannerValidate
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function sceneDelete()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 详情场景
     * @return TenantBannerValidate
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function sceneDetail()
    {
        return $this->only(['id']);
    }

}