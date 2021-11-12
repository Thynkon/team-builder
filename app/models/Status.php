<?php

require_once("app/lib/Model.php");

class Status extends Model
{
    static public string $table = "status";
    protected string $primaryKey = "id";
    public int $id;
    public string $slug;
    public string $value;
}