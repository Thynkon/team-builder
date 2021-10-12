<?php

require_once("app/models/TeamState.php");
require_once(".env.php");

use ByJG\DbMigration\Exception\DatabaseDoesNotRegistered;
use ByJG\DbMigration\Exception\DatabaseIsIncompleteException;
use ByJG\DbMigration\Exception\DatabaseNotVersionedException;
use ByJG\DbMigration\Exception\InvalidMigrationFile;
use ByJG\DbMigration\Exception\OldVersionSchemaException;
use ByJG\DbMigration\Migration;
use ByJG\Util\Uri;
use PHPUnit\Framework\TestCase;

class TeamStateTest extends TestCase
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
        $this->assertEquals(5,count(TeamState::all()));
    }

    /**
     * @covers Role::find(id)
     */
    public function testFind()
    {
        $this->assertInstanceOf(TeamState::class,TeamState::find(1));
        $this->assertNull(TeamState::find(1000));
    }

    /**
     * @covers $role->create()
     */
    public function testCreate()
    {
        $state = new TeamState();
        $state->slug = "XXX";
        $state->name = "XXX";
        $this->assertTrue($state->create());
        $this->assertFalse($state->create());
    }

    /**
     * @covers $role->save()
     */
    public function testSave()
    {
        $state = TeamState::find(1);
        $savename = $state->name;
        $state->name = "newname";
        $this->assertTrue($state->save());
        $this->assertEquals("newname",TeamState::find(1)->name);
        $state->name = $savename;
        $state->save();
    }

    /**
     * @covers $role->save() doesn't allow duplicates
     */
    public function testSaveRejectsDuplicates()
    {
        $state = TeamState::find(1);
        $state->name = TeamState::find(2)->name;
        $this->assertFalse($state->save());
    }

    /**
     * @covers $role->delete()
     */
    public function testDelete()
    {
        $state = TeamState::find(1);
        $this->assertFalse($state->delete()); // expected to fail because of foreign key
        $state = new TeamState();
        $state->slug = "ZZZ";
        $state->name = "dummy";
        $state->create();
        $id = $state->id;
        $this->assertTrue($state->delete()); // expected to succeed
        $this->assertNull(TeamState::find($id)); // we should not find it back
    }

    /**
     * @covers Role::destroy(id)
     */
    public function testDestroy()
    {
        $this->assertFalse(TeamState::destroy(1)); // expected to fail because of foreign key
        $state = new TeamState();
        $state->slug = "ZZZ";
        $state->name = "dummy";
        $state->create();
        $id = $state->id;
        $this->assertTrue(TeamState::destroy($id)); // expected to succeed
        $this->assertNull(TeamState::find($id)); // we should not find it back
    }
}
