<?php

require "model/Role.php";

use ByJG\DbMigration\Exception\DatabaseDoesNotRegistered;
use ByJG\DbMigration\Exception\DatabaseIsIncompleteException;
use ByJG\DbMigration\Exception\DatabaseNotVersionedException;
use ByJG\DbMigration\Exception\InvalidMigrationFile;
use ByJG\DbMigration\Exception\OldVersionSchemaException;
use ByJG\DbMigration\Migration;
use ByJG\Util\Uri;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    private Migration $migration;

    /**
     * @throws InvalidMigrationFile
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $connectionUri = new Uri(sprintf('mysql://%s:%s@localhost/teambuilder', USERNAME, PASSWORD));

        // Create the Migration instance
        $this->migration = new Migration($connectionUri, '.');

        // Register the Database or Databases can handle that URI:
        $this->migration->registerDatabase('mysql', \ByJG\DbMigration\Database\MySqlDatabase::class);
        $this->migration->registerDatabase('maria', \ByJG\DbMigration\Database\MySqlDatabase::class);

        // Add a callback progress function to receive info from the execution
        $this->migration->addCallbackProgress(function ($action, $currentVersion, $fileInfo) {
            echo "$action, $currentVersion, ${fileInfo['description']}\n";
        });
    }

    /**
     * @throws DatabaseDoesNotRegistered
     * @throws DatabaseNotVersionedException
     * @throws InvalidMigrationFile
     * @throws DatabaseIsIncompleteException
     * @throws OldVersionSchemaException
     */
    public function setUp(): void
    {
        $this->migration->reset();
        $this->migration->up(1);
    }
    /**
     * @covers Role::all()
     */
    public function testAll()
    {
        $this->assertEquals(2,count(Role::all()));
    }

    /**
     * @covers Role::find(id)
     */
    public function testFind()
    {
        $this->assertInstanceOf(Role::class,Role::find(1));
        $this->assertNull(Role::find(1000));
    }

    /**
     * @covers $role->create()
     */
    public function testCreate()
    {
        $role = new Role();
        $role->slug = "XXX";
        $role->name = "XXX";
        $this->assertTrue($role->create());
        $this->assertFalse($role->create());
    }

    /**
     * @covers $role->save()
     */
    public function testSave()
    {
        $role = Role::find(1);
        $savename = $role->name;
        $role->name = "newname";
        $this->assertTrue($role->save());
        $this->assertEquals("newname",Role::find(1)->name);
        $role->name = $savename;
        $role->save();
    }

    /**
     * @covers $role->save() doesn't allow duplicates
     */
    public function testSaveRejectsDuplicates()
    {
        $role = Role::find(1);
        $role->name = Role::find(2)->name;
        $this->assertFalse($role->save());
    }

    /**
     * @covers $role->delete()
     */
    public function testDelete()
    {
        $role = Role::find(1);
        $this->assertFalse($role->delete()); // expected to fail because of foreign key
        $role = new Role();
        $role->slug = "ZZZ";
        $role->name = "dummy";
        $role->create();
        $id = $role->id;
        $this->assertTrue($role->delete()); // expected to succeed
        $this->assertNull(Role::find($id)); // we should not find it back
    }

    /**
     * @covers Role::destroy(id)
     */
    public function testDestroy()
    {
        $this->assertFalse(Role::destroy(1)); // expected to fail because of foreign key
        $role = new Role();
        $role->slug = "ZZZ";
        $role->name = "dummy";
        $role->create();
        $id = $role->id;
        $this->assertTrue(Role::destroy($id)); // expected to succeed
        $this->assertNull(Role::find($id)); // we should not find it back
    }
}
