<?php

# Init the global-settings
include_once('global.php');

# Include the base header
include_once('base_header.php');

?>

<h1>Besvarelse af opgave omkring World databasen</h1>

<div class="opg_container">
    <h3>Opgave 1</h3>
    <p><i>Opret forbindelse til databasen, lav en fejl i forbindelsen, tjek at fejl-cachen virker og ret fejlen igen.</i></p>
    <hr>
    <p>Se koden i global.php</p>
</div>


<div class="opg_container">
    <h3>Opgave 2</h3>
    <p><i>Indlæs en sql-fil med indhold til databasen.</i></p>
    <hr>
    <p>Done</p>
</div>

<div class="opg_container">
    <h3>Opgave 3</h3>
    <p><i>Lav en liste over alle lande, deres befolkningstal og landets navn på det lokale sprog.</i></p>
    <hr>
    <?php
    $opg3 = $db_world->query("SELECT name, population, localname FROM Country");
    echo "<table><thead><tr><th>Navn</th><th>Befolkningtal</th><th>Lokal-navn</th></tr></thead><tbody>";
    while ($row = $opg3->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['name'], $row['population'], $row['localname']);
    }
    echo "</tbody></table>";
    $opg3->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 4</h3>
    <p><i>Lav en liste over alle lande, det kontinent, de tilhører og befolkningstallet. Sorter dem efter befolkningstal med det befolkningsrigeste først.</i></p>
    <hr>
    <?php
    $opg3 = $db_world->query("SELECT name, population, region FROM Country ORDER BY population DESC");
    echo "<table><thead><tr><th>Navn</th><th>Befolkningtal</th><th>Region</th></tr></thead><tbody>";
    while ($row = $opg3->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['name'], $row['population'], $row['region']);
    }
    echo "</tbody></table>";
    $opg3->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 5</h3>
    <p><i>Lav en liste over alle caribiske lande.</i></p>
    <hr>
    <?php
    $opg3 = $db_world->query("SELECT name, region FROM Country WHERE region = 'Caribbean'");
    echo "<table><thead><tr><th>Navn</th><th>Region</th></tr></thead><tbody>";
    while ($row = $opg3->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td></tr>", $row['name'], $row['region']);
    }
    echo "</tbody></table>";
    $opg3->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 6</h3>
    <p><i>Lav en liste over alle lande, hvor der tales engelsk.</i></p>
    <hr>
    <?php
    $opg3 = $db_world->query("SELECT c.name, cl.language FROM Country as c JOIN CountryLanguage as cl ON c.code = cl.countrycode WHERE cl.language = 'English'");
    echo "<table><thead><tr><th>Navn</th><th>Sprog</th></tr></thead><tbody>";
    while ($row = $opg3->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td></tr>", $row['name'], $row['language']);
    }
    echo "</tbody></table>";
    $opg3->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 7</h3>
    <p><i>Lav en liste over alle lande, hvor spansk er det officielle sprog.</i></p>
    <hr>
    <?php
    $opg3 = $db_world->query("SELECT c.name, cl.language FROM Country as c JOIN CountryLanguage as cl ON c.code = cl.countrycode WHERE cl.language = 'Spanish' AND cl.isofficial='T'");
    echo "<table><thead><tr><th>Navn</th><th>Sprog</th></tr></thead><tbody>";
    while ($row = $opg3->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td></tr>", $row['name'], $row['language']);
    }
    echo "</tbody></table>";
    $opg3->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 8</h3>
    <p><i>Lav en liste over alle lande, deres styreform og deres hovedstad.</i></p>
    <hr>
    <?php
    $opg3 = $db_world->query("SELECT c.name AS coname, c.governmentform, ci.name AS ciname FROM Country as c JOIN City as ci ON c.capital = ci.id");
    echo "<table><thead><tr><th>Navn</th><th>Styreform</th><th>Hovedstad</th></tr></thead><tbody>";
    while ($row = $opg3->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['coname'], $row['governmentform'], $row['ciname']);
    }
    echo "</tbody></table>";
    $opg3->free_result();
    ?>
</div>


<div class="opg_container">
    <h3 id="opg9">Opgave 9</h3>
    <p><i>Lav et script, hvor du kan lave et udtræk, der viser: alle afrikanske lande eller, alle afrikanske lande med styreformen republik eller, alle afrikanske lande med styreformen republik og et befolkningstal over 2 mill.</i></p>
    <hr>
    <form action="#opg9" method="get">
        <input name="opg9-all" type="submit" value="Alle Afrikanske lande" />
        <input name="opg9-rep" type="submit" value="Alle republikanske lande i Afrika" />
        <input name="opg9-rep2" type="submit" value="Alle republikanske lande i Afrika med over 2mill. indbyggere" />

    </form>
    <?php
    if (isset($_GET['opg9-all'])) {
        $opg9 = $db_world->query("SELECT name, governmentform, population FROM Country WHERE continent = 'Africa'");
    }
    elseif (isset($_GET['opg9-rep'])) {
        $opg9 = $db_world->query("SELECT name, governmentform, population FROM Country WHERE continent = 'Africa' AND governmentform = 'Republic'");
    }
    elseif (isset($_GET['opg9-rep2'])) {
        $opg9 = $db_world->query("SELECT name, governmentform, population FROM Country WHERE continent = 'Africa' AND governmentform = 'Republic' AND population > 2000000");
    }

    if (isset($opg9)) {
        echo "<table><thead><tr><th>Navn</th><th>Styreform</th><th>Indbyggertal</th></tr></thead><tbody>";
        while ($row = $opg9->fetch_assoc()) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['name'], $row['governmentform'], $row['population']);
        }
        echo "</tbody></table>";
        $opg9->free_result();
    }
    else
    {
        echo "<i>Ingen valg fortaget!</i>";
    }
    ?>
</div>







<?php
# Include the base footer
include_once('base_footer.php');
?>