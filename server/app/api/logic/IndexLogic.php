<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\logic;


use app\common\logic\BaseLogic;
use app\common\model\article\Article;
use app\common\model\decorate\DecoratePage;
use app\common\model\decorate\DecorateTabbar;
use app\common\service\ConfigService;
use app\common\service\FileService;
use think\facade\Db;


/**
 * index
 * Class IndexLogic
 * @package app\api\logic
 */
class IndexLogic extends BaseLogic
{

    /**
     * @notes 首页数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/21 19:15
     */
    public static function getIndexData()
    {
        // 装修配置
        $decoratePage = DecoratePage::where(['type' => 1])->findOrEmpty();

        // 首页文章
        $field = [
            'id', 'title', 'desc', 'abstract', 'image',
            'author', 'click_actual', 'click_virtual', 'create_time'
        ];

        $article = Article::field($field)
            ->where(['is_show' => 1])
            ->order(['id' => 'desc'])
            ->limit(20)->append(['click'])
            ->hidden(['click_actual', 'click_virtual'])
            ->select()->toArray();

        return [
            'page'    => $decoratePage,
            'article' => $article
        ];
    }


    /**
     * @notes 获取政策协议
     * @param string $type
     * @return array
     * @author 兔兔答题
     * @date 2022/9/20 20:00
     */
    public static function getPolicyByType(string $type): array
    {
        $content = [
            'title'   => ConfigService::get('agreement', $type . '_title', ''),
            'content' => ConfigService::get('agreement', $type . '_content', ''),
        ];
        if (!empty($content['content'])) {
            $content['content'] = get_file_domain($content['content']);
        }
        return $content;
    }


    /**
     * @notes 装修信息
     * @param $id
     * @return array
     * @author 兔兔答题
     * @date 2022/9/21 18:37
     */
    public static function getDecorate($type): array
    {
        return DecoratePage::where(['type' => $type])->field(['type', 'name', 'data', 'meta'])
            ->findOrEmpty()->toArray();
    }


    /**
     * @notes 获取配置
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/21 19:38
     */
    public static function getConfigData(): array
    {
        // 底部导航
        $tabbar = DecorateTabbar::getTabbarLists();
        // 导航颜色
        $style = ConfigService::get('tabbar', 'style', config('project.decorate.tabbar_style'));
        // 登录配置
        $loginConfig = [
            // 登录方式
            'login_way'       => ConfigService::get('login', 'login_way', config('project.login.login_way')),
            // 注册强制绑定手机
            'coerce_mobile'   => ConfigService::get('login', 'coerce_mobile', config('project.login.coerce_mobile')),
            // 政策协议
            'login_agreement' => ConfigService::get('login', 'login_agreement', config('project.login.login_agreement')),
            // 第三方登录 开关
            'third_auth'      => ConfigService::get('login', 'third_auth', config('project.login.third_auth')),
            // 微信授权登录
            'wechat_auth'     => ConfigService::get('login', 'wechat_auth', config('project.login.wechat_auth')),
            // qq授权登录
            'qq_auth'         => ConfigService::get('login', 'qq_auth', config('project.login.qq_auth')),
        ];
        // 网址信息
        $website = [
            'h5_favicon' => FileService::getFileUrl(ConfigService::get('website', 'h5_favicon')),
            'shop_name'  => ConfigService::get('website', 'shop_name'),
            'shop_logo'  => FileService::getFileUrl(ConfigService::get('website', 'shop_logo')),
        ];
        // H5配置
        $webPage = [
            // 渠道状态 0-关闭 1-开启
            'status'      => ConfigService::get('web_page', 'status', 1),
            // 关闭后渠道后访问页面 0-空页面 1-自定义链接
            'page_status' => ConfigService::get('web_page', 'page_status', 0),
            // 自定义链接
            'page_url'    => ConfigService::get('web_page', 'page_url', ''),
            'url'         => request()->domain() . '/mobile'
        ];

        // 备案信息
        $copyright = ConfigService::get('copyright', 'config', []);

        return [
            'domain'    => FileService::getFileUrl(),
            'style'     => $style,
            'tabbar'    => $tabbar,
            'login'     => $loginConfig,
            'website'   => $website,
            'webPage'   => $webPage,
            'version'   => config('project.version'),
            'copyright' => $copyright,
        ];
    }

    /**
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function dataQuery(array $params): array
    {
        $pageNo = (int)(isset($params['page_no']) ? $params['page_no'] : 1);
        $pageSize = (int)(isset($params['page_size']) ? $params['page_size'] : 20);
        $pageSize = min($pageSize, 20);
        $items = Db::name('data_search')
            ->where(function ($query) use ($params) {
                if (!empty($params['data_type'])) {
                    $query->whereRaw("data_type COLLATE utf8mb4_general_ci = ?", [$params['data_type']]);
                }
                if (!empty($params['title'])) {
                    $query->whereLike('title', '%' . $params['title'] . '%');
                }
            })->order('publish_time', 'desc')
            ->paginate([
                'list_rows' => $pageSize,
                'page'      => $pageNo
            ]);
        $dataArray = $items->items();
        foreach ($dataArray as &$value) {
            $value['publish_time'] = date("Y-m-d", $value['publish_time']);
            switch ($value['data_type']) {
                case 'article':
                    $value['data_type_title'] = '资讯文章';
                    break;
                case 'exam_library':
                    $value['data_type_title'] = '在线题库';
                    break;
                case 'resource':
                    $value['data_type_title'] = '资料文件';
                    break;
            }
        }
        return [
            'lists'     => $dataArray,
            'page_no'   => $items->currentPage(),
            'page_size' => $pageSize,
            'count'     => $items->total(),
            'extend'    => []
        ];
    }
}