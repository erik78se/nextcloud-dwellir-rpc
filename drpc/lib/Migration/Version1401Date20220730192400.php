<?php

  namespace OCA\DRpc\Migration;

  use Closure;
  use OCP\DB\ISchemaWrapper;
  use OCP\Migration\SimpleMigrationStep;
  use OCP\Migration\IOutput;

  class Version1401Date2022073019240000 extends SimpleMigrationStep {

    /**
    * @param IOutput $output
    * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
    * @param array $options
    * @return null|ISchemaWrapper
    */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('drpc')) {
            $table = $schema->createTable('drpc');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('name', 'string', [
                'notnull' => true,
                'length' => 200
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 200
            ]);
            $table->addColumn('wsuri', 'string', [
                'notnull' => false,
                'length' => 200,
            ]);
            $table->addColumn('httpuri', 'string', [
                'notnull' => false,
                'length' => 200,
            ]);
            $table->addColumn('notes', 'text', [
                'notnull' => false,
                'default' => ''
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'drpc_user_id_index');
        }
        return $schema;
    }
}