<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\api\controller\exam;

use app\api\controller\BaseApiController;
use app\api\lists\exam\QuestionlibLists;
use app\api\logic\exam\QuestionlibLogic;
use app\api\validate\CommonValidate;
use app\api\validate\exam\QuestionValidate;

class QuestionlibController extends BaseApiController
{
    public array $notNeedLogin = ['recommendList', 'questionList', 'hotList'];

    /**
     * 推荐题库
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:02
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function recommendList(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->dataLists(new QuestionlibLists());
    }

    /**
     * 热门题库
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:02
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function hotList(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->dataLists(new QuestionlibLists());
    }

    /**
     * 题库列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:57
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function questionList(): \think\response\Json
    {
        return $this->dataLists(new QuestionlibLists());
    }

    /**
     * 题库详情
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 01:28
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function questionDetail(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('题库详情获取成功', QuestionlibLogic::questionLibDetail($this->request->all()));
    }

    /**
     * 题库菜单配置
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 01:50
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function questionMenu(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('题库菜单获取成功', QuestionlibLogic::questionMenu($this->request->all()));
    }

    /**
     * 随机练习试题列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:26
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function randOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('rand');
        return $this->success('试题获取成功', QuestionlibLogic::randOptionList($this->request->all()));
    }

    /**
     * 顺序练习试题列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:26
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function orderOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('order');
        return $this->success('试题获取成功', QuestionlibLogic::orderOptionList($this->request->all()));
    }

    /**
     * 试题搜索列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:26
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function searchOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('试题获取成功', QuestionlibLogic::searchOptionList($this->requestParams));
    }

    /**
     * 章节练习试题列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:26
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function chapterOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('chapter');
        return $this->success('试题获取成功', QuestionlibLogic::chapterOptionList($this->request->all()));
    }

    /**
     * 题型练习试题列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:26
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function typeOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('试题获取成功', QuestionlibLogic::typeOptionList($this->request->all()));
    }

    /**
     * 题库类型
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 02:13
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function questionTypeList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('题库类型查询成功', QuestionlibLogic::questionTypeList($this->request->all()));
    }

    /**
     * 试题章节
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 03:17
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function chapterList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('章节查询成功', QuestionlibLogic::chapterList($this->request->all()));
    }

    /**
     * 题库试题收藏
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function questionCollection(): \think\response\Json
    {
        (new QuestionValidate())->post()->goCheck('collection');
        if (QuestionlibLogic::questionCollection($this->requestParams)) {
            return $this->success('操作成功');
        }
        return $this->fail(QuestionlibLogic::getError());
    }

    /**
     * 收藏试题列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function collectionOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('收藏试题查询成功', QuestionlibLogic::collectionOptionList($this->requestParams));
    }

    /**
     * 错题历史记录
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function errorOptionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('试题查询成功', QuestionlibLogic::errorOptionList($this->requestParams));
    }

    /**
     * 题库错题移除
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function questionErrorRemove(): \think\response\Json
    {
        (new QuestionValidate())->post()->goCheck('error');
        if (QuestionlibLogic::questionRemoveError($this->requestParams)) {
            return $this->success('操作成功');
        }
        return $this->fail(QuestionlibLogic::getError());
    }

    /**
     * 试卷试题列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function examinationQuestionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('试题列表查询成功', QuestionlibLogic::examinationQuestionList($this->requestParams));
    }
}