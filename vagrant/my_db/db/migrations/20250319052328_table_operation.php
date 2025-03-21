<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TableOperation extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        // trx_usesテーブルを作成 
        $userTable = $this->table('trx_users');
        $userTable->addColumn('user_name', 'string', ['null' => false, 'default' => null])
            ->addColumn('password', 'string', ['null' => false, 'default' => null])
            ->addIndex(['user_name', 'password'], ['unique' => true])
            ->create();

        // trx_commentsテーブルを作成
        $commentTable = $this->table('trx_comments');
        $commentTable->addColumn('user_id', 'integer')
            ->addColumn('text', 'string', ['null' => false, 'default' => null])
            ->create();
    }
}
