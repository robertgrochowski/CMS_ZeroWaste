<style>
.cs-complaint-card{
    width: 100%;
    min-height:150px;
    border-radius: 5px;
    padding:15px;
    margin: 0 auto;
    background-color:#eee;
    font-size:1.2em;
}
.cs-message{
    margin:10px;
    min-height:50px;
    padding:10px;
    border-radius: 15px;
    max-width: 80%;
}
.cs-employee {
    float:right;
    border:1px solid orange;
}
.cs-customer {
    float:left;
    border:1px solid gray;
}
.cs-user {
    text-align: center;
    vertical-align: middle;
    white-space:nowrap;
}
table td {
    padding:10px 5px 10px 5px !important;
}
table tbody tr:nth-child(2n) td {
    background-color: #F9F9F9 !important;
}
.cs-complaint-admin-panel {
    background-color: #eee;
    width:100%;
    padding:15px;
    font-size:1.2em;
    margin-bottom:10px;
}
.cs-complaint-admin-panel input {
    font-size:0.7em;
}
</style>
<?php if($admin): ?>
<div class="cs-complaint-admin-panel">
    <h4>Zarządzaj zgłoszeniem</h4>
    <div>
        <form action="<?php echo $_SERVER["REQUEST_URI"]?>" method="post">
        <b>Zmień status</b>:
                <select name="status" id="status">
                    <option value="open">W trakcie rozpatrywania</option>
                    <option value="closed">Zakończone</option>
                </select>
            <input type="submit"/>
        </form>
    </div>
</div>
<?php endif;?>
<div class="cs-complaint-card">
    <h4>Zgłoszenie #<?php echo $complaint->id?></h4>
    <div><b>Tytuł</b>: <?php echo $complaint->title;?></div>
    <div><b>Status</b>: <?php global $STATUS_TRANSLATION; echo $STATUS_TRANSLATION[$complaint->status];?></div>
    <div><b>Otwarto</b>: <?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $complaint->timestamp ), 'H:i:s d/m/Y' )?></div>
    <div><b>Treść</b>: <?php echo $complaint->description;?></div>
</div>

<table class="cs-table">
    <?php
        foreach($messages as $msg)
        {
            echo "<tr>";
            if($msg->is_admin == 1)
            {
                echo "<td width='15%'></td>";
                echo "<td width='70%'><div class='cs-message cs-employee'>$msg->message</div></td>";
                echo "<td width='15%' class='cs-user'><b>$msg->display_name<br>(Administrator)<br>$formatted_time</b></td>";
            }
            else
            {
                echo "<td class='cs-user'><b>$msg->display_name<br>(Ty)<br>$formatted_time</b></td>";
                echo "<td><div class='cs-message cs-customer'>$msg->message</div></td>";
                echo "<td></td>";
            }
            echo "</tr>";
        }
    ?>
</table>
<?php if($admin || $complaint->status != 'closed'): ?>
<h3>Napisz wiadomość</h3>
<form action="<?php echo $_SERVER["REQUEST_URI"]?>" method="post">
    <label for="message">Treść wiadomości<abbr class="required" title="required">*</abbr></label>
    <textarea name="message" id="message" required></textarea><br><br>
    <input type="submit"/>
</form>
<?php endif;?>

