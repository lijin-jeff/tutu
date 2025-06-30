<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\model\article;

use app\common\model\article\Article;
use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 资讯分类管理模型
 * Class ArticleCate
 * @package app\common\model\article;
 */
class ArticleCate extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';


    /**
     * @notes 关联文章
     * @return \think\model\relation\HasMany
     * @author 兔兔答题
     * @date 2022/10/19 16:59
     */
    public function article()
    {
        return $this->hasMany(Article::class, 'cid', 'id');
    }


    /**
     * @notes 状态描述
     * @param $value
     * @param $data
     * @return string
     * @author 兔兔答题
     * @date 2022/9/15 11:25
     */
    public function getIsShowDescAttr($value, $data)
    {
        return $data['is_show'] ? '启用' : '停用';
    }


    /**
     * @notes 文章数量
     * @param $value
     * @param $data
     * @return int
     * @author 兔兔答题
     * @date 2022/9/15 11:32
     */
    public function getArticleCountAttr($value, $data)
    {
        return Article::where(['cid' => $data['id']])->count('id');
    }




}