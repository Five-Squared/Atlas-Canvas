<?php
namespace Canvas\File;

class Entity
{
    protected $_namespace;

    protected $_model;

    protected $_columns = array('id');

    public function __construct($namespace, $model, $columns = null)
    {
        $this->_namespace = $namespace;
        $this->_model = $model;

        if ($columns) {
            $this->_columns = $columns;
        }
    }

    public function getRelativePath()
    {
        return $this->_model . '/Entity.php';
    }

    public function getClass()
    {
        return 'Entity extends \Atlas\Model\Entity';
    }

    public function getNamespace()
    {
        return "namespace {$this->_namespace}\\{$this->_model};\n";
    }

    public function getProperties()
    {
        $properties = array();
        
        foreach ($this->_columns as $value) {
            array_push($properties, array(
                'type'  => 'protected', 
                'name'  => '_' . $value, 
                'value' => 'null'
            ));
        }

        return $properties;
    } 

    public function getMethods()
    {
        return array(
            //return $this->_createFactory()
        );
    }

    protected function _createFactory()
    {
        return "public function factory()"
            . "\n{"
            . "\n\treturn new \\{$this->_namespace}\\{$this->_model}();"
            . "\n}";
    }
}
