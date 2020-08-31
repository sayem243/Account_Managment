jQuery(document).ready(function () {

    jQuery('body').on('change','.cash_loan_from', function () {
        var from_to_type= jQuery(this).val();
        var user_section = jQuery('.cash_loan_user_section');
        var company_section = jQuery('.cash_loan_company_section');
        var project_section = jQuery('.cash_loan_project_section');
        var other_section = jQuery('.cash_loan_other_section');

        if (from_to_type==="USER"){
            user_section.show();
            company_section.hide();
            project_section.hide();
            other_section.hide();
        }else if (from_to_type==="COMPANY"){
            user_section.hide();
            company_section.show();
            project_section.hide();
            other_section.hide();
        }else if (from_to_type==="PROJECT"){
            user_section.hide();
            company_section.hide();
            project_section.show();
            other_section.hide();
        }else if (from_to_type==="OTHERS"){
            user_section.hide();
            company_section.hide();
            project_section.hide();
            other_section.show();
        }

    });

    // to section

    jQuery('body').on('change','.cash_loan_to', function () {
        var from_to_type= jQuery(this).val();
        var user_section = jQuery('.cash_loan_to_user_section');
        var company_section = jQuery('.cash_loan_to_company_section');
        var project_section = jQuery('.cash_loan_to_project_section');
        var other_section = jQuery('.cash_loan_to_other_section');

        if (from_to_type==="USER"){
            user_section.show();
            company_section.hide();
            project_section.hide();
            other_section.hide();
        }else if (from_to_type==="COMPANY"){
            user_section.hide();
            company_section.show();
            project_section.hide();
            other_section.hide();
        }else if (from_to_type==="PROJECT"){
            user_section.hide();
            company_section.hide();
            project_section.show();
            other_section.hide();
        }else if (from_to_type==="OTHERS"){
            user_section.hide();
            company_section.hide();
            project_section.hide();
            other_section.show();
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