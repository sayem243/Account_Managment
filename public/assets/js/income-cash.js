jQuery(document).ready(function () {
    jQuery('.cash_income_company_id').on('change', function () {
        var companyId= jQuery(this).val();
        if(companyId===0||companyId===''){
            var dataOption='<option value="">Select Project</option>';
            jQuery('.cash_income_project_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/project/company/'+companyId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Project</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('.cash_income_project_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.cash_income_from_to_type', function () {
        var from_to_type= jQuery(this).val();
        var user_section = jQuery('.cash_income_user_section');
        var company_section = jQuery('.cash_income_company_section');
        var project_section = jQuery('.cash_income_project_section');
        var client_section = jQuery('.cash_income_client_section');
        var other_section = jQuery('.cash_income_other_section');

        if (from_to_type==="USER"){
            user_section.show();
            company_section.hide();
            project_section.hide();
            client_section.hide();
            other_section.hide();
        }else if (from_to_type==="COMPANY"){
            user_section.hide();
            company_section.show();
            project_section.hide();
            client_section.hide();
            other_section.hide();
        }else if (from_to_type==="PROJECT"){
            user_section.hide();
            company_section.hide();
            project_section.show();
            client_section.hide();
            other_section.hide();
        }else if (from_to_type==="OTHERS"){
            user_section.hide();
            company_section.hide();
            project_section.hide();
            client_section.hide();
            other_section.show();
        }else if (from_to_type==="CLIENT"){
            user_section.hide();
            company_section.hide();
            project_section.hide();
            client_section.show();
            other_section.hide();
        }

    });

    jQuery('.check_amount').keyup(function () {
        jQuery('.to_word').text('');
        var check_amount= parseFloat(jQuery(this).val());

        if(jQuery(this).val()=='' || isNaN(check_amount)){
            jQuery('.to_word').text('');
            return false;
        }

        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/number/to/word/convert/'+check_amount,
            data:{},
            success:function(data){
                jQuery('.to_word').text(data.amount);
            }
        });
    });

});