<?php
// 应用公共文件
use app\common\service\FileService;
use think\helper\Str;

/**
 * @notes 生成密码加密密钥
 * @param string $plaintext
 * @param string $salt
 * @return string
 * @author 兔兔答题
 * @date 2021/12/28 18:24
 */
function create_password(string $plaintext, string $salt): string
{
    return md5($salt . md5($plaintext . $salt));
}


/**
 * 全局生成uid
 * @return string
 * @link https://www.tutudati.com
 * @email tutudati@outlook.com
 * @date 2025/4/1 02:30
 * @author 兔兔答题 <tutudati@outlook.com>
 */
function uid(): string
{
    return uniqid();
}


/**
 * 将整数分钟转换为时分秒格式
 * @param int $minutes 要转换的分钟数
 * @return string 转换后的时分秒格式字符串，格式为 H:i:s
 */
function minutesToHMS(int $minutes): string
{
    $hours = intdiv($minutes, 60);
    $remainingMinutes = $minutes % 60;
    $seconds = 0;

    return sprintf("%02d:%02d:%02d", $hours, $remainingMinutes, $seconds);
}

/**
 * 将秒数转换为时分秒格式
 * @param int $seconds 要转换的总秒数
 * @return string 格式化后的时分秒字符串，格式为 H:i:s
 */
function secondsToHMS(int $seconds): string
{
    $hours = intdiv($seconds, 3600);
    $remainingSeconds = $seconds % 3600;
    $minutes = intdiv($remainingSeconds, 60);
    $secs = $remainingSeconds % 60;

    return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
}

/**
 * @notes 随机生成token值
 * @param string $extra
 * @return string
 * @author 兔兔答题
 * @date 2021/12/28 18:24
 */
function create_token(string $extra = ''): string
{
    $salt        = env('project.unique_identification', '兔兔答题');
    $encryptSalt = md5($salt . uniqid());
    return md5($salt . $extra . time() . $encryptSalt);
}


/**
 * @notes 截取某字符字符串
 * @param $str
 * @param string $symbol
 * @return string
 * @author 兔兔答题
 * @date 2021/12/28 18:24
 */
function substr_symbol_behind($str, $symbol = '.'): string
{
    $result = strripos($str, $symbol);
    if ($result === false) {
        return $str;
    }
    return substr($str, $result + 1);
}


/**
 * @notes 对比php版本
 * @param string $version
 * @return bool
 * @author 兔兔答题
 * @date 2021/12/28 18:27
 */
function compare_php(string $version): bool
{
    return version_compare(PHP_VERSION, $version) >= 0 ? true : false;
}


/**
 * @notes 检查文件是否可写
 * @param string $dir
 * @return bool
 * @author 兔兔答题
 * @date 2021/12/28 18:27
 */
function check_dir_write(string $dir = ''): bool
{
    $route = root_path() . '/' . $dir;
    return is_writable($route);
}


/**
 * 多级线性结构排序
 * 转换前：
 * [{"id":1,"pid":0,"name":"a"},{"id":2,"pid":0,"name":"b"},{"id":3,"pid":1,"name":"c"},
 * {"id":4,"pid":2,"name":"d"},{"id":5,"pid":4,"name":"e"},{"id":6,"pid":5,"name":"f"},
 * {"id":7,"pid":3,"name":"g"}]
 * 转换后：
 * [{"id":1,"pid":0,"name":"a","level":1},{"id":3,"pid":1,"name":"c","level":2},{"id":7,"pid":3,"name":"g","level":3},
 * {"id":2,"pid":0,"name":"b","level":1},{"id":4,"pid":2,"name":"d","level":2},{"id":5,"pid":4,"name":"e","level":3},
 * {"id":6,"pid":5,"name":"f","level":4}]
 * @param array $data 线性结构数组
 * @param string $symbol 名称前面加符号
 * @param string $name 名称
 * @param string $id_name 数组id名
 * @param string $parent_id_name 数组祖先id名
 * @param int $level 此值请勿给参数
 * @param int $parent_id 此值请勿给参数
 * @return array
 */
function linear_to_tree($data, $sub_key_name = 'sub', $id_name = 'id', $parent_id_name = 'pid', $parent_id = 0)
{
    $tree = [];
    foreach ($data as $row) {
        if ($row[$parent_id_name] == $parent_id) {
            $temp  = $row;
            $child = linear_to_tree($data, $sub_key_name, $id_name, $parent_id_name, $row[$id_name]);
            if ($child) {
                $temp[$sub_key_name] = $child;
            }
            $tree[] = $temp;
        }
    }
    return $tree;
}


/**
 * @notes 删除目标目录
 * @param $path
 * @param $delDir
 * @return bool|void
 * @author 兔兔答题
 * @date 2022/4/8 16:30
 */
function del_target_dir($path, $delDir)
{
    //没找到，不处理
    if (!file_exists($path)) {
        return false;
    }

    //打开目录句柄
    $handle = opendir($path);
    if ($handle) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$path/$item")) {
                    del_target_dir("$path/$item", $delDir);
                } else {
                    unlink("$path/$item");
                }
            }
        }
        closedir($handle);
        if ($delDir) {
            return rmdir($path);
        }
    } else {
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }
}


/**
 * @notes 下载文件
 * @param $url
 * @param $saveDir
 * @param $fileName
 * @return string
 * @author 兔兔答题
 * @date 2022/9/16 9:53
 */
function download_file($url, $saveDir, $fileName)
{
    if (!file_exists($saveDir)) {
        mkdir($saveDir, 0775, true);
    }
    $fileSrc = $saveDir . $fileName;
    file_exists($fileSrc) && unlink($fileSrc);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);
    $resource = fopen($fileSrc, 'a');
    fwrite($resource, $file);
    fclose($resource);
    if (filesize($fileSrc) == 0) {
        unlink($fileSrc);
        return '';
    }
    return $fileSrc;
}


/**
 * @notes 去除内容图片域名
 * @param $content
 * @return array|string|string[]
 * @author 兔兔答题
 * @date 2022/9/26 10:43
 */
function clear_file_domain($content)
{
    $fileUrl = FileService::getFileUrl();
    $pattern = '/<img[^>]*\bsrc=["\']' . preg_quote($fileUrl, '/') . '([^"\']+)["\']/i';
    return preg_replace($pattern, '<img src="$1"', $content);
}

/**
 * @notes 设置内容图片域名
 * @param $content
 * @return array|string|string[]|null
 * @author 兔兔答题
 * @date 2024/2/5 16:36
 */
function get_file_domain($content)
{
    $fileUrl   = FileService::getFileUrl();
    $imgPreg   = '/(<img .*?src=")(?!https?:\/\/)([^"]*)(".*?>)/is';
    $videoPreg = '/(<video .*?src=")(?!https?:\/\/)([^"]*)(".*?>)/is';
    $content   = preg_replace($imgPreg, "\${1}$fileUrl\${2}\${3}", $content);
    $content   = preg_replace($videoPreg, "\${1}$fileUrl\${2}\${3}", $content);
    return $content;
}

/**
 * @notes uri小写
 * @param $data
 * @return array|string[]
 * @author 兔兔答题
 * @date 2022/7/19 14:50
 */
function lower_uri($data)
{
    if (!is_array($data)) {
        $data = [$data];
    }
    return array_map(function ($item) {
        return strtolower(Str::camel($item));
    }, $data);
}


/**
 * @notes 获取无前缀数据表名
 * @param $tableName
 * @return mixed|string
 * @author 兔兔答题
 * @date 2022/12/12 15:23
 */
function get_no_prefix_table_name($tableName)
{
    $tablePrefix = config('database.connections.mysql.prefix');
    $prefixIndex = strpos($tableName, $tablePrefix);
    if ($prefixIndex !== 0 || $prefixIndex === false) {
        return $tableName;
    }
    $tableName = substr_replace($tableName, '', 0, strlen($tablePrefix));
    return trim($tableName);
}


/**
 * @notes 生成编码
 * @param $table
 * @param $field
 * @param string $prefix
 * @param int $randSuffixLength
 * @param array $pool
 * @return string
 * @author 兔兔答题
 * @date 2023/2/23 11:35
 */
function generate_sn($table, $field, $prefix = '', $randSuffixLength = 4, $pool = []): string
{
    $suffix = '';
    for ($i = 0; $i < $randSuffixLength; $i++) {
        if (empty($pool)) {
            $suffix .= rand(0, 9);
        } else {
            $suffix .= $pool[array_rand($pool)];
        }
    }
    $sn = $prefix . date('YmdHis') . $suffix;
    if (app()->make($table)->where($field, $sn)->find()) {
        return generate_sn($table, $field, $prefix, $randSuffixLength, $pool);
    }
    return $sn;
}


/**
 * @notes 格式化金额
 * @param $float
 * @return int|mixed|string
 * @author 兔兔答题
 * @date 2023/2/24 11:20
 */
function format_amount($float)
{
    if ($float == intval($float)) {
        return intval($float);
    } elseif ($float == sprintf('%.1f', $float)) {
        return sprintf('%.1f', $float);
    }
    return $float;
}

/**
 * @notes 版本信息
 * @return array
 * @author yfdong
 * @date 2024/11/14 22:12
 */
function local_version(): mixed
{
    if (!file_exists('./upgrade/')) {
        // 若文件夹不存在，先创建文件夹
        mkdir('./upgrade/', 0777, true);
    }
    if (!file_exists('./upgrade/version.json')) {
        // 获取本地版本号
        $version = config('project.version');
        $data    = ['version' => $version];
        $src     = './upgrade/version.json';
        // 新建文件
        file_put_contents($src, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    $json_string = file_get_contents('./upgrade/version.json');
    // 用参数true把JSON字符串强制转成PHP数组
    return json_decode($json_string, true);
}


/**
 * @notes 解压缩
 * @param $file
 * @param $save_dir
 * @return bool
 * @author yfdong
 * @date 2024/11/14 22:31
 */
function unzip($file, $save_dir): bool
{
    if (!file_exists($file)) {
        return false;
    }
    $zip = new ZipArchive();
    if ($zip->open($file) !== TRUE) {//中文文件名要使用ANSI编码的文件格式
        return false;
    }
    $zip->extractTo($save_dir);
    $zip->close();
    return true;
}


/**
 * @notes 遍历指定目录下的文件(目标目录,排除文件)
 * @param mixed $dir (目标文件)
 * @param string $exclude_file (要排除的文件)
 * @param string $target_suffix (指定后缀)
 * @return array|false
 * @author 兔兔答题
 * @date 2021/8/14 14:44
 */
function get_scanDir(mixed $dir, string $exclude_file = '', string $target_suffix = ''): bool|array
{
    if (!file_exists($dir) || empty(trim($dir))) {
        return [];
    }

    $files = scandir($dir);
    $res   = [];
    foreach ($files as $item) {
        if ($item == "." || $item == ".." || $item == $exclude_file) {
            continue;
        }
        if (!empty($target_suffix)) {
            if (get_extension($item) == $target_suffix) {
                $res[] = $item;
            }
        } else {
            $res[] = $item;
        }
    }

    if (empty($item)) {
        return false;
    }
    return $res;
}


/**
 * @notes 获取文件扩展名
 * @param $file
 * @return array|string
 * @author 兔兔答题
 * @date 2021/8/14 15:24
 */
function get_extension($file): array|string
{
    return pathinfo($file, PATHINFO_EXTENSION);
}
