<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
declare (strict_types=1);

namespace app\tenantapi\validate\resource;


use app\common\validate\BaseValidate;


/**
 * 资源管理验证器
 * Class TenantResourceValidate
 * @package app\platform\validate\resource
 */
class TenantResourceValidate extends BaseValidate
{

    /**
     * 设置校验规则
     * @var string[]
     */
    protected $rule = [
        'id'           => 'require',
        'title'        => 'require',
        'is_show'      => 'require',
        'sort'         => 'require',
        'image'        => 'require',
        'remark'       => 'require',
        'category_uid' => 'require',
        'author'       => 'require',
        'free_state'   => 'require',
        'year'         => 'require',
        'file_url'     => 'require'
    ];


    /**
     * 参数描述
     * @var string[]
     */
    protected $field = [
        'id'           => 'id',
        'title'        => '资源名称',
        'is_show'      => '上架装',
        'sort'         => '显示权重',
        'image'        => '资源封面',
        'remark'       => '资源描述',
        'category_uid' => '资源分类',
        'author'       => '资源作者',
        'free_state'   => '付费状态',
        'year'         => '资源年份',
        'file_url'     => '附件资源',
    ];


    /**
     * @notes 添加场景
     * @return TenantResourceValidate
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function sceneAdd(): TenantResourceValidate
    {
        return $this->only(['title', 'is_show', 'sort', 'image', 'remark', 'category_uid', 'author', 'free_state', 'year', 'file_url']);
    }


    /**
     * @notes 编辑场景
     * @return TenantResourceValidate
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function sceneEdit(): TenantResourceValidate
    {
        return $this->only(['id', 'title', 'is_show', 'sort', 'image', 'remark', 'category_uid', 'author', 'free_state', 'year', 'file_url']);
    }


    /**
     * @notes 删除场景
     * @return TenantResourceValidate
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function sceneDelete(): TenantResourceValidate
    {
        return $this->only(['id']);
    }


    /**
     * @notes 详情场景
     * @return TenantResourceValidate
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function sceneDetail(): TenantResourceValidate
    {
        return $this->only(['id']);
    }

}