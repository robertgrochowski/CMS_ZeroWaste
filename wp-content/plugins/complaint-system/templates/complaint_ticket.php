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
    <h2>Dostałem zepsute ziemniaki</h2>
    <h4>Status: oczekuje</h4>
    <p>gdzie pieniadze za las?Opis Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
</div>

<table class="cs-table">
    <tr>
        <td></td>
        <td><div class="cs-message cs-employee">Dokonano zwrotu pieniędzy. Przepraszamy za pomyłkę.</div></td>
        <td class="cs-user"><b>Kamil Nos<br>(Administrator)</b></td>
    </tr>
    <tr>
        <td class="cs-user"><b>Jan Kowalski<br>(Ty)</b></td>
        <td><div class="cs-message cs-customer">Ok spoko ziomeckzu a chcesz cos z avonu?</div></td>
        <td></td>
    </tr>
</table>
<h3>Napisz wiadomość</h3>
<form>
    <textarea>

    </textarea><br><br>
    <input type="submit"/>
</form>


