<h2 class='woocommerce-order-details__title'>Make a complaint</h2>
<p>Please give details about your complaint</p>
<form action="<?php echo $_SERVER["REQUEST_URI"]?>" method="post">
    <label for="cs_title">Title<abbr class="required" title="required"> *</abbr></label><br/>
    <input style="width:100%" id="cs_title" type="text" name="cs_title" placeholder="put your title here" required/><br/><br/>

    <label for="cs_description">Description<abbr class="required" title="required"> *</abbr></label>
    <textarea id="cs_description" name="cs_description" placeholder="put your description here" required></textarea><br/><br/>
    <input type="submit">
</form>