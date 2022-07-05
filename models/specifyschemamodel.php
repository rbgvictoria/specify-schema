<?php

class SpecifySchemaModel extends CI_Model {
    private $picklists;
    
    public function __construct() {
        parent::__construct();
        $this->picklists = array();
    }
    
    public function getVersion() {
        $this->db->select('AppVersion, SchemaVersion');
        $this->db->from('spversion');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function getTableDropDown() {
        $ret = array();
        $this->db->select('TableName');
        $this->db->from('spschema_table');
        $this->db->order_by('TableName');
        $query = $this->db->get();
        if ($query->num_rows()) {
            $ret[""] = "";
            foreach ($query->result() as $row)
                $ret[$row->TableName] = $row->TableName;
        }
        return $ret;
    }
    
    public function getTables() {
        /*
         * SELECT lc.spLocaleContainerID, lc.Name AS TableName, lcn.`Text` AS TableTitle, lcd.`Text` AS TableDescription
         * FROM splocalecontainer lc
         * LEFT JOIN splocaleitemstr lcn ON lc.SpLocaleContainerID=lcn.SpLocaleContainerNameID
         * LEFT JOIN splocaleitemstr lcd ON lc.SpLocaleContainerID=lcd.SpLocaleContainerDescID
         * JOIN spschema_table t ON lc.Name=t.TableName
         * WHERE lc.DisciplineID=3 AND lc.SchemaType=0;
         */
        $this->db->select('lc.spLocaleContainerID, lc.Name AS TableName, lcn.Text AS TableTitle, lcd.Text AS TableDescription');
        $this->db->from('splocalecontainer lc');
        $this->db->join('splocaleitemstr lcn', 'lc.SpLocaleContainerID=lcn.SpLocaleContainerNameID', 'left');
        $this->db->join('splocaleitemstr lcd', 'lc.SpLocaleContainerID=lcd.SpLocaleContainerDescID', 'left');
        $this->db->join('spschema_table t', 'lc.Name=t.TableName');
        $this->db->where('lc.DisciplineID', 3);
        $this->db->where('lc.SchemaType', 0);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getTableInfo($table) {
        /*
         * SELECT lc.spLocaleContainerID, lc.Name AS TableName, lcn.`Text` AS TableTitle, lcd.`Text` AS TableDescription
         * FROM splocalecontainer lc
         * LEFT JOIN splocaleitemstr lcn ON lc.SpLocaleContainerID=lcn.SpLocaleContainerNameID
         * LEFT JOIN splocaleitemstr lcd ON lc.SpLocaleContainerID=lcd.SpLocaleContainerDescID
         * JOIN spschema_table t ON lc.Name=t.TableName
         * WHERE lc.DisciplineID=3 AND lc.SchemaType=0 AND lc.Name='$table';
         */
        $this->db->select('lc.spLocaleContainerID, lc.Name AS TableName, lcn.Text AS TableTitle, lcd.Text AS TableDescription');
        $this->db->from('splocalecontainer lc');
        $this->db->join('splocaleitemstr lcn', 'lc.SpLocaleContainerID=lcn.SpLocaleContainerNameID', 'left');
        $this->db->join('splocaleitemstr lcd', 'lc.SpLocaleContainerID=lcd.SpLocaleContainerDescID', 'left');
        $this->db->join('spschema_table t', 'lc.Name=t.TableName');
        $this->db->where('lc.DisciplineID', 3);
        $this->db->where('lc.SchemaType', 0);
        $this->db->where('lc.Name', $table);
        $query = $this->db->get();
        if ($query->num_rows())
            return $query->row_array();
        else
            return FALSE;
    }
    
    public function getFields($table) {
        $ret = array();
        /*
         * SELECT lci.SpLocaleContainerItemID, f.FieldName, lcin.`Text` AS FieldTitle, lcid.`Text` AS FieldDescription,
         *   lci.PickListName, lci.IsRequired=1 AS IsRequired, f.FieldType, f.IsNullable, f.FieldKey
         * FROM splocalecontainer lc
         * JOIN splocalecontaineritem lci ON lc.SpLocaleContainerID=lci.SpLocaleContainerID
         * LEFT JOIN splocaleitemstr lcin ON lci.SpLocaleContainerItemID=lcin.SpLocaleContainerItemNameID
         * LEFT JOIN splocaleitemstr lcid ON lci.SpLocaleContainerItemID=lcid.SpLocaleContainerItemDescID
         * RIGHT JOIN spschema_field f ON lc.Name=f.TableName AND lci.Name=f.FieldName
         * WHERE f.TableName='collectionobject' AND ((lc.DisciplineID=3 AND lc.SchemaType=0) OR lci.SpLocaleContainerItemID IS NULL)
         * ORDER BY f.FieldID;
         */
        $this->db->select("lci.SpLocaleContainerItemID, f.FieldName, 
            group_concat(distinct lcin.`Text`) AS FieldTitle, 
            group_concat(distinct lcid.`Text`) AS FieldDescription,
            lci.PickListName, lci.IsRequired=1 AS IsRequired, lci.IsHidden=1 AS IsHidden, f.FieldType, f.IsNullable, f.FieldKey,
            IF(count(ff.SpFormFieldID)>0, 1, 0) AS IsOnForm", false);
        $this->db->from('splocalecontainer lc');
        $this->db->join('splocalecontaineritem lci', 'lc.SpLocaleContainerID=lci.SpLocaleContainerID');
        $this->db->join('splocaleitemstr lcin', 'lci.SpLocaleContainerItemID=lcin.SpLocaleContainerItemNameID', 'left');
        $this->db->join('splocaleitemstr lcid', 'lci.SpLocaleContainerItemID=lcid.SpLocaleContainerItemDescID', 'left');
        $this->db->join('spschema_field f', 'lc.Name=f.TableName AND lci.Name=f.FieldName', 'right');
        $this->db->join('spschema_formfield ff', 'f.TableName=ff.Table AND f.FieldName=ff.Field', 'left');
        $this->db->where("f.TableName='$table' AND ((lc.DisciplineID=3 AND lc.SchemaType=0) OR lci.SpLocaleContainerItemID IS NULL)", FALSE, FALSE);
        $this->db->group_by('lc.SpLocaleContainerID, lci.SpLocaleContainerItemID, f.FieldID');
        $this->db->order_by('f.FieldID');
        $query = $this->db->get();
        if ($query->num_rows()) {
            foreach ($query->result_array() as $row) {
                if ($row['PickListName'])
                    $this->picklists[] = $row['PickListName'];
                $ret[] = $row;
            }
        }
        return $ret;
    }
    
    public function getIndexes($table) {
        /*
         * SELECT Key_name, Non_unique, GROUP_CONCAT(ColumnName ORDER BY Seq_in_index SEPARATOR ', ') AS `Columns`, IsNullable, Index_type
         * FROM spschema_index
         * WHERE TableName='collectionobject'
         * GROUP BY Key_name
         * ORDER BY IndexID;
         */
        $this->db->select("Key_name, group_concat(distinct Non_unique) AS Non_unique,
  GROUP_CONCAT(ColumnName ORDER BY Seq_in_index SEPARATOR ', ') AS `Columns`,
  group_concat(distinct IsNullable) AS IsNullable, group_concat(distinct Index_type) AS Index_type", false);
        $this->db->from('spschema_index');
        $this->db->where('TableName', $table);
        $this->db->group_by('Key_name');
        //$this->db->order_by('IndexID');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getOneToMany($table) {
        /*
         * SELECT RelationshipID, ToColumnName, FromTableName, FromColumnName
         * FROM spschema_relationship
         * WHERE ToTableName='collectionobject';
         */
        $this->db->select('RelationshipName, RelationshipID, ToColumnName, FromTableName, FromColumnName');
        $this->db->from('spschema_relationship');
        $this->db->where('ToTableName', $table);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getManyToOne($table) {
        /*
         * SELECT RelationshipID, ToColumnName, FromTableName, FromColumnName
         * FROM spschema_relationship
         * WHERE ToTableName='collectionobject';
         */
        $this->db->select('RelationshipName, RelationshipID, FromColumnName, ToTableName, ToColumnName');
        $this->db->from('spschema_relationship');
        $this->db->where('FromTableName', $table);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getPickLists() {
        $ret = array();
        if ($this->picklists) {
            foreach ($this->picklists as $picklist) {
                $items = array();
                $this->db->select('PickListID');
                $this->db->from('picklist');
                $this->db->where('CollectionID', 4);
                $this->db->where('Name', $picklist);
                $query = $this->db->get();
                if ($query->num_rows()) {
                    $row = $query->row();
                    $items = $this->getPickListItems($row->PickListID);
                }
                $ret[$picklist] = $items;
            }
        }
        return $ret;
    }
    
    private function getPickListItems($id) {
        $this->db->select('Value, Title');
        $this->db->from('picklistitem');
        $this->db->where('PickListID', $id);
        $this->db->order_by('Ordinal');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getTriggerDropDown() {
        $ret = array();
        $this->db->select('TRIGGER_NAME AS Name');
        $this->db->from('information_schema.TRIGGERS');
        $this->db->where('TRIGGER_SCHEMA', 'melisr');
        $this->db->order_by('Name');
        $query = $this->db->get();
        if ($query->num_rows()) {
            $ret[''] = '';
            foreach ($query->result() as $row) 
                $ret[$row->Name] = $row->Name;
        }
        return $ret;
    }
    
    public function getTrigger($trigger) {
        $this->db->select('TRIGGER_NAME, ACTION_TIMING, EVENT_MANIPULATION, EVENT_OBJECT_TABLE, ACTION_STATEMENT');
        $this->db->from('information_schema.TRIGGERS');
        $this->db->where('TRIGGER_SCHEMA', 'melisr');
        $this->db->where('TRIGGER_NAME', $trigger);
        $query = $this->db->get();
        if ($query->num_rows()) 
            return $query->row_array();
        else
            return FALSE;
    }
    
    public function getTriggersForTable($table) {
        $this->db->select('TRIGGER_NAME AS `Trigger`, ACTION_TIMING AS Timing, EVENT_MANIPULATION AS Event, EVENT_OBJECT_TABLE AS `Table`, ACTION_STATEMENT AS Statement');
        $this->db->from('information_schema.TRIGGERS');
        $this->db->where('TRIGGER_SCHEMA', 'melisr');
        $this->db->where('EVENT_OBJECT_TABLE', $table);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function updateForms() {
        $this->load->dbforge();
        
        $this->dbforge->drop_table('spschema_form');
        $fields = array(
            'SpFormID' => array(
                'type' => 'integer',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => FALSE,
                'auto_increment' => TRUE
            ),
            'ViewSet' => array(
                'type' => 'varchar',
                'constraint' => 64
            ),
            'Table' => array(
                'type' => 'varchar',
                'constraint' => 64
            ),
            'Form' => array(
                'type' => 'varchar',
                'constraint' => 64
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('SpFormID', TRUE);
        $this->dbforge->create_table('spschema_form');
        
        $this->dbforge->drop_table('spschema_formfield');
        $fields = array(
            'SpFormFieldID' => array(
                'type' => 'integer',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => FALSE,
                'auto_increment' => TRUE
            ),
            'ViewSet' => array(
                'type' => 'varchar',
                'constraint' => 64
            ),
            'Table' => array(
                'type' => 'varchar',
                'constraint' => 64
            ),
            'Form' => array(
                'type' => 'varchar',
                'constraint' => 64
            ),
            'Field' => array(
                'type' => 'varchar',
                'constraint' => 64
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('SpFormFieldID', TRUE);
        $this->dbforge->create_table('spschema_formfield');
        
        if (isset($this->session->userdata['db']) && $this->session->userdata['db'] == 'development') {
            $subdir = 'development';
        }
        else {
            $subdir = 'melisr';
        }
        
        $collforms = new DOMDocument();
        $collforms->load(getcwd() . "/forms/$subdir/botany.views.collection.xml");

        $discforms = new DOMDocument();
        $discforms->load(getcwd() . "/forms/$subdir/botany.views.discipline.xml");
    
        $commforms = new DOMDocument();
        $commforms->load(getcwd() . "/forms/$subdir/common.views.xml");
    
        $globforms = new DOMDocument();
        $globforms->load(getcwd() . "/forms/$subdir/global.views.xml");
        
        $views = array();
        
        foreach (array($commforms, $discforms, $collforms) as $index => $doc) {
            switch ($index) {
                case 0:
                    $level = 'Common';
                    break;
                case 1:
                    $level = 'Discipline';
                    break;
                case 2:
                    $level = 'Collection';
                    break;
            }
            $list = $doc->getElementsByTagName('viewdef');
            if ($list->length) {
                foreach ($list as $view) {
                    $class = $view->getAttribute('class');
                    $name = $view->getAttribute('name');
                    if (!strpos($name, ' ') || !in_array(substr($name, strrpos($name, ' ')+1), array('Table', 'IconView')))
                        $views[] = array(
                            'ViewSet' => $level,
                            'Table' => substr($class, strrpos($class, '.')+1),
                            'Form' => $name
                        );
                }
            }
        }
        
        $tables = array();
        $forms = array();
        foreach ($views as $view) {
            $tables[] = $view['Table'];
            $forms[] = $view['Form'];
        }
        array_multisort($tables, SORT_ASC, $forms, SORT_ASC, $views);
        //print_r($views);
        
        $viewdefs = array();
        foreach ($views as $view) {
            $this->db->insert('spschema_form', array(
                'ViewSet' => $view['ViewSet'],
                'Table' => $view['Table'],
                'Form' => $view['Form']
            ));
            switch ($view['ViewSet']) {
                case 'Collection':
                    $doc = $collforms;
                    break;
                case 'Discipline':
                    $doc = $discforms;
                    break;
                case 'Common':
                    $doc = $commforms;
                    break;
            }
            
            $xpath = new DOMXPath($doc);
            $elements = $xpath->query("*/viewdef[@name='$view[Form]']");
            
            if ($elements) {
                foreach ($elements as $element) {
                    $viewdef = array();
                    $name = $element->getAttribute('name');
                    $namebits = explode(' ', $name);
                    if (count($namebits) == 1 || !in_array($namebits[count($namebits)-1], array('Table', 'IconView'))) {
                        $viewdef['name'] = $name;
                        $cells = $element->getElementsByTagName('cell');
                        if ($cells->length) {
                            $viewdef['fields'] = array();
                            foreach ($cells as $cell) {
                                if ($cell->getAttribute('type') == 'field') {
                                    if ($cell->getAttribute('uitype') == 'plugin' &&
                                            $cell->getAttribute('uifieldformatter') == 'Date') {
                                        $init = $cell->getAttribute('initialize');
                                        $initbits = explode(';', $init);
                                        $params = array();
                                        foreach ($initbits as $p) {
                                            $p = explode('=', $p);
                                            $params[$p[0]] = $p[1];
                                        }
                                        $field = array(
                                            'ViewSet' => $view['ViewSet'],
                                            'Table' => $view['Table'],
                                            'Form' => $view['Form'],
                                            'Field' => $params['df']
                                        );
                                    }
                                    elseif ($cell->getAttribute('uitype') == 'querycbx') {
                                        $init = $cell->getAttribute('initialize');
                                        $initbits = explode(';', $init);
                                        $params = array();
                                        foreach ($initbits as $p) {
                                            $p = explode('=', $p);
                                            if (count($p) == 2)
                                                $params[$p[0]] = $p[1];
                                        }
                                        $field = array(
                                            'ViewSet' => $view['ViewSet'],
                                            'Table' => $view['Table'],
                                            'Form' => $view['Form'],
                                            'Field' => $params['name'] . 'ID'
                                        );
                                    }
                                    else {
                                        $fieldname = $cell->getAttribute('name');
                                        if (!strpos($fieldname, '.')) 
                                            $field = array(
                                                'ViewSet' => $view['ViewSet'],
                                                'Table' => $view['Table'],
                                                'Form' => $view['Form'],
                                                'Field' => $fieldname
                                            );
                                        else {
                                            $fieldname = explode('.', $fieldname);
                                            $n = count($fieldname);
                                            $field = array(
                                                'ViewSet' => $view['ViewSet'],
                                                'Table' => $fieldname[$n-2],
                                                'Form' => $view['Form'],
                                                'Field' => $fieldname[$n-1]
                                            );
                                        }
                                    }
                                    $viewdef['fields'][] = $field;
                                    $this->db->insert('spschema_formfield', $field);
                                }
                            }
                        }
                        //print_r($fields);
                    }
                }
                $viewdefs[] = $viewdef;
            }
        }
        //print_r($viewdefs);
    }
    
    public function getFormsForTable($table) {
        $ret = array();
        $query = $this->db->query("SELECT group_concat(distinct ViewSet) as ViewSet, group_concat(distinct `Table`) as `Table`, Form
            FROM spschema_form s
            WHERE `Table`='$table'
            GROUP BY Form
            -- ORDER BY IF(ViewSet='Collection', 1, IF(ViewSet='Discipline', 2, IF(ViewSet='Common', 3, 4)))");
        if ($query->num_rows()) {
            foreach ($query->result() as $row) {
                $ret[] = array(
                    'ViewSet' => $row->ViewSet,
                    'Table' => $row->Table,
                    'Form' => $row->Form,
                    'View' => $this->getView($row->Form, $row->ViewSet)
                );
            }
        }
        return $ret;
    }
    
    public function getView($form, $viewset) {
        if (isset($this->session->userdata['db']) && $this->session->userdata['db'] == 'development') {
            $subdir = 'development';
        }
        else {
            $subdir = 'melisr';
        }
        
        $doc = new DOMDocument();
        
        switch ($viewset) {
            case 'Collection':
                $doc->load(getcwd() . "/forms/$subdir/botany.views.collection.xml");
                break;

            case 'Discipline':
                $doc->load(getcwd() . "/forms/$subdir/botany.views.discipline.xml");
                break;

            case 'Common':
                $doc->load(getcwd() . "/forms/$subdir/common.views.xml");
                break;

            case 'Global':
                $doc->load(getcwd() . "/forms/$subdir/global.views.xml");
                break;

            default:
                break;
        }
        
        $xpath = new DOMXPath($doc);
        $views = $xpath->query("*/view[@name='$form']");
        if ($views->length) {
            $ret = array();

            $view = $views->item(0);
            $ret['view'] = $doc->saveXML($view);
            $viewdefname = $view->getElementsByTagName('altview')->item(0)->getAttribute('viewdef');
            
            $ret['viewdefs'] = array();
            $viewdefs = $xpath->query("*/viewdef[@name='$viewdefname']");
            if (!$viewdefs->length)
                $viewdefs = $xpath->query("*/viewdef[starts-with(@name, '$viewdefname ')]");
            foreach ($viewdefs as $viewdef) {
                $ret['viewdefs'][] = array(
                    'name' => $viewdef->getAttribute('name'),
                    'def' => $doc->saveXML($viewdef)
                );
            }
            
            return $ret;
        }
    }
}


/* End of file specifyschemamodel.php */
/* Location: ./models/specifyschemamodel.php */