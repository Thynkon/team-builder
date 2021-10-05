<?php

use Thynkon\SimpleOrm\Model;

class Role extends Model
{
    static protected string $table = "roles";
    protected string $primaryKey = "id";
    public int $id;
    public string $slug;
    public string $name;
}