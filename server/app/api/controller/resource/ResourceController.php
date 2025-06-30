<?php
// +----------------------------------------------------------------------
// | 兔兔答题开发团队介绍
// +----------------------------------------------------------------------
// | 欢迎你使用本套系统，本套系统由兔兔答题开发团队全力开发。
// | 如果本套系统是商业系统，请严格遵守系统使用相关协议，出现违背协议的法律行为，所有违法行为均与兔兔答题无关。
// | 官网地址：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | 作者: 兔兔答题开发团队
// +----------------------------------------------------------------------
namespace app\api\controller\resource;

use app\api\controller\BaseApiController;
use app\api\logic\resource\ResourceLogic;
use app\api\validate\CommonValidate;

class ResourceController extends BaseApiController
{
    public array $notNeedLogin = ['categoryList', 'resourceContent', 'resourceList'];

    /**
     * 资源分类树
     * @return \think\response\Json
     */
    public function categoryList(): \think\response\Json
    {
        return $this->success('分类查询成功', ResourceLogic::categoryList());
    }

    /**
     * 资源列表
     * @email tutudati@outlook.com
     * @link https://www.tutudati.com
     * @author 兔兔答题
     * @return \think\response\Json
     */
    public function resourceList(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->success('资源查询成功', ResourceLogic::resourceList($this->requestParams));
    }

    /**
     * 资源详情
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function resourceContent(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('uid');
        return $this->success('资源查询成功', ResourceLogic::resourceContent($this->requestParams));
    }

    /**
     * 资源下载
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function resourceDownload(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('uid');
        return $this->success('资源查询成功', ResourceLogic::resourceDownload($this->requestParams));
    }

    /**
     * 资源收藏
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function resourceCollection(): \think\response\Json
    {
        (new CommonValidate())->post()->goCheck('uid');
        if (ResourceLogic::resourceCollection($this->requestParams)) {
            return $this->success('收藏成功');
        }
        return $this->fail(ResourceLogic::getError());
    }
}