jQuery(document).ready(function(){
    
    
    $('input:radio[name=\'MainModel[sourceType]\']').change(function(){
        let $this = $(this);
        let $divc = $('div.colors');
        let $divourc = $('#our_color');
        if ($this.val() == 2) {
            $divc.show();
            $divourc.show();
        } else {
            $divc.hide();
            $divourc.hide();
        }
    });
    let count = 0;
    $('#mainmodel-file').change(function(){
        let $this = $(this);
        let val = $this.val();
        checkForExamples(val);
        if (val) {
            $('#img-source').attr('src', '/uploads/' + val + '?r=' + Math.random());
            $('#a-source').attr('href', '/uploads/' + val + '?r=' + Math.random());
        }
        count++;
        if (count > 1) {
            $('.img-res').html('&nbsp;');
        }
    });
    
    $('#mainmodel-anttype').change(function(){
        let $this = $(this);
        let $divs = $('div.sigma');
        if ($this.val() == 2) {
            $divs.show();
        } else {
            $divs.hide();
        }
    });
    
    $('#mainmodel-m').change(function(){
        let $this = $(this);
        if ($this.val() != '') {
            $('#mainmodel-mpercent').val('');
        }
    });    
    
    $('#mainmodel-sigma').change(function(){
        let $this = $(this);
        if ($this.val() != '') {
            $('#mainmodel-sigmapercent').val('');
        }
    });    
    
    $('#mainmodel-mpercent').change(function(){
        let $this = $(this);
        if ($this.val() != '') {
            $('#mainmodel-m').val('');
        }
    });    
    
    $('#mainmodel-sigmapercent').change(function(){
        let $this = $(this);
        if ($this.val() != '') {
            $('#mainmodel-sigma').val('');
        }
    });   
    
    $('.colors input').change(function(){
        let val1 = $('.colors input').eq(0).val();
        let val2 = $('.colors input').eq(1).val();
        let val3 = $('.colors input').eq(2).val();
        let $res = $('#our_color');
        if (val1 && val2 && val3) {
            $res.css('background-color', 'rgb(' + val1 + ',' + val2 + ',' + val3 + ')');
        } else {
            $res.css('background-color', 'white');
        }
    });
    
    $('input:radio:checked[name=\'MainModel[sourceType]\']').trigger('change');
    $('#mainmodel-file').trigger('change');
    $('#mainmodel-anttype').trigger('change');
    $('.colors input').eq(0).trigger('change');
    
    function checkForExamples(val) {
        $radios = $('input:radio[name=\'MainModel[sourceType]\']');
        $radio1 = $radios.eq(0);
        $radio2 = $radios.eq(1);
        if (val == 'example_type1.jpg') {
            $radio1.prop("checked", true); 
            $radio1.trigger('change');
        } else if (val == 'example_type2__60_132_253.jpg') {
            $radio2.prop("checked", true); 
            $radio2.trigger('change');
            $('#mainmodel-colorred').val(60);
            $('#mainmodel-colorgreen').val(132);
            $('#mainmodel-colorblue').val(253);
            $('#mainmodel-colorblue').trigger('change');
        }
    }
});

