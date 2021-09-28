<?php

namespace UnitTestFiles\Test;

require_once('vendor/autoload.php');
require_once('model/DB.php');

use PHPUnit\Framework\TestCase;
use CPNV\DB;

class DbTest extends TestCase
{
    public function setUp(): void
    {
    }

    /**
     * @covers DB::selectMany()
    */
    public function testSelectMany()
    {
        $this->assertEquals(
            [
                [
                    "id" => 1,
                    "slug" => "MEM",
                    "name" => "Member"
                ],
                [
                    "id" => 2,
                    "slug" => "MOD",
                    "name" => "Moderator"
                ],
            ],
            DB::selectMany("SELECT * FROM roles", [])
        );
    }

    /**
     * @covers DB::selectOne()
     */
    public function testSelectOne()
    {
        $this->assertEquals(
            [
                "id" => 2,
                "slug" => "MOD",
                "name" => "Moderator"
            ],
            DB::selectOne("SELECT * FROM roles where slug = :slug", ["slug" => "MOD"])
        );
    }

    /**
     * @covers DB::insert()
     */
    public function testInsert()
    {
        $this->assertEquals(
            3,
            DB::insert("INSERT INTO roles(slug,name) VALUES (:slug, :name)", ["slug" => "TOTO", "name" => "TOTEM"])
        );
    }

    /**
     * @covers DB::execute()
     */
    public function testUpdate()
    {
        $this->assertEquals(
            1,
            DB::execute("UPDATE roles set name = :name WHERE slug = :slug", ["slug" => "TOTO", "name" => "Correcteur"])
        );
    }

}