<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

declare(strict_types=1);

namespace app\common\service\generator\core;

use app\common\service\generator\core\BaseGenerator;
use app\common\service\generator\core\GenerateInterface;
use think\helper\Str;

/**
 * vue-api生成器
 * Class VueApiGenerator
 * @package app\common\service\generator\core
 */
class VueApiGenerator extends BaseGenerator implements GenerateInterface
{

    /**
     * @notes 替换变量
     * @return mixed|void
     * @author 兔兔答题
     * @date 2022/6/22 18:19
     */
    public function replaceVariables()
    {
        // 需要替换的变量
        $needReplace = [
            '{COMMENT}',
            '{UPPER_CAMEL_NAME}',
            '{ROUTE}'
        ];

        // 等待替换的内容
        $waitReplace = [
            $this->getCommentContent(),
            $this->getUpperCamelName(),
            $this->getRouteContent(),
        ];

        $templatePath = $this->getTemplatePath('vue/api');

        // 替换内容
        $content = $this->replaceFileData($needReplace, $waitReplace, $templatePath);

        $this->setContent($content);
    }


    /**
     * @notes 描述
     * @return mixed
     * @author 兔兔答题
     * @date 2022/6/22 18:19
     */
    public function getCommentContent()
    {
        return $this->tableData['table_comment'];
    }


    /**
     * @notes 路由名称
     * @return array|string|string[]
     * @author 兔兔答题
     * @date 2022/6/22 18:19
     */
    public function getRouteContent()
    {
        $content = $this->getTableName();
        if (!empty($this->classDir)) {
            $content = $this->classDir . '.' . $this->getTableName();
        }
        return Str::lower($content);
    }


    /**
     * @notes 获取文件生成到模块的文件夹路径
     * @return mixed|void
     * @author 兔兔答题
     * @date 2022/6/22 18:19
     */
    public function getModuleGenerateDir()
    {
        $dir = dirname(app()->getRootPath()) . '/admin/src/api/';
        $this->checkDir($dir);
        return $dir;
    }


    /**
     * @notes 获取文件生成到runtime的文件夹路径
     * @return string
     * @author 兔兔答题
     * @date 2022/6/22 18:20
     */
    public function getRuntimeGenerateDir()
    {
        $dir = $this->generatorDir . 'vue/src/api/';
        $this->checkDir($dir);
        return $dir;
    }


    /**
     * @notes 生成的文件名
     * @return string
     * @author 兔兔答题
     * @date 2022/6/22 18:20
     */
    public function getGenerateName()
    {
        return $this->getLowerTableName() . '.ts';
    }


    /**
     * @notes 文件信息
     * @return array
     * @author 兔兔答题
     * @date 2022/6/23 15:57
     */
    public function fileInfo(): array
    {
        return [
            'name' => $this->getGenerateName(),
            'type' => 'ts',
            'content' => $this->content
        ];
    }


}