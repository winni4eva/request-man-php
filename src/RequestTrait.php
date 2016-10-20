<?php
namespace RequestMan;

trait RequestTrait{

    public static function request( ){
        return (new self(parent::$endpoint))->execute();
    }
}