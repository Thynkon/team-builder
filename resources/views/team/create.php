<div class="pure-g header" xmlns:a="http://www.w3.org/1999/html">
    <h1 class="pure-u">
        <a href="/index.php">Team builder</a>
    </h1>
    <div id="login_username" class="pure-u">
        Authentifié en tant que: <?= $data["body"]["username"]?>
    </div>
</div>

<form class="pure-form pure-form-stacked" action="/index.php?controller=TeamController&method=create" method="post">
    <fieldset>
        <input name="team_name" type="text" placeholder="Team's name" />
        <button type="submit" class="pure-button pure-button-primary">Create</button>
    </fieldset>
</form>