<?php require_once('includes/header.php'); 
    require_once('../lib/geshi/geshi.php');?>


<?php if (isset($map_collectionsdb)): ?>

<div id="tabs">
    <ul>
        <li><a href="#tab1">Collections database</a></li>
        <li><a href="#tab2">Herbarium transactions</a></li>
    </ul>    
    
    <div id="tab1">
        <map name="schema" id="schema"> 
<area shape="rect" coords="106,109,288,135" href="<?=site_url()?>specifyschema/table/collectingeventattachment" alt="" />
<area shape="rect" coords="241,157,384,184" href="<?=site_url()?>specifyschema/table/collectingeventattribute" alt="" />
<area shape="rect" coords="39,200,138,228" href="<?=site_url()?>specifyschema/table/collectingtrip" alt="" />
<area shape="rect" coords="205,237,320,263" href="<?=site_url()?>specifyschema/table/collectingevent" alt="" />
<area shape="rect" coords="62,356,159,385" href="<?=site_url()?>specifyschema/table/localitydetail" alt="" />
<area shape="rect" coords="155,431,218,458" href="<?=site_url()?>specifyschema/table/locality" alt="" />
<area shape="rect" coords="33,440,117,468" href="<?=site_url()?>specifyschema/table/geography" alt="" />
<area shape="rect" coords="24,504,143,534" href="<?=site_url()?>specifyschema/table/geocoorddetail" alt="" />
<area shape="rect" coords="107,565,237,592" href="<?=site_url()?>specifyschema/table/localityattachment" alt="" />
<area shape="rect" coords="69,712,159,738" href="<?=site_url()?>specifyschema/table/attachment" alt="" />
<area shape="rect" coords="82,774,261,804" href="<?=site_url()?>specifyschema/table/attachmentimageattribute" alt="" />
<area shape="rect" coords="530,125,638,157" href="<?=site_url()?>specifyschema/table/otheridentifier" alt="" />
<area shape="rect" coords="439,272,608,302" href="<?=site_url()?>specifyschema/table/collectionobjectattribute" alt="" />
<area shape="rect" coords="628,260,751,306" href="<?=site_url()?>specifyschema/table/collectionobjectattachment" alt="" />
<area shape="rect" coords="574,361,691,393" href="<?=site_url()?>specifyschema/table/collectionobject" alt="" />
<area shape="rect" coords="336,356,419,387" href="<?=site_url()?>specifyschema/table/accession" alt="" />
<area shape="rect" coords="383,483,495,515" href="<?=site_url()?>specifyschema/table/project_colobj" alt="" />
<area shape="rect" coords="513,508,622,542" href="<?=site_url()?>specifyschema/table/dnasequence" alt="" />
<area shape="rect" coords="423,548,489,582" href="<?=site_url()?>specifyschema/table/project" alt="" />
<area shape="rect" coords="364,666,439,699" href="<?=site_url()?>specifyschema/table/collector" alt="" />
<area shape="rect" coords="528,689,588,718" href="<?=site_url()?>specifyschema/table/agent" alt="" />
<area shape="rect" coords="401,729,505,761" href="<?=site_url()?>specifyschema/table/groupperson" alt="" />
<area shape="rect" coords="511,777,640,809" href="<?=site_url()?>specifyschema/table/agentattachment" alt="" />
<area shape="rect" coords="783,64,842,95" href="<?=site_url()?>specifyschema/table/taxon" alt="" />
<area shape="rect" coords="787,152,889,179" href="<?=site_url()?>specifyschema/table/determination" alt="" />
<area shape="rect" coords="922,41,1056,72" href="<?=site_url()?>specifyschema/table/taxontreedefitem" alt="" />
<area shape="rect" coords="899,102,1026,130" href="<?=site_url()?>specifyschema/table/taxonattachment" alt="" />
<area shape="rect" coords="891,267,974,299" href="<?=site_url()?>specifyschema/table/container" alt="" />
<area shape="rect" coords="853,361,962,395" href="<?=site_url()?>specifyschema/table/exsiccataitem" alt="" />
<area shape="rect" coords="1022,361,1102,395" href="<?=site_url()?>specifyschema/table/exsiccata" alt="" />
<area shape="rect" coords="846,471,989,504" href="<?=site_url()?>specifyschema/table/conservdescription" alt="" />
<area shape="rect" coords="1034,472,765,503" href="<?=site_url()?>specifyschema/table/conservevent" alt="" />
<area shape="rect" coords="901,521,1013,568" href="<?=site_url()?>specifyschema/table/conserveventattachment" alt="" />
<area shape="rect" coords="784,655,874,688" href="<?=site_url()?>specifyschema/table/preparation" alt="" />
<area shape="rect" coords="532,655,991,682" href="<?=site_url()?>specifyschema/table/preptype" alt="" />
<area shape="rect" coords="768,755,831,785" href="<?=site_url()?>specifyschema/table/permit" alt="" />
<area shape="rect" coords="862,789,993,819" href="<?=site_url()?>specifyschema/table/permitattachment" alt="" />
        </map>
        <img id="model" src="<?=base_url()?>images/map.collectionsdb.png" usemap="#schema" width="1170" height="877" alt="Specify data model" />
    </div>
    <div id="tab2">
        <map name="transactions_schema" id="transactions_schema"> 
<area shape="rect" coords="104,166,282,197" href="<?=site_url()?>specifyschema/table/loanreturnpreparation" alt="" />
<area shape="rect" coords="168,221,297,250" href="<?=site_url()?>specifyschema/table/loanpreparation" alt="" />
<area shape="rect" coords="367,215,458,247" href="<?=site_url()?>specifyschema/table/loanagent" alt="" />
<area shape="rect" coords="316,277,370,310" href="<?=site_url()?>specifyschema/table/loan" alt="" />
<area shape="rect" coords="98,305,223,339" href="<?=site_url()?>specifyschema/table/loanattachment" alt="" />
<area shape="rect" coords="814,599,984,628" href="<?=site_url()?>specifyschema/table/loanreturnpreparation" alt="" />
<area shape="rect" coords="874,512,1002,541" href="<?=site_url()?>specifyschema/table/loanpreparation" alt="" />
<area shape="rect" coords="659,632,748,663" href="<?=site_url()?>specifyschema/table/loanagent" alt="" />
<area shape="rect" coords="789,538,842,570" href="<?=site_url()?>specifyschema/table/loan" alt="" />
<area shape="rect" coords="781,662,906,691" href="<?=site_url()?>specifyschema/table/loanattachment" alt="" />
<area shape="rect" coords="334,369,413,397" href="<?=site_url()?>specifyschema/table/shipment" alt="" />
<area shape="rect" coords="707,404,791,435" href="<?=site_url()?>specifyschema/table/shipment" alt="" />
<area shape="rect" coords="540,337,601,369" href="<?=site_url()?>specifyschema/table/agent" alt="" />
<area shape="rect" coords="232,408,329,438" href="<?=site_url()?>specifyschema/table/preparation" alt="" />
<area shape="rect" coords="869,402,822,433" href="<?=site_url()?>specifyschema/table/preparation" alt="" />
<area shape="rect" coords="810,177,936,211" href="<?=site_url()?>specifyschema/table/giftattachment" alt="" />
<area shape="rect" coords="674,190,760,225" href="<?=site_url()?>specifyschema/table/giftagent" alt="" />
<area shape="rect" coords="856,243,972,275" href="<?=site_url()?>specifyschema/table/giftpreparation" alt="" />
<area shape="rect" coords="759,273,808,305" href="<?=site_url()?>specifyschema/table/gift" alt="" />
<area shape="rect" coords="422,582,536,612" href="<?=site_url()?>specifyschema/table/exchangein" alt="" />
<area shape="rect" coords="84,631,173,666" href="<?=site_url()?>specifyschema/table/attachment" alt="" />
<area shape="rect" coords="95,695,278,725" href="<?=site_url()?>specifyschema/table/attachmentimageattribute" alt="" />
<area shape="rect" coords="249,1824,729,1903" href="<?=site_url()?>specifyschema/table/attachmentimageattribute" alt="" />
        </map> 
    <img src="<?=base_url()?>images/map.transactions.png" usemap="#transactions_schema" width="1170" height="877" alt="Specify herbarium procedures" />
    </div>
</div>
<?php endif; ?>

<?php if (isset($tables) && $tables): ?>
<h2>Tables</h2>
<table class="schema-table tables">
    <thead>
        <tr>
            <th>Name</th>
            <th>Title</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tables as $row): ?>
        <tr>
            <td><?=anchor(base_url() . 'specifyschema/table/' . $row['TableName'], $row['TableName']);?></td>
            <td><?=$row['TableTitle']?></td>
            <td><?=$row['TableDescription']?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php elseif (isset($table_info) && $table_info): ?>
<h2><?=$table_info['TableName']?></h2>
<div id="tabs">
    <ul>
        <li><a href="#tab1">Table info.</a></li>
        <?php if ($forms): ?>
        <li><a href="#tab2">Forms</a></li>
        <?php endif; ?>
        <?php if ($triggers): ?>
        <li><a href="#tab3">Triggers</a></li>
        <?php endif; ?>
    </ul>    
    
    <div id="tab1">
        <h3>Table info.</h3>
        <table class="table-info">
            <col/><col/>
            <tr>
                <th>Title</th>
                <td><?=$table_info['TableTitle']?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?=$table_info['TableDescription']?></td>
            </tr>
        </table>

        <h3>Fields</h3>
        <table class="schema-table fields">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Required</th>
                    <th>Index</th>
                    <th>Hidden</th>
                    <th>On form</th>
                    <th>Title</th>
                    <th>Pick list</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fields as $field): ?>
                <tr id="<?=$field['FieldName']?>">
                    <td><?=$field['FieldName']?></td>
                    <td><?=$field['FieldType']?></td>
                    <td><input type="checkbox"<?=($field['IsRequired']==1 || $field['IsNullable']=='NO') ? ' checked="checked"' : '';?>/></td>
                    <td><?=$field['FieldKey']?></td>
                    <td><input type="checkbox"<?=($field['IsHidden']==1) ? ' checked="checked"' : '';?>/></td>
                    <td><input type="checkbox"<?=($field['IsOnForm']==1) ? ' checked="checked"' : '';?>/></td>
                    <td><?=$field['FieldTitle']?></td>
                    <td><?=$field['PickListName']?>
                    <?php if ($field['PickListName'] && isset($picklists[$field['PickListName']])): ?>
                        <ul class="pick-list-items">
                            <?php foreach ($picklists[$field['PickListName']] as $item): ?>
                            <li><?=$item['Title']?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    </td>
                    <td><?=$field['FieldDescription']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Indexes</h3>
        <table class="schema-table indexes">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Fields</th>
                    <th>Unique</th>
                    <th>Nullable</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($indexes as $index): ?>
                <tr>
                    <td><?=$index['Key_name']?></td>
                    <td><?=$index['Columns']?></td>
                    <td><input type="checkbox"<?=(!$index['Non_unique']) ? ' checked="checked"' : '';?>/></td>
                    <td><input type="checkbox"<?=($index['IsNullable']) ? ' checked="checked"' : '';?>/></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if($one_to_many): ?>
        <h3>One-to-many relationships</h3>
        <table class="schema-table relationships">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Field</th>
                    <th>Related table</th>
                    <th>Related field</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($one_to_many as $row): ?>
                <tr>
                    <td><?=$row['RelationshipName']?></td>
                    <td><?=$row['ToColumnName']?></td>
                    <td><?=anchor(base_url() . 'specifyschema/table/' . $row['FromTableName'], $row['FromTableName']);?></td>
                    <td><?=$row['FromColumnName']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <?php if($many_to_one): ?>
        <h3>Many-to-one relationships</h3>
        <table class="schema-table relationships">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Field</th>
                    <th>Related table</th>
                    <th>Related field</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($many_to_one as $row): ?>
                <tr>
                    <td><?=$row['RelationshipName']?></td>
                    <td><?=$row['FromColumnName']?></td>
                    <td><?=anchor(base_url() . 'specifyschema/table/' . $row['ToTableName'], $row['ToTableName']);?></td>
                    <td><?=$row['ToColumnName']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    
    <div id="tab3">
        <?php if ($triggers): ?>
        <?php foreach ($triggers as $trigger): ?>
        <?php 
            $stmt = str_replace("\t\t", "\t", $trigger['Statement']);
            $stmt = str_replace("\t", "    ", $stmt);
            $stmt = str_replace(array('<', '>'), array('&lt;', '&gt;'), $stmt);
            $sql = "DROP TRIGGER IF EXISTS $trigger[Trigger];\r\n\r\n";
            $sql .= "DELIMITER $$\r\n\r\n";
            $sql .= "CREATE TRIGGER $trigger[Trigger] $trigger[Timing] $trigger[Event] ON $trigger[Table]\r\n";
            $sql .= "FOR EACH ROW\r\n";
            $sql .= "  $stmt\r\n\r\n";
            $sql .= "DELIMITER ;";

            $geshi = new GeSHi($sql, 'sql');
        ?>
        
        <h3><?=$trigger['Trigger']?></h3>
        <table class="trigger">
            <tr>
                <td><b>Event</b></td><td><?=$trigger['Event']?></td>
            </tr>
            <tr>
                <td><b>Timing</b></td><td><?=$trigger['Timing']?></td>
            </tr>
            <tr>
                <td colspan="2" class="code">
                    <b>Statement:</b><br/>
                    <?=$geshi->parse_code(); ?>
                </td>
            </tr>
        </table>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div id="tab2">
        <?php if ($forms): ?>
        <?php foreach($forms as $form): ?>
        <?php $view = $form['View']['view'];
          if ($view): ?>
        <h3><span class="view-label">View: </span><?=$form['Form']?> <span class="viewset">(<?=$form['ViewSet']?>)</span></h3>
        <?php 
            $openingtag = substr($view, 0, strpos($view, '>'));
            $newopeningtag = '<view ' . str_replace(' ', "\n              ", substr($openingtag, strlen('<view ')));
            $view = $newopeningtag . substr($view, strlen($openingtag));
        ?>
        
        <?php $geshi = new GeSHi(str_replace("\n        ", "\n", $view), 'xml');?>
        <div><?=$geshi->parse_code(); ?></div>
        
        <?php if(isset($form['View']['viewdefs'])): ?>
        <?php foreach ($form['View']['viewdefs'] as $viewdef): ?>
        <h4><span class="view-label">View def.: </span><?=$viewdef['name']?></h4>
        <?php 
            $openingtag = substr($viewdef['def'], 0, strpos($viewdef['def'], '>'));
            $newopeningtag = '<viewdef ' . preg_replace('/ ([a-z]+)=/', "\n              $1=", substr($openingtag, strlen('<viewdef ')));
            $view = $newopeningtag . substr($viewdef['def'], strlen($openingtag));
        ?>
        
        <?php $geshi = new GeSHi(str_replace("\n        ", "\n", $view), 'xml');?>
        <div><?=$geshi->parse_code();?></div>
        <?php endforeach; ?>
        <?php endif; ?>
        <div>&nbsp;</div>
        <?php endif; ?>
        <?php endforeach;?>
        <?php endif; ?>
    </div>
</div>

<?php endif; ?>

<?php require_once('includes/footer.php'); ?>
