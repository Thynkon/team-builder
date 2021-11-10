<?php

require_once("app/lib/Model.php");

class TeamState extends Model
{
    static public string $table = "states";
    protected string $primaryKey = "id";
    public int $id;
    public string $slug;
    public string $name;
}