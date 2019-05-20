<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Reports controller
 */
class Reports extends Admin_Controller
{
    protected $permissionCreate = 'Dailly_reports.Reports.Create';
    protected $permissionDelete = 'Dailly_reports.Reports.Delete';
    protected $permissionEdit   = 'Dailly_reports.Reports.Edit';
    protected $permissionView   = 'Dailly_reports.Reports.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('dailly_reports/dailly_reports_model');
        $this->lang->load('dailly_reports');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            Assets::add_css('jquery-ui-timepicker.css');
            Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'reports/_sub_nav');

        Assets::add_module_js('dailly_reports', 'dailly_reports.js');
    }

    /**
     * Display a list of Dailly Reports data.
     *
     * @return void
     */
    public function index($offset = 0)
    {

        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->dailly_reports_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('dailly_reports_delete_success'), 'success');
                } else {
                    Template::set_message(lang('dailly_reports_delete_failure') . $this->dailly_reports_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/reports/dailly_reports/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->dailly_reports_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->dailly_reports_model->limit($limit, $offset);
        
        if($this->session->userdata('role_id')=='1'){
            $records = $this->dailly_reports_model->find_all();
        }
        else{
            $records = $this->dailly_reports_model->find_all_by('user_id',$this->session->userdata('user_id'));
        }
        
        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('dailly_reports_manage'));

        Template::render();
    }
    
    /**
     * Create a Dailly Reports object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_dailly_reports()) {
                log_activity($this->auth->user_id(), lang('dailly_reports_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'dailly_reports');
                Template::set_message(lang('dailly_reports_create_success'), 'success');

                redirect(SITE_AREA . '/reports/dailly_reports');
            }

            // Not validation error
            if ( ! empty($this->dailly_reports_model->error)) {
                Template::set_message(lang('dailly_reports_create_failure') . $this->dailly_reports_model->error, 'error');
            }
        }
        
        Template::set('toolbar_title', lang('dailly_reports_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Dailly Reports data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('dailly_reports_invalid_id'), 'error');

            redirect(SITE_AREA . '/reports/dailly_reports');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_dailly_reports('update', $id)) {
                log_activity($this->auth->user_id(), lang('dailly_reports_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'dailly_reports');
                Template::set_message(lang('dailly_reports_edit_success'), 'success');
                redirect(SITE_AREA . '/reports/dailly_reports');
            }

            // Not validation error
            if ( ! empty($this->dailly_reports_model->error)) {
                Template::set_message(lang('dailly_reports_edit_failure') . $this->dailly_reports_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->dailly_reports_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('dailly_reports_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'dailly_reports');
                Template::set_message(lang('dailly_reports_delete_success'), 'success');

                redirect(SITE_AREA . '/reports/dailly_reports');
            }

            Template::set_message(lang('dailly_reports_delete_failure') . $this->dailly_reports_model->error, 'error');
        }
        
        Template::set('dailly_reports', $this->dailly_reports_model->find($id));

        Template::set('toolbar_title', lang('dailly_reports_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_dailly_reports($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->dailly_reports_model->get_validation_rules());

        if($this->input->post('end_time')!=''){
            $this->form_validation->set_rules('end_time', 'End Time', 'required|callback_validate_end_time');
        }

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->dailly_reports_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['start_time']	= $this->input->post('start_time') ? $this->input->post('start_time') : '0000-00-00 00:00:00';
		$data['end_time']	= $this->input->post('end_time') ? $this->input->post('end_time') : '0000-00-00 00:00:00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->dailly_reports_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->dailly_reports_model->update($id, $data);
        }

        return $return;
    }

    function validate_end_time($end_time){

        $start_time = $this->input->post('start_time');

        if ($end_time < $start_time || $end_time == $start_time) {
            $this->form_validation->set_message('validate_end_time', 'Invalid end time ' . $end_time . ',because end time must be grater then start time');
            return false;
        }
        else {
              return true;
        }

    }

    public function markCompleted()
    {
        $task_id  = $this->input->post('task_id');
        $end_time = $this->input->post('end_time');
        $report   = $this->db->get_where('bf_dailly_reports',array('id'=>$task_id))->row();
        $start_time = $report->start_time;
        if($end_time<$start_time){
            echo json_encode(array('token'=>$this->security->get_csrf_hash(),'data'=>$report,'error'=>'Please enter valid end time,because end time must be grater then start time'));
        }
        else{
            $data['end_time'] = $end_time;
            $data['status'] = 'Completed';
            $this->db->where('id',$task_id);
            $this->db->update('bf_dailly_reports',$data);
            echo json_encode(array('token'=>$this->security->get_csrf_hash(),'data'=>$report,'error'=>''));
        }
    }

    public function changeRequested()
    {
        $task_id  = $this->input->post('task_id');
        $data['status'] = 'Change Requested';
        $this->db->where('id',$task_id);
        $this->db->update('bf_dailly_reports',$data);
        echo json_encode(array('token'=>$this->security->get_csrf_hash(),'msg'=>'done'));
    }
    
}