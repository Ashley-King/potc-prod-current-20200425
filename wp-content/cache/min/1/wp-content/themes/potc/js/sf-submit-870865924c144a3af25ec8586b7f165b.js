jQuery(document).ready(function($){function isValidEmail(){$email=$('#1xq8nm input[name="email"]').val();if($email.length&&$email.indexOf('@')>-1){return!0}
return!1}
function isValidName(){$name=$('#1xq8nm input[name="first_name"]').val();if($name.length&&$name!==''){return!0}
return!1}
function notBotz(){$botz=$('#1xq8nm input[name="a_password"]').val();if(!$botz.length||$botz===''||$botz==undefined||!$botz){return!0}
$('#1xq8nm input[name="email"]').val('');$('#1xq8nm input[name="first_name"]').val('');$('#1xq8nm input[name="a_password"]').val('');return!1}
$('.form-submit').click(function(e){e.preventDefault();formData=$('#1xq8nm').serialize();console.log(formData);if(!isValidEmail()){alert('add email')}else if(!isValidName()){alert('add name')}else if(!notBotz()){alert("no botz please")}else{$('#1xq8nm input[name="email"]').val('');$('#1xq8nm input[name="first_name"]').val('');$('#1xq8nm input[name="a_password"]').val('');formSubmit()}});function formSubmit(){$.ajax({type:'POST',url:'/wp-content/themes/potc/sf-submit.php',data:formData,success:function(data){window.location.href='https://pediatricotcourses.com/thank-you'}})}})