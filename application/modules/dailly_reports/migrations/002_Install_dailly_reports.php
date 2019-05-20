<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_dailly_reports extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'dailly_reports';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'project_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 150,
            'null'       => false,
        ),
        'pms_task_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
        ),
        'task_title' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
        ),
        'task_description' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'start_time' => array(
            'type'       => 'DATETIME',
            'null'       => false,
            'default'    => '0000-00-00 00:00:00',
        ),
        'end_time' => array(
            'type'       => 'DATETIME',
            'null'       => true,
            'default'    => '0000-00-00 00:00:00',
        ),
        'user_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => true,
        ),
        'status' => array(
            'type'       => 'ENUM',
            'constraint' => '30',
            'null'       => true,
        ),
        'deleted' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => '0',
        ),
        'deleted_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'created_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
        'modified_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'modified_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}