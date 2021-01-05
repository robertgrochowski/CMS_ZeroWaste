<table>
    <th>Id Zamówienia</th><th>Status</th><th>Data i czas złożenia</th><?php if($admin)echo"<th>Złożona przez</th>";?><th>akcja</th>
    <?php
        foreach($complaints as $cmp)
        {
            $dt = new DateTime("now", new DateTimeZone('Europe/Warsaw'));
            $dt->setTimestamp($cmp->timestamp);
            $formatted_time = $dt->format('d/m/Y h:i');

            echo "<tr>";
            echo "<td><a href='/moje-konto/view-order/{$cmp->order_id}'>#{$cmp->order_id}</a></td>";
            echo "<td>{$cmp->status}</td>";
            echo "<td>{$formatted_time}</td>";
            if($admin)
                echo "<td>{$cmp->display_name}</td>";
            echo "<td><a href='{$cmp->id}' class='woocommerce-button button view'>Przejdź ></a></td>";
            echo "</tr>";
        }
    ?>
</table>

