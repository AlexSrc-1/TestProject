$('.BtnModalId').click(function(e){

    e.preventDefault();
    var modal = $('#your-modal');
    modal.modal('show')
        .find('#modalContent');
    modal.attr('order', $(this).attr('id_order'));
    modal.attr('performer_id', $(this).attr('desc_enable'));
    if($(this).attr('desc_enable') === "false"){
        $('#cause').prop("disabled", true);
    }
    else{
        $('#cause').prop("disabled", false);
    }

    return false;

});
var modal_error = $('.modal_error');
$(document).ready(function(){
    modal_error.hide();
});

$('#appointBtn').click(function(e){
    e.preventDefault();
    var url = 'index.php'
    var performer_options = $("#droplistuser-users")[0].options;
    var performer_id = performer_options[performer_options.selectedIndex].value
    var modal = $('#your-modal');
    if(modal.attr('performer_id') !== performer_id){
        $.get(url, {
            r:"order/update",
            order: modal.attr('order'),
            performer_id : performer_id,
            cause: $('#cause').val()}, function(data) {

        });
        // $( "tr[data-key='"+modal.attr('order')+"']" )
        $.pjax.reload({container: '#pjax_1'});
        modal.modal('hide');
    }else{
        modal_error.show();
    }
    return false;

});

$('#cancelBtn').click(function(e){
    e.preventDefault();
    var modal = $('#your-modal');
    $.pjax.reload({container: '#pjax_1'});
    modal.modal('hide');
    return false;

});
