<h2 class='woocommerce-order-details__title'>Złóż zażalenie</h2>
<p>Proszę o podanie szczegółów zażalenia</p>
<form action="<?php echo $_SERVER["REQUEST_URI"]?>" method="post">
    <label for="cs_title">Tytuł<abbr class="required" title="required"> *</abbr></label><br/>
    <input style="width:100%" id="cs_title" type="text" name="title" placeholder="wpisz tytuł tutaj" required/><br/><br/>

    <label for="cs_description">Opis<abbr class="required" title="required"> *</abbr></label>
    <textarea id="cs_description" name="description" placeholder="wpisz opis tutaj" required></textarea><br/><br/>
    <input value="Wyślij" type="submit">
</form>