<?php 
    $text = get_field('no_image_optin_text', 'option');
?>
<section class="no-image-optin__section">

    <div class="no-image-optin__form">
        <div class="no-image-optin__form__text">
            <?php echo $text ?>
        </div>
        <form method="post" action="https://sendfox.com/form/10zgnm/1xq8nm" class="sendfox-form" id="1xq8nm"
            data-async="true">
            <p><input type="text" placeholder="First Name" name="first_name" required /></p>
            <p><input type="email" placeholder="Email" name="email" required /></p>
            <!-- no botz please -->
            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="a_password"
                    tabindex="-1" value="" autocomplete="off" /></div>
            <p><button type="submit">Let's Go!</button></p>
        </form>
        <script src="https://sendfox.com/js/form.js"></script>

    </div>

</section>