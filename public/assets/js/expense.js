jQuery(document).ready(function () {
    var main_element = jQuery('.card-body');
    main_element.on('change','.company_id', function () {
        var companyId= jQuery(this).val();
        // alert(companyId)
        if(companyId===0||companyId===''){
            var dataOption='<option value="">Select Bank</option>';
            main_element.find('.expense_bank_id').html(dataOption);

            var dataOption1='<option value="">Select Project</option>';
            main_element.find('.check_expense_project_id').html(dataOption1);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/ajax/company/bank/'+companyId,
            data:{},
            success:function(data){
                // console.log(data);
                var dataOption='<option value="">Select Bank</option>';
                jQuery.each(data, function(i, item) {
                    dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                });
                main_element.find('.expense_bank_id').html(dataOption);
            }
        });
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
                main_element.find('.check_expense_project_id').html(dataOption);
            }
        });

    });

    main_element.on('change','.expense_bank_id', function () {
        var companyId= main_element.find('.company_id').val();
        var bankId= jQuery(this).val();
        if(companyId===0||companyId===''||bankId===0||bankId===''){
            var dataOption='<option value="">Select Branch</option>';
            main_element.find('.branch_id').html(dataOption);
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
                main_element.find('.branch_id').html(dataOption);
            }
        });

    });

    main_element.on('change','.branch_id', function () {
        var companyId= main_element.find('.company_id').val();
        var bankId= main_element.find('.expense_bank_id').val();
        var branchId= jQuery(this).val();
        alert(bankId);
        if(companyId===0||companyId===''|| bankId===0|| bankId===''|| branchId===0|| branchId===''){
            var dataOption='<option value="">Select Account</option>';
            main_element.find('.bank_account_id').html(dataOption);

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
                main_element.find('.bank_account_id').html(dataOption);
            }
        });

    });

    jQuery('body').on('change','.from_to_type', function () {
        var from_to_type= jQuery(this).val();
        var user_section = jQuery('.user_section');
        var company_section = jQuery('.company_section');
        var project_section = jQuery('.project_section');
        var other_section = jQuery('.other_section');

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