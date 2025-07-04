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

use app\common\enum\YesNoEnum;
use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 资讯管理模型
 * Class Article
 * @package app\common\model\article;
 */
class Article extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    /**
     * @notes  获取分类名称
     * @param $value
     * @param $data
     * @return string
     * @author 兔兔答题
     * @date 2022/2/22 9:53
     */
    public function getCateNameAttr($value, $data): string
    {
        return ArticleCate::where('id', $data['cid'])->value('name');
    }

    /**
     * @notes 浏览量
     * @param $value
     * @param $data
     * @return mixed
     * @author 兔兔答题
     * @date 2022/9/15 11:33
     */
    public function getClickAttr($value, $data): mixed
    {
        return $data['click_actual'] + $data['click_virtual'];
    }


    /**
     * @notes 设置图片域名
     * @param $value
     * @param $data
     * @return array|string|string[]|null
     * @author 兔兔答题
     * @date 2022/9/28 10:17
     */
    public function getContentAttr($value, $data): array|string|null
    {
        return get_file_domain($value);
    }


    /**
     * @notes 清除图片域名
     * @param $value
     * @param $data
     * @return array|string|string[]
     * @author 兔兔答题
     * @date 2022/9/28 10:17
     */
    public function setContentAttr($value, $data): array|string
    {
        return clear_file_domain($value);
    }


    /**
     * @notes 获取文章详情
     * @param $id
     * @return array
     * @author 兔兔答题
     * @date 2022/10/20 15:23
     */
    public static function getArticleDetailArr(int $id): array
    {
        $article = Article::where(['id' => $id, 'is_show' => YesNoEnum::YES])
            ->field(['id', 'cid', 'title', 'desc', 'abstract', 'image', 'author', 'content', 'click_actual', 'click_virtual', 'create_time', 'desc'])
            ->findOrEmpty();
        if ($article->isEmpty()) {
            return [];
        }
        // 增加点击量
        $article->click_actual += 1;
        $article->save();

        return $article
            ->append(['click', 'cate_name'])
            ->hidden(['click_actual', 'click_virtual', 'update_time', 'tenant_id'])
            ->toArray();
    }


    /**
     * @notes 分表情况下软删除重写方法
     * @param $data
     * @param bool $force
     * @return bool
     * @throws \think\db\exception\DbException
     * @author yfdong
     * @date 2025/02/26 23:24
     */
    public static function destroy($data, bool $force = false): bool
    {
        return Article::query()->where('id', $data)->update(['delete_time' => time()]) > 0;
    }


}