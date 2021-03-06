jQuery.fn.ajaxedForm = function(success){
    return this.each(function(){
        $(this).prepend('<input type="hidden" name="ajaxed" value="'+$(this).attr('id')+'">');
        $(this).ajaxForm({
            dataType: 'json',
            type: 'post',
            success: success
        });
        $(this).removeClass('ajax').addClass('ajaxed');
    });
}

function validateForm($id,data){
    $.each(data.errors,function(element,errors){
        $controls = $('#'+$id+'-'+element);
        if($controls.hasClass('error')){

        }
        else {
            $controls.addClass('error');
        }
        if($controls.find('.help-inline').length > 0){
            $errors = $controls.find('.help-inline').first();
            $errors.text('');
        }
        else {
            $errors = $('<p class="help-inline"></p>');
            $controls.find('.controls').append($errors);
        }
        $.each(errors,function(){
            $errors.html(this + "<br/>" + $errors.html());
        })
    });
}
$(document).ready(function(){
    $('body').on('click','form .error',function(){
        $group  = $(this);
        $element = $('.form-element',$group);
        $element.off('change.error').one('change.error',function(){
            if($group.hasClass('error')){
                $group.removeClass('error');
                $group.find('.help-inline').remove();
            }
        });
    });
    $('form select').each(function(){
        if($(this).attr('data-source')){
            $(this).ajaxChosen({
                method: 'GET',
                url: $(this).attr('data-source'),
                dataType: 'json'
            }, function (data) {
                var terms = {};

                $.each(data, function (i, val) {
                    terms[i] = val;
                });

                return terms;
            });
        } else {
            $(this).chosen({
                no_results_text: t("No results matched","Form")
            });
        }
    });
});
$(document).on('keyup','form input[data-source],form textarea[data-source]',function(event){
    $el = $(this);
    $source = $el.attr('data-source');
    if($source){
        $.ajax({
            url: $source,
            type: 'POST',
            data: 'value='+$el.val(),
            globalLoader: false,
            dataType: 'json',
            beforeSend: function(){
                $el.loading();
            },
            complete: function(){
                $el.loading();
            }
        });
    }
})
