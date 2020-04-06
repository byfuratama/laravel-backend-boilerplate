<?php

namespace App;

class MM
{
    private static $list = [];

    private $tableName = '';
    private $fields = [];
    private $primaryKeys;
    
    public $softDeletes = false;
    public $timeStamps = true;
    private $recentName;

    public function __construct($table)
    {
        $this->tableName = $table;
        self::$list[] = $this;
    }

    public function field($name, $type, ...$extras)
    {
        return $this->fieldRaw($type, $name, ...$extras);
    }

    public function fieldRaw($type, $name = null, ...$extras)
    {
        if (!$name)
            $name = $type;
        $this->fields[$name] = [
            "type" => $type,
            "extras" => $extras
        ];
        $this->recentName = $name;
        return $this;
    }

    public function nullable() {
        $this->fields[$this->recentName]['nullable'] = true;
    }

    public function default($value) {
        $this->fields[$this->recentName]['default'] = $value;
    }

    public function primaryKeys(...$keys) {
        $this->primaryKeys = implode(
            ",",
            array_map(
                function ($val) {
                    return "'$val'";
                },
                $keys
            )
        );
    }

    private function parseMigration($key, $extras = []) {
        $start = '(';
        $end = ')';
        $str = [];
        $str[] = $key;
        foreach ($extras as $x) {
            $str[] = $x;
        }
        $str = implode(
            ",",
            array_map(
                function ($val) {
                    return "'$val'";
                },
                $str
            )
        );
        return $start . $str . $end;
    }

    private function migrationAffix($arr) {
        $str = '';
        $affixes = ['nullable','default'];
        foreach ($affixes as $aff) {
            if (isset($arr[$aff])) {
                $str .= '->'.$aff.'('. strval($arr[$aff]) .')';
            }
        }
        return $str;
    }

    public function toMigration()
    {
        $str = '';
        foreach ($this->fields as $key => $value) {
            $str .= '$table->' . $value['type'] . $this->parseMigration($key,$value['extras']) . $this->migrationAffix($value) . ';
            ';
        }
        if ($this->primaryKeys) {
            $str .= '$table->primary(['. $this->primaryKeys .']);
            ';
        }
        if ($this->timeStamps) {
            $str .= '$table->timestamps();
            ';
        }
        if ($this->softDeletes) {
            $str .= '$table->softDeletes();
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

    public function softDeletes() {
        $this->softDeletes = true;
    }
}
