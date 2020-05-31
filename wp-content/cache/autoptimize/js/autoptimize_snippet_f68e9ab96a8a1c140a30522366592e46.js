jQuery(document).ready(function($){function isValidRecaptcha(){$recap=$('#1xq8nm input[name="recaptcha_response"]').val();if($recap.length&&!$recap!==''&&$recap!==undefined){return true;}
return false;}
function isValidEmail(){$email=$('#1xq8nm input[name="email"]').val();if($email.length&&$email.indexOf('@')>-1){return true;}
return false;}
function isValidName(){$name=$('#1xq8nm input[name="first_name"]').val();if($name.length&&$name!==''){return true;}
return false;}
function notBotz(){$botz=$('#1xq8nm input[name="a_password"]').val();if(!$botz.length||$botz===''||$botz==undefined||!$botz){return true;}
$('#1xq8nm input[name="email"]').val('');$('#1xq8nm input[name="first_name"]').val('');$('#1xq8nm input[name="a_password"]').val('');return false;}
$('.form-submit').click(function(e){e.preventDefault();formData=$('#1xq8nm').serialize();console.log(formData);console.log(formData)
if(!isValidEmail()){alert('add email');}else if(!isValidName()){alert('add name')}else if(!notBotz()){alert("no botz please")}else if(!isValidRecaptcha()){alert("no botz please")}else{$('#1xq8nm input[name="email"]').val('');$('#1xq8nm input[name="first_name"]').val('');$('#1xq8nm input[name="a_password"]').val('');formSubmit()}});function formSubmit(){$.ajax({type:'POST',url:'/wp-content/themes/potc/ml-submit.php',data:formData,success:function(data){window.location.href='https://pediatricotcourses.com/thank-you';console.log(data)}});}});