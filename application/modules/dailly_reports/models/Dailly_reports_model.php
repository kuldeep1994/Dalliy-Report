<?php defined('BASEPATH') || exit('No direct script access allowed');

class Dailly_reports_model extends BF_Model
{
    protected $table_name	= 'dailly_reports';
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= true;
	protected $set_created	= true;
	protected $set_modified = true;
	protected $soft_deletes	= true;

	protected $created_field     = 'created_on';
    protected $created_by_field  = 'created_by';
	protected $modified_field    = 'modified_on';
    protected $modified_by_field = 'modified_by';
    protected $deleted_field     = 'deleted';
    protected $deleted_by_field  = 'deleted_by';

	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'project_name',
			'label' => 'lang:dailly_reports_field_project_name',
			'rules' => 'required|max_length[150]',
		),
		array(
			'field' => 'pms_task_id',
			'label' => 'lang:dailly_reports_field_pms_task_id',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'task_title',
			'label' => 'lang:dailly_reports_field_task_title',
			'rules' => 'required|max_length[50]',
		),
		array(
			'field' => 'task_description',
			'label' => 'lang:dailly_reports_field_task_description',
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'start_time',
			'label' => 'lang:dailly_reports_field_start_time',
			'rules' => 'required|max_length[30]',
		),
		array(
			'field' => 'end_time',
			'label' => 'lang:dailly_reports_field_end_time',
			'rules' => 'max_length[30]',
		),
		array(
			'field' => 'user_id',
			'label' => 'lang:dailly_reports_field_user_id',
			'rules' => 'max_length[10]',
		),
		array(
			'field' => 'status',
			'label' => 'lang:dailly_reports_field_status',
			'rules' => '',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
	}
	
	public function getUserName($user_id){
		return $this->db->get_where('users',array('id'=>$user_id))->row()->username;
	}
}