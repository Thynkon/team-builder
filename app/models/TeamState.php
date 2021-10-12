<?php

use Thynkon\SimpleOrm\Model;

class TeamState extends Model
{
    static protected string $table = "states";
    protected string $primaryKey = "id";
    public int $id;
    public string $slug;
    public string $name;
}