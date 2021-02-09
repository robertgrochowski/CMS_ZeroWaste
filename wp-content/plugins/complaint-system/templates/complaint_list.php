<?php if(count($complaints) < 1): ?>
<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info" role="alert">
    Brak złożonych zażaleń</div>
<?php elseif (count($complaints) > 0) :?>
<table>
    <th>Id Zamówienia</th><th>Status</th><th>Data i czas złożenia</th><?php if($admin)echo"<th>Złożona przez</th>";?><th>akcja</th>
    <?php
		if($admin || $seller)
			$link = '/panel/orders';
		else
			$link = "/moje-konto/view-order/{$cmp->order_id}";
		
        foreach($complaints as $cmp)
        {
            $dt = new DateTime("now", new DateTimeZone('Europe/Warsaw'));
            $dt->setTimestamp($cmp->timestamp);
            $formatted_time = $dt->format('d/m/Y h:i');
            global $STATUS_TRANSLATION;

            echo "<tr>";
            echo "<td><a href='{$link}'>#{$cmp->order_id}</a></td>";
            echo "<td>{$STATUS_TRANSLATION[$cmp->status]}</td>";
            echo "<td>{$formatted_time}</td>";
            if($admin)
                echo "<td>{$cmp->display_name}</td>";
            echo "<td><a href='{$cmp->id}' class='woocommerce-button button view'>Przejdź ></a></td>";
            echo "</tr>";
        }
    ?>
</table>
<?php endif?>
