<?php

namespace Laravelcity\Comments\Lib;

trait CustomEnums
{

    private $consts = [] , $attributes = [];
    protected $translations = [];
    protected static $singleton = [];

    public static function singelton ()
    {
        $class = get_called_class();
        if (!isset(static::$singleton[$class])) {
            static::$singleton[$class] = (new $class);
        }
        return static::$singleton[$class];
    }

    function __construct ()
    {
        $class = get_called_class();
        // Gets consts
        $reflect = new \ReflectionClass($class);
        $this->consts = $reflect->getConstants();
        // fill translation variable
        if (method_exists($this , 'translations'))
            $this->translations = (array)$this->translations();
        // fill csses
        if (method_exists($this , 'attributes'))
            $this->attributes = (array)$this->attributes();
    }

    /**
     * Gets All list
     * @return array
     */
    public static function all ()
    {
        $list = [];
        foreach (self::singelton()->consts as $name => $val) {
            $list[$name] = [
                'title' => self::singelton()->translate($val) ,
                'html' => self::singelton()->translate($val , true) ,
                'value' => $val
            ];
        }
        return $list;
    }

    /**
     * Gets All list except
     * @param array $except
     * @return array
     */
    public static function except ($except = [])
    {
        return array_except(self::all() , (array)$except);
    }

    /**
     * Gets list only
     * @param array $only
     * @return array
     */
    public static function only ($only = [])
    {
        return array_only(self::all() , (array)$only);
    }

    /**
     * Gets label list
     * @param array $except
     * @param bool|false $html
     * @return array
     */
    public static function getLabels ($html = false)
    {
        $list = [];
        foreach (self::singelton()->consts as $name => $const)
            $list[$const] = self::singelton()->translate($const , $html);
        return $list;
    }

    public static function getLabel ($const , $html = false)
    {
        return self::singelton()->translate($const , $html);
    }

    public static function getLabelList ($html = false)
    {
        return self::getLabels($html);
    }

    /**
     * Gets label list Exceptional
     * @param array $except
     * @param bool|false $html
     * @return array
     */
    public static function getLabelsExcept ($except = [] , $html = false)
    {
        return array_except(self::getLabels($html) , (array)$except);
    }

    /**
     * Gets the constatns list mentioned in first parameter
     * @param array $only
     * @param bool|false $style
     * @return array
     */
    public static function getLabelsOnly ($only = [] , $html = false)
    {
        return array_only(self::getLabels($html) , (array)$only);
    }

    /**
     * Gets constants list
     * @return array
     */
    public static function getConstants ()
    {
        return array_keys(self::singelton()->consts);
    }

    /**
     * Gets constants list
     * @param array $except
     * @return array
     */
    public static function getConstantsExcept ($except = [])
    {
        return array_keys(array_except(self::singelton()->consts , (array)$except));
    }

    /**
     * Gets constans slug list
     * @return array
     */
    public static function getSlugs ()
    {
        $list = [];
        foreach (self::getConstants() as $const)
            $list[$const] = str_uslug($const);
        return $list;
    }

    /**
     * Gets constans slug list
     * @param array $except
     * @return array
     */
    public static function getSlugsExcept ($except = [])
    {
        return array_except(self::getSlugs() , (array)$except);
    }

    /**
     * Finds constant related to given style
     * @param $slug
     * @return mixed
     */
    public static function getConstBySlug ($slug)
    {
        foreach (self::singelton()->consts as $name => $const) {
            if (str_uslug($const) == $slug)
                return $const;
        }
    }

    /**
     * Checks whether the given constant exists
     * @param $name
     * @param bool|false $strict
     * @return bool
     */
    public static function exists ($name , $strict = false)
    {
        $constants = self::singelton()->consts;
        if ($strict) {
            return array_key_exists($name , $constants);
        }
        $keys = array_map('strtolower' , array_keys($constants));
        return in_array(strtolower($name) , $keys);
    }

    /**
     * Checks whether the given value exists
     * @param $value
     * @return bool
     */
    public static function valueExists ($value)
    {
        $values = array_values(self::singelton()->consts);
        return in_array($value , $values , true);
    }

    /**
     * Translates constants
     * @param $const
     * @param bool|false $html
     * @return null|string
     */
    function translate ($const , $html = false)
    {
        $label = null;
        if (isset($this->translations[$const]))
            $label = $this->translations[$const];
        if ($html) {
            // fill attributes
            $attrs = null;
            if (isset($this->attributes [$const]))
                $attrs = html_attributes($this->attributes[$const]);
            return "<label{$attrs}>$label</label>";
        }
        return $label;
    }

    static function getConstantsArrayValue ()
    {
        return self::singelton()->consts;
    }
}