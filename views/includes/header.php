<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Specify schema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="http://www.rbg.vic.gov.au/common/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/rbgm.specifyschema.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>js/jquery.rbgm.specifyschema.js"></script>
</head>

<body>
    <div id="banner">
        <div class="clearfix">
            <h1>MEL Specify schema browser</h1>
        </div>
        <div class="clearfix">
            <div class="db-selector">
                <?php 
                    $options = array(
                        'default' => 'melisr',
                        'development' => 'development'
                    );
                ?>
                <?=form_dropdown(FALSE, $options, $db); ?>
            </div>
            <div id="version">
                <?php if (isset($version)): ?>
                <span class="version">
                    <span class="label">App. version:</span> <span><?=$version['AppVersion']?></span>
                </span>
                <span class="version">
                    <span class="label">Schema version:</span> <span><?=$version['SchemaVersion']?></span>
                </span>
                <?php endif; ?>
            </div>
            <div id="table-dropdown">
                <?php if (isset($table_dropdown)): ?>
                <?=form_dropdown('table', $table_dropdown, $this->uri->segment(3, ""));?>
                <?php endif; ?>
            </div>
        
        </div>
    </div>
    <div id="container">
