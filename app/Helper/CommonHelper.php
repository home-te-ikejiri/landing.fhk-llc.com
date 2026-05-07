<?php
// 全システムで使える共通ヘルパーを置く
use Illuminate\Support\Str;

// 数字かチェックを行う。
// 数字（少数を含む）出ない場合は0を返す。
// CSVインポート時に利用
if (!function_exists('checkNumeric')) {
    function checkNumeric($val)
    {
        $ret = 0;
        if (is_numeric($val)) {
            $ret = $val;
        }
        return $ret;
    }
}

// null 空文字 '-'を判定し合致する場合、空文字に変換する
if (!function_exists('checkEnpty')) {
    function checkEnpty($val)
    {
        $ret = $val = trim($val);
        if (empty($val)) {
            $ret = '';
        }
        if ($val == '-') {
            $ret = '';
        }
        if ($val == '－') {
            $ret = '';
        }
        return $ret;
    }
}

// 日付ではない場合、nullを返す
if (!function_exists('checkDateTime')) {
    function checkDateTime($val, $format = 'Y-m-d')
    {
        $ret = null;
        $search = array('/', '-', '.');
        $replace = '-';
        $val =  str_replace($search, $replace, $val);
        $d = DateTime::createFromFormat($format, $val);
        if ($d && $d->format($format) == $val) {
            // 日付と判断
            $ret = $val;
        }
        return $ret;
    }
}

// YYYYMM形式で入力
if (!function_exists('checkYearMonth')) {
    function checkYearMonth($val)
    {
        $ret = null;
        if (preg_match('/^[0-9]{4}(0[1-9]|1[0-2])$/u', $val)) {
            $ret = $val;
        }
        return $ret;
    }
}


if (!function_exists('checkTime')) {
    function checkTime($val)
    {
        $ret = null;
        if (preg_match('|\d{2}\:\d{2}\:\d{2}|', $val)) {
            $ret = $val;
        }
        return $ret;
    }
}


if (!function_exists('calcAge')) {
    function calcAge($val)
    {
        $ret = 0;
        if (checkDateTime($val)) {
            $val = str_replace("/", "", $val);
            $today = date('Ymd');
            $ret =  floor(($today - $val) / 10000);
        }
        return $ret;
    }
}

if (!function_exists('dateTimeFormat')) {
    function dateTimeFormat($date, $format = "Y/m/d")
    {
        $ret = $date;
        if ($date) {
            $search = array('/', '.', '-');
            $date = str_replace($search, '-', $date);
            list($year, $month, $day) = explode('-', $date);

            if (checkdate($month, $day, $year) != false) {
                $date = new DateTime($date);
                $ret =  $date->format($format);
            }
        }
        return $ret;
    }
}

if (!function_exists('timeFormat')) {
    function timeFormat($time)
    {
        $time_array = explode(':', $time);
        if (count($time_array) == 3) {
            $ret = $time_array[0] . ':' . $time_array[1];
        } else {
            $ret = $time;
        }
        return $ret;
    }
}


if (!function_exists('calcTime')) {
    // 00:00
    // +1 / -1
    // second / minute/ hour
    function calcTime($val, $add, $unit = 'minute')
    {
        $ret = '';
        if (strpos($val, ':') !== false) {
            $target_day = date('Y-m-d') . ' ' . $val;
            $ret = date("H:i", strtotime($target_day . $add . " " . $unit));
        }
        return $ret;
    }
}

if (!function_exists('calcDate')) {
    // +1 / -1
    // date 指定しなければ現在日付　（yyyy-mm-dd） 
    // day / month/ year / week
    function calcDate($add, $date = null, $unit = 'day')
    {
        $ret = '';
        if ($date) {
            $ret = date("Y-m-d", strtotime($date . ' ' . $add . ' ' . $unit));
        } else {
            $ret = date("Y-m-d", strtotime(date('Y-m-d') . ' ' . $add . ' ' . $unit));
        }
        return $ret;
    }
}


if (!function_exists('isMobileOrPc')) {
    function isMobileOrPc($request): int
    {
        $user_agent =  $request->header('User-Agent');
        if ((strpos($user_agent, 'iPhone') !== false)
            || (strpos($user_agent, 'iPod') !== false)
            || (strpos($user_agent, 'Android') !== false)
        ) {
            return 4;
        } else {
            return 0;
        }
    }
}

if (!function_exists('changeYmdToDate')) {
    function changeYmdToDate($ymd)
    {
        $ret = '';
        if ($ymd) {
            $ret .= substr($ymd, 0, 4);
            $ret .= '-';
            $ret .= substr($ymd, 4, 2);
            $ret .= '-';
            $ret .= substr($ymd, 6, 2);
        }
        return $ret;
    }
}

if (!function_exists('changeYmdHisToDateTime')) {
    function changeYmdHisToDateTime($ymd)
    {
        $ret = '';
        if ($ymd) {
            $ret .= substr($ymd, 0, 4);
            $ret .= '-';
            $ret .= substr($ymd, 4, 2);
            $ret .= '-';
            $ret .= substr($ymd, 6, 2);
            $ret .= ' ';
            $ret .= substr($ymd, 8, 2);
            $ret .= ':';
            $ret .= substr($ymd, 10, 2);
            $ret .= ':';
            $ret .= substr($ymd, 12, 2);
        }
        return $ret;
    }
}

// start_dateとend_dateの日数を計算する
if (!function_exists('diffDate')) {
    function diffDate($start_date, $end_date)
    {
        $day1 = new DateTime($end_date);
        $day2 = new DateTime($start_date);

        $interval = $day1->diff($day2);

        $ret = (int)$interval->format('%a');

        return $ret;
    }
}

//　最後のスラッシュを削除する
// URLの最後に/があると正しく動作しないことがあるため。
if (!function_exists('delLastSlash')) {
    function delLastSlash($val)
    {
        $ret = $val;
        if (substr($val, -1) == '/') {
            $ret = substr($val, 0, -1);
        }
        return $ret;
    }
}

if (!function_exists('nn')) { // Natural numberの略
    // カンマ区切りの数字からカンマを取り除く
    function nn($val)
    {
        $ret = str_replace(',', '', $val);
        return $ret;
    }
}

if (!function_exists('getRandomString')) {
    // ランダムな文字列を生成する
    function getRandomString($length = 8)
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }
}

/**
 * 配列の中身がすべて空かどうかを判定する
 */
if (!function_exists('empty_arr')) {
    function empty_arr($x) {
        return is_array($x) ? count(array_filter($x)) == 0 : empty($x);
    }
}

if (!function_exists('purify')) {
    /**
     * HTMLPurifierを使用してHTMLを無害化する
     */
    function purify($content)
    {
        $config = \HTMLPurifier_HTML5Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('Core.Language', 'ja');

        // 画像許可
        $config->set('URI.AllowedSchemes',array('data' => true,'http' => true,'https' => true,'mailto' => true));

        // YouTube許可
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '%^https?://www\.youtube\.com/embed/%');

        // target="_blank" が使えるようにする
        $config->set('HTML.TargetBlank', true);
        // id属性を許可する
        $config->set('Attr.EnableID', true);


        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($content);
    }
}
