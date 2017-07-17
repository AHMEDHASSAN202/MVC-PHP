<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/12/2017
 * Time: 11:56 PM
 */

namespace System;


class Validation
{
    /**
     * Application Class
     *
     * @var object
     */
    private $app;

    /**
     * Container Errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * Validation Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Add Error
     *
     * @param $input
     * @param $error
     */
    public function addError($input , $error)
    {
        $this->errors[$input] = $error;
    }

    /**
     * Check If Input has Error
     *
     * @param $input
     * @return bool
     */
    private function hasError($input)
    {
        return array_key_exists($input , $this->errors);
    }

    /**
     * Get Errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Check If Empty Container Errors
     *
     * @return bool
     */
    public function passes()
    {
        return !empty($this->errors) ? false : true;
    }

    /**
     * Determine if the Given input is Not Empty
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function required($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = trim($this->request->post($input));

        if ($inputValue === '') {

            $errorMessage = $errorMessage ?: sprintf('%s is required' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the Given File input is Not Empty
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function requiredFile($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->file($input);

        if (!$inputValue->uploaded()) {

            $errorMessage = $errorMessage ?: sprintf('%s is required', $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if File Is Image
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function isImage($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->file($input);

        if (!$inputValue->isImage()) {

            $errorMessage = $errorMessage ?: sprintf('%s is not valid image' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the given input is valid email
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function email($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = trim($this->request->post($input));

        if (!filter_var($inputValue , FILTER_VALIDATE_EMAIL)) {

            $errorMessage = $errorMessage ?: sprintf('%s is not a valid email address' , $inputValue);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the given input value should be at most the given length
     *
     * @param $input
     * @param $length
     * @param null $errorMessage
     * @return $this
     */
    public function max($input , $length , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->post($input);

        if (strlen($inputValue) > $length) {

            $errorMessage = $errorMessage ?: sprintf('%s should be at least %d' , $inputValue , $length);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the given input value should be at least the given length
     *
     * @param $input
     * @param $length
     * @param null $errorMessage
     * @return $this
     */
    public function min($input , $length , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->post($input);

        if (strlen($inputValue) < $length) {

            $errorMessage = $errorMessage ?: sprintf('%s should be at most %d' , $inputValue , $length);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Between Start -> ^
     * And End -> $
     * start input must by string ([a-z-A-Z])
     * of the string there has to be at least one number -> (?=.*\d)
     * and at least one letter -> (?=.*[A-Za-z])
     * and it has to be a number, a letter or one of the following: -> [0-9A-Za-z_]
     * and there have to be 8-16 characters -> {8,16}
     *
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function username($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = trim($this->request->post($input));

        if (!preg_match('/^([a-zA-Z])(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z_]{8,16}$/' , $inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('invalid username');

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Checks if all of the characters in the provided string, text, are alphabetic
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function string($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = trim($this->request->post($input));

        if (!ctype_alpha($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allowed only letters' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Find whether the type of a variable is integer
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function int($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->post($input);

        if (!is_int($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allowed only int');

            $this->addError($errorMessage);
        }

        return $this;
    }

    /**
     * Finds whether a variable is a number or a numeric string
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function number($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->post($input);

        if (!is_numeric($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allowed only numbers');

            $this->addError($errorMessage);
        }

        return $this;
    }

    /**
     * Check requirement password :---
     * Must be 8-20 characters long
     * at least one lowercase char
     * at least one digit
     * at least one special sign of @#-_$%^&+=§!?
     * for be at least one uppercase char add this (?=.*[A-Z])
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function password($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = trim($this->request->post($input));

        if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/' , $inputValue)) {

            $errorMessage = $errorMessage ?: 'Password must be 8-20 characters contain of letters, numbers and 
    at least one special character';

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the first input matches the second input
     *
     * @param $firstInput
     * @param $secondInput
     * @param null $errorMessage
     * @return $this
     */
    public function matches($firstInput , $secondInput , $errorMessage = null)
    {
        if ($this->hasError($firstInput)) {
            return $this;
        }

        $firstInputValue = $this->request->post($firstInput);
        $secondInputValue = $this->request->post($secondInput);

        if ($firstInputValue !== $secondInputValue) {

            $errorMessage = $errorMessage ?: sprintf('%s must matches $s' , $firstInput , $secondInput);

            $this->addError($firstInput , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if The Given input is Unique in Database
     *
     * @param $input
     * @param array $database
     * @param null $errorMessage
     * @return $this
     */
    public function unique($input , $database = [] , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->request->post($input);

        $table = '';
        $column = '';
        $exceptionColumn = '';
        $exceptionValue = '';

        if (count($database) == 4) {

            list($table , $column , $exceptionColumn , $exceptionValue) = $database;

            $result = $this->app->db->select($column , $exceptionColumn)->from($table)
                          ->where(sprintf('`%s` = ? AND `%s` != ?' , $column , $exceptionColumn) , $inputValue , $exceptionValue)
                          ->fetch();
        }else {

            list($table , $column) = $database;

            $result = $this->app->db->select($column)->from($table)
                                    ->where(sprintf('%s = ?' , $column) , $inputValue)
                                    ->fetch();
        }

        if ($result) {

            $errorMessage = $errorMessage ?: sprintf('%s already exists' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Magic method get
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->app->$name;
    }

}