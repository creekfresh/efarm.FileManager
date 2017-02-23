<?php 

class BaseFS {
    
    /**
     *
     * @var array $_values 
     */
    protected $_values = array();
    
    
    /**
     * 
     * @param type $name
     * @param type $value
     * @throws Exception
     */
    public function __set($name, $value)
    {   
        if (!in_array($name, $this->_properties)) {
            throw new Exception('The property ' . $name . ' is not defined for this object.');  
        }
        $mutator = 'set' . ucfirst($name);
        if (method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
            $this->$mutator($value);
        }
        else {
            $this->_values[$name] = $value;
        }    
    }
    
    
    
    /**
     * 
     * @param type $name
     * @return type
     * @throws Exception
     */
    public function __get($name)
    {
        if (!in_array($name, $this->_properties)) {
            throw new Exception('The property ' . $name . ' is not defined for this object.');    
        }
        $accessor = 'get' . ucfirst($name);
        if (method_exists($this, $accessor) && is_callable(array($this, $accessor))) {
            return $this->$accessor;    
        }
        if (isset($this->_values[$name])) {
            return $this->_values[$name];   
        }
        throw new Exception('The property ' . $name . ' has not been set for this object yet.');
    }    
}
