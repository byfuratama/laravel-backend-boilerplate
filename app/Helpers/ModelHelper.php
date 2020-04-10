<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Str;

define('STORING_AS_IS',0);
define('STORING_UPPERCASE',1);
define('STORING_LOWERCASE',2);

trait ModelHelper {

    protected static $storing_format = STORING_LOWERCASE;
    protected static $bcrypted_fields = ['password'];
    protected static $pagination_per_page = 15;
    public $error;

    private function convertEachRequest($str) {
        $format = static::$storing_format;
        if ($format == STORING_LOWERCASE) {
            return Str::lower($str);
        }
        if ($format == STORING_UPPERCASE) {
            return Str::upper($str);
        }
        return $str;
    }

    public static function record($request, $id = null) {
        $data = $id ? self::find($id) : new self();

        if (!$data) {
            return null;
        }

        if ($request instanceof \Illuminate\Http\Request) {
            $req = $request->all();
        } elseif (is_object($request)) {
            $req = (array) $request;
        } elseif (is_array($request)) {
            $req = $request;
        } else {
            $req = json_decode($req);
        }

        foreach ($req as $key => $val) {
            if (in_array($key,static::$bcrypted_fields)) {
                $val = bcrypt($val);
            }
            $req[$key] = $data->convertEachRequest($val);
        }

        $data->fill($req);
        try {
            $data->save();
        } catch (Exception $ex) {
            $data->error = $ex->errorInfo;
        }

        return $data;
    }

    public static function fetch() {
        $order_by = request('order_by',[]);
        $per_page = request('per_page', static::$pagination_per_page);

        $data = \App\Models\Kategori::select('*');
        if (count($order_by) == 0) {
            $data = $data->latest();
        } else {
            foreach ($order_by as $by => $dir) {
                $data = $data->orderBy($by, $dir ?? 'DESC');
            }
        }

        $extras = collect(['order_by' => $order_by]);
        $data = $data->paginate($per_page);
        $data = $extras->merge($data);
        
        return $data;
        
    }

    public static function fetchById($id) {
        return self::find($id);
    }

    public static function removeById($id) {
        $data = static::fetchById($id);
        if ($data) {
            return $data->delete();
        }
        return $data;
    }
}