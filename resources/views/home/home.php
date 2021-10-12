<div class="pure-g header" xmlns:a="http://www.w3.org/1999/html">
    <h1 class="pure-u">
        <a href="/index.php">Team builder</a>
    </h1>
    <div id="login_username" class="pure-u">
        Authentifié en tant que: <?= $data["body"]["username"]?>
    </div>
</div>

<div id="home_links" class="pure-g">
    <div class="pure-u-1-4">
        <a href="index.php?controller=MemberController&method=teamsList">Show list of teams</a>
    </div>

    <div class="pure-u-1-4">
        <a href="index.php?controller=MemberController&method=userTeamList">Show my teams</a>
    </div>

    <div class="pure-u-1-4">
        <a href="index.php?controller=MemberController&method=modsList">List of moderators</a>
    </div>

    <div class="pure-u-1-4">
        <a href="index.php?controller=TeamController&method=createForm">Create a new team</a>
    </div>
</div>