var base = location.href.substr(0,location.href.lastIndexOf('/specifyschema'));
if (!base) {
    base = location.href.substr(0, location.href.length-1);
}

$(function() {
    $('select[name=table]').change(function() {
        location.href = base + '/specifyschema/table/' + $('select[name=table]').val();
    });
    
    $('.schema-table [type=checkbox]').parents('td').css('text-align', 'center');
    
    $('.schema-table [type=checkbox]').click(function(e) {
        e.preventDefault();
        return false;
    });
    
    $('.db-selector select').change(function() {
        location.href = base + '/specifyschema/changedb/' + $(this).val();
    });
    
    $('select[name=trigger]').change(function() {
        location.href = base + '/specifyschema/trigger/' + $(this).val();
    });
    
    $('#tabs').tabs();
});