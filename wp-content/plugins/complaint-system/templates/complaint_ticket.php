<style>
.cs-complaint-card{
    width: 70%;
    min-height:150px;
    border-radius: 15px;
    padding:15px;
    border:2px dashed darkred;
}
.cs-message-wrapper {
    width:100%;
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
</style>
<div class="cs-complaint-card">
    <h2><?php echo $complaint->title;?></h2>
    <h4>Status: <?php echo $complaint->status;?></h4>
    <p><?php echo $complaint->description;?></p>
</div>

<table class="cs-table">
    <?php
        foreach($messages as $msg)
        {
            echo "<tr>";
            if($msg->is_admin == 1)
            {
                echo "<td></td>";
                echo "<td><div class='cs-message cs-employee'>$msg->message</div></td>";
                echo "<td class='cs-user'><b>$msg->display_name<br>(Administrator)</b></td>";
            }
            else
            {
                echo "<td class='cs-user'><b>$msg->display_name<br>(Ty)</b></td>";
                echo "<td><div class='cs-message cs-customer'>$msg->message</div></td>";
                echo "<td></td>";
            }
            echo "</tr>";
        }
    ?>
</table>

<h3>Napisz wiadomość</h3>
<form>
    <textarea>

    </textarea><br><br>
    <input type="submit"/>
</form>


