<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SpecifySchema extends CI_Controller {
    var $data;
    var $db;
    
    public function  __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->output->enable_profiler(FALSE);
        
        $this->data = array();
        
        // Allow for custom style sheets and javascript
        $this->data['css'] = array();
        $this->data['js'] = array();
        $this->data['iehack'] = FALSE;
        
        
        
        if (isset($this->session->userdata['db']) && $this->session->userdata['db'] == 'development') {
            $dev = $this->load->database('development', TRUE);
            $this->db = $dev;
            $this->data['db'] = 'development';
        }
        else {
            $default = $this->load->database('default', TRUE);
            $this->db = $default;
            $this->data['db'] = 'melisr';
        }
        
        $this->load->model('specifyschemamodel', 'schemamodel');
        $this->data['version'] = $this->schemamodel->getVersion();
        $this->data['table_dropdown'] = $this->schemamodel->getTableDropDown();
        
    }
    
    public function index() {
        $this->table();
    }
    
    public function table($table=FALSE) {
        if (!$table) {
            $this->data['map_collectionsdb'] = TRUE;
            $this->data['tables'] = $this->schemamodel->getTables();
        }
        else {
            $this->data['table_info'] = $this->schemamodel->getTableInfo($table);
            $this->data['fields'] = $this->schemamodel->getFields($table);
            $this->data['indexes'] = $this->schemamodel->getIndexes($table);
            $this->data['one_to_many'] = $this->schemamodel->getOneToMany($table);
            $this->data['many_to_one'] = $this->schemamodel->getManyToOne($table);
            $this->data['picklists'] = $this->schemamodel->getPickLists();
            $this->data['triggers'] = $this->schemamodel->getTriggersForTable($table);
            $this->data['forms'] = $this->schemamodel->getFormsForTable($table);
        }
        $this->load->view('table_view', $this->data);
    }
    
    public function changedb($newdb) {
        if ($newdb == 'default') {
            $this->session->unset_userdata(array('db' => ''));
        }
        elseif ($newdb == 'development') {
            $this->session->set_userdata(array('db' => 'development'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function trigger($trigger=FALSE) {
        $this->data['triggers'] = $this->schemamodel->getTriggerDropdown();
        if ($trigger) 
            $this->data['trigger'] = $this->schemamodel->getTrigger($trigger);
        $this->load->view('trigger_view', $this->data);
    }
    
    public function update_forms() {
        $this->output->enable_profiler(false);
        $this->schemamodel->updateForms();
    }
    
    public function form_test() {
        $this->output->enable_profiler(false);
        $collforms = new DOMDocument();
        $collforms->load(getcwd() . '/forms/botany.views.collection.xml');
        
        $xpath = new DOMXPath($collforms);
        $elements = $xpath->query("*/viewdef[@class='edu.ku.brc.specify.datamodel.CollectionObject']");
        if ($elements) {
            foreach ($elements as $el) {
                $cells = $el->getElementsByTagName('cell');
                if ($cells->length) {
                    foreach ($cells as $cell) {
                        $type = $cell->getAttribute('type');
                        if ($type == 'field')
                            echo $cell->getAttribute('name') . "<br/>";
                    }
                }
                
            }
        }

    }
}

/* End of file specifyschema.php */
/* Location: ./specify_schema/controllers/specifyschema.php */
