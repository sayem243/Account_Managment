jQuery(document).ready(function () {
    jQuery('body').on('change','.loan_from_value_company', function () {
        var companyId= jQuery(this).val();
        if(companyId===0||companyId===''){
            var dataOption='<option value="">Select Bank</option>';
            jQuery('#bank_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/'+companyId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Bank</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('#bank_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.bank_id', function () {
        var companyId= jQuery('.loan_from_value_company').val();
        var bankId= jQuery(this).val();
        if(companyId===0||companyId===''||bankId===0||bankId===''){
            var dataOption='<option value="">Select Branch</option>';
            jQuery('#branch_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/branch/'+companyId+'/'+bankId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Branch</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('#branch_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.branch_id', function () {
        var companyId= jQuery('.loan_from_value_company').val();
        var bankId= jQuery('.bank_id').val();
        var branchId= jQuery(this).val();
        if(companyId===0||companyId===''|| bankId===0|| bankId===''|| branchId===0|| branchId===''){
            var dataOption='<option value="">Select Account</option>';
            jQuery('#bank_account_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/branch/account/'+companyId+'/'+bankId+'/'+branchId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Account</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('#bank_account_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.check_loan_from', function () {
        var from_to_type= jQuery(this).val();
        var user_section = jQuery('.check_loan_user_section');
        var company_section = jQuery('.check_loan_company_section');
        var project_section = jQuery('.check_loan_project_section');
        var other_section = jQuery('.check_loan_other_section');

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

    jQuery('body').on('change','.loan_to_value_company', function () {
        var companyId= jQuery(this).val();
        if(companyId===0||companyId===''){
            var dataOption='<option value="">Select Bank</option>';
            jQuery('#loan_to_bank_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/'+companyId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Bank</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('#loan_to_bank_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.loan_to_bank_id', function () {
        var companyId= jQuery('.loan_to_value_company').val();
        var bankId= jQuery(this).val();
        if(companyId===0||companyId===''||bankId===0||bankId===''){
            var dataOption='<option value="">Select Branch</option>';
            jQuery('#loan_to_branch_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/branch/'+companyId+'/'+bankId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Branch</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('#loan_to_branch_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.loan_to_branch_id', function () {
        var companyId= jQuery('.loan_to_value_company').val();
        var bankId= jQuery('.loan_to_bank_id').val();
        var branchId= jQuery(this).val();
        if(companyId===0||companyId===''|| bankId===0|| bankId===''|| branchId===0|| branchId===''){
            var dataOption='<option value="">Select Account</option>';
            jQuery('#loan_to_bank_account_id').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/branch/account/'+companyId+'/'+bankId+'/'+branchId,
            data:{},
            success:function(data){
                var dataOption='<option value="">Select Account</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                jQuery('#loan_to_bank_account_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.loan_to', function () {
        var from_to_type= jQuery(this).val();
        var user_section = jQuery('.to_user_section');
        var company_section = jQuery('.to_company_section');
        var project_section = jQuery('.to_project_section');
        var other_section = jQuery('.to_other_section');

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