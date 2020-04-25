jQuery("document").ready(function($){
  var $form = $(".email-octopus-form");
    // ajaxEmailOctopusForm($(".email-octopus-form"));
    // function ajaxEmailOctopusForm($form){
      $form.submit(function(e){
        e.preventDefault();
        if (!isValidEmail($form)){
          Swal.fire({
            title: 'Please enter your email address :)', 
            confirmButtonText: 'OK'
          })
        }
        else if(!isValidName($form)){
          Swal.fire({
            title: 'Woops! Please enter your first name so we\'ll know what you\'d like to be called :)',
            confirmButtonText: 'OK'
          })
        }else if(!isValidFax($form)){
          Swal.fire({
            title: 'No robots allowed, please :)',
            confirmButtonText: 'OK'
          })
        }
        
        else(submitSubscribeForm($form))
      });
    // }//ajaxEmailOctopusForm

    //validate email
    function isValidEmail($form) {
      // If email is empty, show error message.
      // contains just one @
      var email = $form.find("input[name='field_0']").val();
      if (!email || !email.length) {
        return false;
      } else if (email.indexOf("@") == -1) {
        return false;
      }
      return true;
    }
    //validate name
    function isValidName($form) {
      // If email is empty, show error message.
      // contains just one @
      var firstName = $form.find("input[name='field_1']").val();
      if (!firstName || !firstName.length) {
        return false;
      } 
      return true;
    }
    function isValidFax($form){
      //if fax box is checked, return false
      var fax = $form.find("input[name='user[fax_number]']");
      if(fax.is(':checked')){
        return false;
      }
      return true;
    }

    function submitSubscribeForm($form){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "/wp-content/themes/potc/scripts/add-eo.php", 
        data: jQuery(".email-octopus-form").serialize(),
        // contentType: "application/json; charset=utf-8",
        success: function(newData) {
            //"code":"MEMBER_EXISTS_WITH_EMAIL_ADDRESS
            if(newData.id){
            window.location.href = "/thank-you";
            }else{
              var msg = JSON.stringify(newData);
              msg = JSON.parse(msg);
              if(msg.error.code == 'MEMBER_EXISTS_WITH_EMAIL_ADDRESS'){
                Swal.fire({
                  title: "Looks like you are already subscribed. Thank you!"
                })
              }else{
                Swal.fire({
                  title: "Something isn't working on our end....we are working to get this fixed soon!"
                })
              }
            }
            // else{
            //     alert(JSON.stringify(newData));
            // }
            $('input[name="field_1"], input[name="field_0"]').val('');
        },
        
      });
      
      return false;
    }

 



}); //end jQuery


