<?php

namespace App\Validation;

/**
 * Class trait Filter
 * 
 * PHP version 8.0.0
 * 
 * @category App\Validation
 * @package  App\Validation
 * @author   Christian Shungu <christianshungu@gmail.com>
 * @license  https://opensource.org/ MIT
 * @link     https://cshungu.fr
 */
trait Filter
{
    /**
     * Method isEmpty
     * 
     * It allows you to check if the field is empty.
     * 
     * @return self;
     */
    public function isEmpty(): self
    {
        if (empty($this->getValeur()) && $this->isNotAlreadyError()) {
            $this->addError($this->getField(), $this->getMessage('empty'));
        }
        return $this;
    }
    /**
     * Method isNumber
     * 
     * It is used to check if the type of the value entered is number
     * 
     * @return self;
     */
    public function isNumber(): self
    {
        if (!is_numeric($this->getValeur()) && $this->isNotAlreadyError()) {
            $this->addError($this->getField(), $this->getMessage('number'));
        }
        return $this;
    }

    /**
     * Method size
     * 
     * It allows you to check the size of the entered value.
     * 
     * @param int $digit - Nombre 
     * 
     * @return self;
     */
    public function size(int $digit = 8): self
    {
        $size = (int) mb_strlen((string) $this->getValeur());
        if (($size !== $digit) && $this->isNotAlreadyError()) {
            $this->addError($this->getField(), $this->getMessage('size'));
        }
        return $this;
    }

    /**
     * Method same
     * 
     * It allows you to compare the value of two fields.
     * 
     * @param int $name -  
     * 
     * @return self;
     */
    public function same(string $name = ""): self
    {
        $tampon = $this->getTampon($name);
        if ((strcmp($this->getValeur(), trim($tampon)) !== 0)
            && ($this->isNotAlreadyError())
        ) {
            $this->addError($this->getField(), $this->getMessage('confirm'));
        }
        return $this;
    }

    /**
     * Method isEmail
     * 
     * It allows you to check if the e-mail address entered is valid.
     * 
     * @return self;
     */
    public function isEmail(): self
    {
        $email = filter_var($this->getValeur(), FILTER_VALIDATE_EMAIL);
        if (!$email && $this->isNotAlreadyError()) {
            $this->addError($this->getField(), $this->getMessage('invalid'));
        }
        return $this;
    }

    /**
     * Method hasEmail
     * 
     * It allows you to check if the e-mail address entered exists in the database.
     * 
     * @return self;
     */
    public function hasEmail(): self
    {
        $user = $this->container->get('security')
            ->getUserFromEmail($this->getValeur());
        if (count($user) === 0 && $this->isNotAlreadyError()) {
            $this->addError($this->getField(), $this->getMessage('unknown'));
        }
        return $this;
    }

    /**
     * Method hasPassword
     *
     * @return self;
     */
    public function hasPassword(): self
    {
        $user = $this->container->get('security')
            ->getUserFromEmail($this->getTampon("email"));
        if (isset($user['password'])
            && !password_verify($this->getValeur(), $user['password'])
            && $this->isNotAlreadyError()
        ) {
            $this->addError($this->getField(), $this->getMessage('invalid'));
        }
        return $this;
    }

    /**
     * Method hasTag
     * 
     * It allows you to see the sais field contains the html tag.
     * 
     * @return self;
     */
    public function hasTag(): self
    {
        $stringValue = filter_var(
            $this->getValeur(),
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_HIGH
        );
        if (!$stringValue && $this->isNotAlreadyError()) {
            $this->addError($this->getField(), $this->getMessage('tag'));
        }
        return $this;
    }
}
