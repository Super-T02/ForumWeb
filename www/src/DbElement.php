<?php


interface DbElement
{
    public static function loadByID(int $id): dbElement;
    public function sendToDB();

    public function __toString();
}