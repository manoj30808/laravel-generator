(function($){
Unique_Add=0;  

  $.addmore = function (scontent,dcontent,addbtn,removebtn,now,tag,minRequired){
            var rowlength=parseInt($(tag).length);
            
            if(rowlength && Unique_Add==0)
            {
                Unique_Add=parseInt($(tag).length)-1;
            }
            if(now){
                Unique_Add=Unique_Add+1;
                var now = new Date(),
                now = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
                
                $(scontent).find('.timepicker').attr('value',now);
                var content=$(scontent).html();

                content=content.replace(/key/g,Unique_Add);
                content=content.replace("unique_Row","unique_Row"+Unique_Add);
                
                $(dcontent).append(content);                   
                
                $("body").on("focus",".datepicker",function(){
                    $(this).removeClass("hasDatepicker");
                    var date;
                    if($(this).val()==""){
                        date=new Date();
                    }else{
                        date=$(this).val();
                    }
                    $(this).datepicker({ 
                        defaultDate: +7,
                        showOtherMonths:true,
                        autoSize: true,
                        dateFormat: 'dd-mm-yy'
                    }).datepicker("setDate",date);  
                });
            }
            $(addbtn).click(function(){
                var lastrow=parseInt($(dcontent+" tr:last-child "+removebtn).attr("id"));
                if(lastrow > Unique_Add){
                    Unique_Add=lastrow;
                }
                Unique_Add=Unique_Add+1;
                
                var now = new Date(),
                now = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
                
                $(scontent).find('.timepicker').attr('value',now);
                
                var content=$(scontent).html();               

                content=content.replace(/key/g,Unique_Add);
                content=content.replace("unique_Row","unique_Row"+Unique_Add);                

                $(dcontent).append(content);

                //Dynamic Date-Picker 
                $("body").on("focus",".datepicker",function(){
                    $(this).removeClass("hasDatepicker");
                    var date;
                    if($(this).val()==""){
                        date=new Date();
                    }else{
                        date=$(this).val();
                    }
                    $(this).datepicker({ 
                        defaultDate: +7,
                        showOtherMonths:true,
                        autoSize: true,
                        dateFormat: 'dd-mm-yy'
                    }).datepicker("setDate",date);  
                });  
                //Dynamic searchable selete
                update_chosen();
                
                
                return false;
            });
           
            $("form").on("click",removebtn,function(){
                if($(dcontent+" "+tag).length > minRequired)                    
                    $(this).parents(tag).remove();
                return false; 
            });   
            update_chosen();
    }

    //Dynamic searchable selete
    function update_chosen(){
        /*$(".AddDynamicChosen .select-dynamic").each(function(){
            var chosen_id=$(this).attr("id");
            $(this).chosen();
            $(this).trigger("chosen:updated");
        });*/
    }
})(jQuery);