<?php

namespace App;

class MM
{

    private $tableName = '';
    private $fields = [];
    private static $list = [];
    public $softDeletes = false;

    public function __construct($table)
    {
        $this->tableName = $table;
        self::$list[] = $this;
    }

    public function field($name, $type, ...$extras)
    {
        $this->fieldRaw($type, $name, ...$extras);
    }

    public function fieldSingle($type)
    {
        $this->fieldRaw($type);
    }

    public function fieldRaw($type, $name = null, ...$extras)
    {
        if (!$name)
            $name = $type;
        if ($type == 'softDeletes') {
            $this->softDeletes = true;
        }
        $this->fields[$name] = [
            "type" => $type,
            "extras" => $extras
        ];
    }

    public function toMigration()
    {
        $str = '';
        foreach ($this->fields as $key => $value) {
            $str .= '$table->' . $value['type'] . '(\'' . $key . '\');
            ';
        }
        return $str;
    }

    public function toModel()
    {
        $str = implode(
            ",",
            array_map(
                function ($val) {
                    return "'$val'";
                },
                array_keys($this->fields)
            )
        );
        return $str;
    }

    public static function listOf()
    {
        return self::$list;
    }

    public function getTable()
    {
        return $this->tableName;
    }
}
