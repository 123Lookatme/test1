/**
 * Created by user on 25.09.14.
 */
$(document).ready(function(){
    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    /*FORM CREATION*/
    $('#selecttype').on('change',function(){
        $('.error').html('');
        var select=$(this).find('option:selected');
        var selectId=select.val();
        var selecttext=select.text();
        var layout=$('.layout');
        if(selectId>0)
        {
            layout.remove();
            var group=$('#selectgroup');
            getGroupList(selectId).done(function(data){
                var options=JSON.parse(data);
                group.html('<option value="0">---Select group---</option>');
                for(var i=0;i<options.length;i++)
                {
                    group.append('<option value="'+options[i].id+'">'+options[i].name+'</option>');
                }
                $('.type').siblings().show();
                $('.name input').attr('name',selecttext).attr('placeholder',selecttext+' name');
                if(selectId==2)
                {
                    getLayoutList().done(function(data){
                        if(data)
                        {
                            var options=JSON.parse(data);
                            $('.name').after($('.group').clone().attr('class','form-group layout'));
                            var layout=$('.layout');
                            $('label',layout).html('Layout').attr('for','selectlayout');
                            var select=$('select',layout).attr('id','selectlayout').attr('name','layout').html('<option value="0">---Select layout---</option>');
                            for(var i=0;i<options.length;i++)
                            {
                                select.append('<option value="'+options[i].id+'">'+options[i].name+'</option>');
                            }
                        }
                    });
                }
            });
        }
        else{
            $('.type').siblings().hide();
        }
    });

    /*FORM SUBMIT*/

    $('form').on('submit',function(e){
        e.preventDefault();
        var error='';
        var data={};
        $(':selected',this).each(function(){
            var value=$(this).val();
            var id=$(this).closest($('.col-md-4')).prev().html();
            if(value=='0')
                error+='Select '+id+'</br>';
            else{
                data[id]=value;
            }
        });
        $('input',this).each(function(){
            if($(this).val()=='')
                error+='Select '+$(this).closest($('.col-md-4')).prev().html()+'</br>';
            else{
                switch($(this).attr('type'))
                {
                    case'text':data[$(this).closest($('.col-md-4')).prev().html()]=$(this).val();
                        break;
                    case'file':;
                       break;
                }
            }
        });
        $('.error').html(error);
    });

    /*FILE UPLOAD*/
    $('.photo input').on('change',function(){
        var form=$('form');
        var formData= new FormData(form);
        loadImg(formData).done(function(data){
            //$('.img').css('background','url(./img/'+data+')');
            console.log(data);
        });
    });

/*LIBRARY*/



    function getGroupList(select)
    {
        if(select>0)
        {
            return $.ajax({
                type:'POST',
                url:'ajax.php',
                data:{get_list:'true'}
            });

        }else{
            return false;
        }
    }
    function getLayoutList()
    {
        return $.ajax({
            type:'POST',
            url:'ajax.php',
            data:{get_layout:'true'}
        });
    }

    function loadImg(formData)
    {
        return $.ajax({
            type:'POST',
            url: 'ajax.php',
            data:formData,
            contentType: false,
            cache:false,
            processData: false
        });
    }



});