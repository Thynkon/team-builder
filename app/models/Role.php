<?php

require_once("app/lib/Model.php");

class Role extends Model
{
    static public string $table = "roles";
    protected string $primaryKey = "id";
    public int $id;
    public string $slug;
    public string $name;
}