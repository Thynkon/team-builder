<?php

use Thynkon\SimpleOrm\Model;

class Team extends Model
{
    static protected string $table = "teams";
    protected string $primaryKey = "id";
    public int $id;
    public string $name;
    public int $state_id;
}