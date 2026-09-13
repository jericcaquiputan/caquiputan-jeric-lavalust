<?php

class Add_deleted_at_to_users {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        $this->_lava->dbforge->add_column('users', [
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => TRUE,
                'default' => NULL,
            ],
        ]);
    }

    public function down()
    {
        $this->_lava->dbforge->drop_column('users', 'deleted_at');
    }
}