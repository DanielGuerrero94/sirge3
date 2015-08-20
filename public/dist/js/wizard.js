searchVisible = 0;
transparent = true;

$(document).ready(function(){

    var $validator = $('#my-form').validate({
        rules : {
            nombre : {
                required: true,
                minlength: 4,
                maxlength: 30
            },
            apellido : {
                required: true,
                minlength: 4,
                maxlength: 30
            },
            email : {
                required: true,
                email: true,
                remote: 'checkemail'
            },
            sede : {
                required: true
            },
            fecha_nacimiento : {
                required: true
            },
            ocupacion : {
                required: true,
                minlength: 8,
                maxlength: 100
            },
            provincia : {
                required: true
            },
            pass : {
                required: true,
                minlength: 6,
                maxlength: 30
            },
            area : {
                required : true
            }
        }
    });

    /*  Activate the tooltips      */
    $('[rel="tooltip"]').tooltip();
    
        
    $('#wizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',
         onInit : function(tab, navigation,index){
         
           //check number of tabs and fill the entire row
           var $total = navigation.find('li').length;
           $width = 100/$total;
           
           $display_width = $(document).width();
           
           if($display_width < 400 && $total > 3){
               $width = 50;
           }
           navigation.find('li').css('width',$width + '%');
        },
         onTabClick : function(tab, navigation, index){
            // Disable the posibility to click on tabs
            return false;
        }, 
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            
            var wizard = navigation.closest('.wizard-card');
            
            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $(wizard).find('.btn-next').hide();
                $(wizard).find('.btn-finish').show();
            } else {
                $(wizard).find('.btn-next').show();
                $(wizard).find('.btn-finish').hide();
            }
        },
        onNext : function(tab, navigation, index){
            var $valid = $("#my-form").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
            }
        }
    });

    // Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });
    
    
    $('[data-toggle="wizard-radio"]').click(function(event){
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked','true');
    });
    
    $height = $(document).height();
    $('.set-full-height').css('height',$height);
    
    //functions for demo purpose
    
    
});


 //Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
    












