<?php require_once('includes/header.php'); ?>

<?php if (!isset($trigger)): ?>
<h2>Triggers</h2>
<?php endif; ?>

<p><?=form_dropdown('trigger', $triggers, (isset($trigger)) ? $trigger['TRIGGER_NAME'] : '');?></p>

<?php if (isset($trigger) && $trigger): ?>
<?php 
    require_once('../lib/geshi/geshi.php');

    $stmt = str_replace("\t\t", "\t", $trigger['ACTION_STATEMENT']);
    $stmt = str_replace("\t", "    ", $stmt);
    $stmt = str_replace(array('<', '>'), array('&lt;', '&gt;'), $stmt);
    $sql = "DROP TRIGGER IF EXISTS $trigger[TRIGGER_NAME];\r\n\r\n";
    $sql .= "DELIMITER $$\r\n\r\n";
    $sql .= "CREATE TRIGGER $trigger[TRIGGER_NAME] $trigger[ACTION_TIMING] $trigger[EVENT_MANIPULATION] ON $trigger[EVENT_OBJECT_TABLE]\r\n";
    $sql .= "FOR EACH ROW\r\n";
    $sql .= "  $stmt\r\n\r\n";
    $sql .= "DELIMITER ;";
    
    $geshi = new GeSHi($sql, 'sql');
?>
<h2><?=$trigger['TRIGGER_NAME']?></h2>
<div class="code">
<?=$geshi->parse_code(); ?>
</div>
<?php endif; ?>

<?php require_once('includes/footer.php'); ?>
