<?php 
    $text = get_field('checklist_optin_text', 'option');
?>
<section class="in-post__section">
    <div class="in-post__section__wrapper">
        <div class="in-post__image" >
            <div class="image__wrapper">
            <img src="/wp-content/themes/potc/images/checklist-small.png" alt="checklist mockup">
            </div>
            
        </div>
        <div class="in-post__form">
            <div class="in-post__form__text">
                <?php echo $text ?>
            </div>
        <form method="post"  id="1xq8nm">
        <!-- <form method="post" action="https://sendfox.com/form/10zgnm/1xq8nm" class="sendfox-form" id="1xq8nm" data-async="true"> -->
<p><input type="text" placeholder="First Name" name="first_name" required /></p>
<p><input type="email" placeholder="Email" name="email" required /></p>
<!-- no botz please -->
<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="a_password" tabindex="-1" value="" autocomplete="off" /></div>
<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
<p><button class="form-submit" type="submit">Sign Me Up!</button></p>
</form>
<!-- <script src="https://sendfox.com/js/form.js"></script> -->
			
        </div>
    </div>
</section>