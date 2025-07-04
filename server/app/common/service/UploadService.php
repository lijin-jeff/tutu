<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\service;


use app\common\enum\AdminTerminalEnum;
use app\common\enum\FileEnum;
use app\common\model\file\File;
use app\common\model\file\TenantFile;
use app\common\service\storage\Driver as StorageDriver;
use Exception;


class UploadService
{

    /**
     * @notes 上传图片
     * @param $cid
     * @param int $user_id
     * @param string $saveDir
     * @return array
     * @throws Exception
     * @author 兔兔答题
     * @date 2021/12/29 16:30
     */
    public static function image($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/images')
    {
        try {
            // 租户端文件配置默认获取平台端
            $config = self::getUploadFileConfig();
            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_image'))) {
                throw new Exception("上传图片不允许上传". $fileInfo['ext'] . "文件");
            }

            // 上传文件
            $saveDir = self::getUploadUrl($saveDir);
            if (!$StorageDriver->upload($saveDir)) {
                throw new Exception($StorageDriver->getError());
            }

            // 3、处理文件名称
            if (strlen($fileInfo['name']) > 128) {
                $name = substr($fileInfo['name'], 0, 123);
                $nameEnd = substr($fileInfo['name'], strlen($fileInfo['name'])-5, strlen($fileInfo['name']));
                $fileInfo['name'] = $name . $nameEnd;
            }

            // 4、写入数据库中
            $file = (AdminTerminalEnum::isPlatform() ? new File() : new TenantFile())->create([
                'cid'         => $cid,
                'type'        => FileEnum::IMAGE_TYPE,
                'name'        => $fileInfo['name'],
                'uri'         => $saveDir . '/' . str_replace("\\","/", $fileName),
                'source'      => $source,
                'source_id'   => $sourceId,
                'create_time' => time(),
            ]);

            // 5、返回结果
            return [
                'id'   => $file['id'],
                'cid'  => $file['cid'],
                'type' => $file['type'],
                'name' => $file['name'],
                'uri'  => FileService::getFileUrl($file['uri']),
                'url'  => $file['uri']
            ];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     * @notes 视频上传
     * @param $cid
     * @param int $user_id
     * @param string $saveDir
     * @return array
     * @throws Exception
     * @author 兔兔答题
     * @date 2021/12/29 16:32
     */
    public static function video($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/video')
    {
        try {
            // 租户端文件配置默认获取平台端
            $config = self::getUploadFileConfig();

            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_video'))) {
                throw new Exception("上传视频不允许上传". $fileInfo['ext'] . "文件");
            }

            // 上传文件
            $saveDir = self::getUploadUrl($saveDir);
            if (!$StorageDriver->upload($saveDir)) {
                throw new Exception($StorageDriver->getError());
            }

            // 3、处理文件名称
            if (strlen($fileInfo['name']) > 128) {
                $name = substr($fileInfo['name'], 0, 123);
                $nameEnd = substr($fileInfo['name'], strlen($fileInfo['name'])-5, strlen($fileInfo['name']));
                $fileInfo['name'] = $name . $nameEnd;
            }

            // 4、写入数据库中
            $file = (AdminTerminalEnum::isPlatform() ? new File() : new TenantFile())->create([
                'cid'         => $cid,
                'type'        => FileEnum::VIDEO_TYPE,
                'name'        => $fileInfo['name'],
                'uri'         => $saveDir . '/' . str_replace("\\","/", $fileName),
                'source'      => $source,
                'source_id'   => $sourceId,
                'create_time' => time(),
            ]);

            // 5、返回结果
            return [
                'id'   => $file['id'],
                'cid'  => $file['cid'],
                'type' => $file['type'],
                'name' => $file['name'],
                'uri'  => FileService::getFileUrl($file['uri']),
                'url'  => $file['uri']
            ];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @notes 上传文件
     * @param $cid
     * @param int $sourceId
     * @param int $source
     * @param string $saveDir
     * @return array
     * @throws Exception
     * @author dw
     * @date 2023/06/26
     */
    public static function file($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/file')
    {
        try {
            // 租户端文件配置默认获取平台端
            $config = self::getUploadFileConfig();

            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_file'))) {
                throw new Exception("上传文件不允许上传" . $fileInfo['ext'] . "文件");
            }

            // 上传文件
            $saveDir = self::getUploadUrl($saveDir);
            if (!$StorageDriver->upload($saveDir)) {
                throw new Exception($StorageDriver->getError());
            }

            // 3、处理文件名称
            if (strlen($fileInfo['name']) > 128) {
                $name = substr($fileInfo['name'], 0, 123);
                $nameEnd = substr($fileInfo['name'], strlen($fileInfo['name']) - 5, strlen($fileInfo['name']));
                $fileInfo['name'] = $name . $nameEnd;
            }

            // 4、写入数据库中
            $file = (AdminTerminalEnum::isPlatform() ? new File() : new TenantFile())->create([
                'cid'         => $cid,
                'type'        => FileEnum::FILE_TYPE,
                'name'        => $fileInfo['name'],
                'uri'         => $saveDir . '/' . str_replace("\\", "/", $fileName),
                'source'      => $source,
                'source_id'   => $sourceId,
                'create_time' => time(),
            ]);

            // 5、返回结果
            return [
                'id'   => $file['id'],
                'cid'  => $file['cid'],
                'type' => $file['type'],
                'name' => $file['name'],
                'uri'  => FileService::getFileUrl($file['uri']),
                'url'  => $file['uri']
            ];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @notes 上传地址
     * @param $saveDir
     * @return string
     * @author dw
     * @date 2023/06/26
     */
    private static function getUploadUrl($saveDir):string
    {
        return $saveDir . '/' . date('Ymd');
    }


    /**
     * @notes 获取文件上传存储配置
     * @return array
     * @author yfdong
     * @date 2024/09/15 19:37
     */
    private static function getUploadFileConfig()
    {
        // 默认开启的存储配置
        $inUse = ConfigService::get('storage', 'default', 'local');
        $config = [
            'default' => $inUse,
            'engine' => 'local' === $inUse ? ['local' => []] : [$inUse => ConfigService::get('storage', $inUse)],
        ];
        return $config;
    }

}
