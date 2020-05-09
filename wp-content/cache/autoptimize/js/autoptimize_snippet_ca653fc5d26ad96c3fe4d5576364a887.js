jQuery(document).ready(function($){function isValidEmail(){$email=$('#1xq8nm input[name="email"]').val();if($email.length&&$email.indexOf('@')>-1){return true;}
return false;}
function isValidName(){$name=$('#1xq8nm input[name="first_name"]').val();if($name.length&&$name!==''){return true;}
return false;}
function notBotz(){$botz=$('#1xq8nm input[name="a_password"]').val();if(!$botz.length||$botz===''||$botz==undefined||!$botz){return true;}
return false;}
$('.form-submit').click(function(e){e.preventDefault();formData=$('#1xq8nm').serialize();formData=JSON.parse(formData)
if(!isValidEmail()){alert('add email');}else if(!isValidName()){alert('add name')}else if(!notBotz()){alert("no botz please")}else{formSubmit()}});function formSubmit(){$.ajax({type:'POST',url:'/wp-content/themes/potc/ml-submit.php',data:formData,success:function(data){console.log(data)}});}});