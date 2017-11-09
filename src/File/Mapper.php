<?php
namespace Canvas\File;

class Mapper
{
    protected $_namespace;

    protected $_model;

    protected $_columns = array('id');

    protected $_table;

    public function __construct($namespace, $model, $table, $columns = null)
    {
        $this->_namespace = $namespace;
        $this->_model = $model;
        $this->_table = $table;

        if ($columns) {
            $this->_columns = $columns;
        }
    }

    public function getRelativePath()
    {
        return $this->_model . '/Mapper.php';
    }

    public function getClass()
    {
        return 'Mapper extends \Atlas\Model\Mapper';
    }

    public function getNamespace()
    {
        return "namespace {$this->_namespace}\\{$this->_model};\n";
    }

    public function getProperties()
    {
        return array(
            array('type' => 'protected', 'name' => '_alias', 'value' => "'" . substr($this->_table, 0, 1) . "'"),
            array('type' => 'protected', 'name' => '_table', 'value' => "'{$this->_table}'"),
            array('type' => 'protected', 'name' => '_key', 'value' => '\'id\''),
            array('type' => 'protected', 'name' => '_map', 'value' => $this->_getMapString($this->_columns)),
            array('type' => 'protected', 'name' => '_readOnly', 'value' => 'array(\'id\')'),
        );
    } 

    public function getMethods()
    {
        return array(
            $this->_createGetEntity(),
            $this->_createGetCollection(),
        );
    }

    protected function _getMapString($columns)
    {
        $lines = null;

        foreach ($columns as $value) {
            $lines .= "        '_{$value}'        => '{$value}',\n";
        }

        return "array(\n{$lines}    )";
    }

    protected function _createGetEntity()
    {
        return "public function getEntity(\$row)"
            . "\n{"
            . "\n    return new Entity(\$this->_populate(\$row));"
            . "\n}";
    }

    protected function _createGetCollection()
    {
        return "public function getCollection(\$rows)"
            . "\n{"
            . "\n    return new Collection(\$rows, \$this);"
            . "\n}";
    }
}
