<?php

/**
 * Container
 * 
 * PHP version 8.0.8
 * 
 * @category App\Container
 * @package  App\Container
 * @author   Christian Shungu <christianshungu@keretben.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://cshungu.Fr
 * @version: 1
 * @date     14/06/2018
 * @file     Arithm\Factory\OperationFactory
 */

namespace App\Container {
    /**
     * Interface Operation
     * 
     * @category Arithm\Container
     * @package  Arithm\Container
     * @author   Christian Shungu <christianshungu@keretben.com>
     * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
     * @link     http://keretben.com
     */
    class Container implements \ArrayAccess
    {
        /**
         * Container
         * 
         * @var array $_container
         */
        private $_container = [];

        /**
         * Instance
         * 
         * @var array $_instance
         */
        private $_instance = [];

        /**
         * SET 
         * 
         * @param string $key      - Key is the nam of class
         * @param object $resolver - $resolver is the class
         * 
         * @access public
         * @return void
         */
        public function set($key, callable $resolver)
        {
            $this->_container[$key] = $resolver;
        }

        /**
         * GET 
         * 
         * @param string $key - Key is the nam of class
         * 
         * @access public
         * @return object
         */
        public function get($key)
        {
            if (!isset($this->instances[$key])) {
                if (isset($this->_container[$key])) {
                    $this->instances[$key] = $this->_container[$key]($this);
                } else {
                    throw new \Exception($key . " n'est pas dans mon conteneur :(");
                }
            }
            return $this->instances[$key];
        }

        /**
         * Method offsetSet
         * 
         * @param int   $offset - 
         * @param mixed $value  - 
         * 
         * @access public
         * @return void
         */
        public function offsetSet($offset, $value): void
        {
            if (is_null($offset)) {
                $this->_container[] = $value;
            } else {
                $this->_container[$offset] = $value;
            }
        }
        /**
         * Method offsetExists
         * 
         * @param int $offset - 
         * 
         * @access public
         * @return void
         */
        public function offsetExists($offset): bool
        {
            return isset($this->_container[$offset]);
        }
        /**
         * Method offsetUnset
         * 
         * @param int $offset - 
         * 
         * @access public
         * @return void
         */
        public function offsetUnset($offset): void
        {
            unset($this->_container[$offset]);
        }
        /**
         * Method offsetGet
         * 
         * @param int $offset - 
         * 
         * @access public
         * @return void
         */
        public function offsetGet($offset)
        {
            return isset($this->_container[$offset]) ?? null;
        }
    }
}
