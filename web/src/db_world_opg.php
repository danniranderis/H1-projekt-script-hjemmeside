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
    $opg4 = $db_world->query("SELECT name, population, region FROM Country ORDER BY population DESC");
    echo "<table><thead><tr><th>Navn</th><th>Befolkningtal</th><th>Region</th></tr></thead><tbody>";
    while ($row = $opg4->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['name'], $row['population'], $row['region']);
    }
    echo "</tbody></table>";
    $opg4->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 5</h3>
    <p><i>Lav en liste over alle caribiske lande.</i></p>
    <hr>
    <?php
    $opg5 = $db_world->query("SELECT name, region FROM Country WHERE region = 'Caribbean'");
    echo "<table><thead><tr><th>Navn</th><th>Region</th></tr></thead><tbody>";
    while ($row = $opg5->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td></tr>", $row['name'], $row['region']);
    }
    echo "</tbody></table>";
    $opg5->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 6</h3>
    <p><i>Lav en liste over alle lande, hvor der tales engelsk.</i></p>
    <hr>
    <?php
    $opg6 = $db_world->query("SELECT c.name, cl.language FROM Country as c JOIN CountryLanguage as cl ON c.code = cl.countrycode WHERE cl.language = 'English'");
    echo "<table><thead><tr><th>Navn</th><th>Sprog</th></tr></thead><tbody>";
    while ($row = $opg6->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td></tr>", $row['name'], $row['language']);
    }
    echo "</tbody></table>";
    $opg6->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 7</h3>
    <p><i>Lav en liste over alle lande, hvor spansk er det officielle sprog.</i></p>
    <hr>
    <?php
    $opg7 = $db_world->query("SELECT c.name, cl.language FROM Country as c JOIN CountryLanguage as cl ON c.code = cl.countrycode WHERE cl.language = 'Spanish' AND cl.isofficial='T'");
    echo "<table><thead><tr><th>Navn</th><th>Sprog</th></tr></thead><tbody>";
    while ($row = $opg7->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td></tr>", $row['name'], $row['language']);
    }
    echo "</tbody></table>";
    $opg7->free_result();
    ?>
</div>

<div class="opg_container">
    <h3>Opgave 8</h3>
    <p><i>Lav en liste over alle lande, deres styreform og deres hovedstad.</i></p>
    <hr>
    <?php
    $opg8 = $db_world->query("SELECT c.name AS coname, c.governmentform, ci.name AS ciname FROM Country as c JOIN City as ci ON c.capital = ci.id");
    echo "<table><thead><tr><th>Navn</th><th>Styreform</th><th>Hovedstad</th></tr></thead><tbody>";
    while ($row = $opg8->fetch_assoc()) {
        printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['coname'], $row['governmentform'], $row['ciname']);
    }
    echo "</tbody></table>";
    $opg8->free_result();
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

<div class="opg_container">
    <h3 id="opg10">Opgave 10</h3>
    <p><i>Opdater den forventede levealder med +2 år i alle afrikanske republikker.</i></p>
    <hr>
    <form action="#opg10" method="get">
        <input name="opg10" type="submit" value="Tilføj 2 år til til levealderen for alle afrikanske republikker" />
    </form>
    <?php
    if (isset($_GET['opg10'])) {
        if ($opg10 = $db_world->query("UPDATE Country SET LifeExpectancy = LifeExpectancy + 2 WHERE continent = 'Africa' AND governmentform = 'Republic'"))
        {
            echo "<i>Opdateret korrekt.</i>";
        }
        else
        {
            echo "<i>FEJL!: Ikke opdateret korrekt.</i>";
        }
    }
    ?>
</div>

<div class="opg_container">
    <h3 id="opg11">Opgave 11</h3>
    <p><i>Udskift Elisabeth II med Justin Biber som statsoverhoved i alle relevante lande.</i></p>
    <hr>
    <form action="#opg11" method="get">
        <input name="opg11" type="submit" value="Skift Elisabeth II ud med Justin Biber" />
    </form>
    <?php
    if (isset($_GET['opg11'])) {
        if ($opg11 = $db_world->query("UPDATE Country SET HeadOfState = 'Justin Biber' WHERE HeadOfState='Elisabeth II'"))
        {
            echo "<i>Opdateret korrekt.</i>";
        }
        else
        {
            echo "<i>FEJL!: Ikke opdateret korrekt.</i>";
        }
    }
    ?>
</div>

<div class="opg_container">
    <h3 id="opg12">Opgave 12</h3>
    <p><i>Skift tilbage til Elisabeth II.</i></p>
    <hr>
    <form action="#opg12" method="get">
        <input name="opg12" type="submit" value="Skift tilbage til Elisabeth II" />
    </form>
    <?php
    if (isset($_GET['opg12'])) {
        if ($opg12 = $db_world->query("UPDATE Country SET HeadOfState = 'Elisabeth II' WHERE HeadOfState='Justin Biber'"))
        {
            echo "<i>Opdateret korrekt.</i>";
        }
        else
        {
            echo "<i>FEJL!: Ikke opdateret korrekt.</i>";
        }
    }
    ?>
</div>

<div class="opg_container">
    <h3 id="opg13">Opgave 13</h3>
    <p><i>Opdater alle europæiske lande, så de nu ligger i Afrika.</i></p>
    <hr>
    <form action="#opg13" method="get">
        <p>
            Denne opgave kan ikke reverses tilbage, derfor er det vigtigt at du sørger for manuelt at tage en backup af databasen.
            Dette kan du gøre ved at køre følgende kode fra din CLI (eller ved at benytte "dump"-funktion i fx phpMyAdmin):
            <pre>mysqldump -u [username] -p [database] > [database].sql</pre>
        </p>
        <input name="opg13" type="submit" value="Ja, jeg har taget en backup af databasen! Udfør handlingen!" />
    </form>
    <?php
    if (isset($_GET['opg13'])) {
        if ($opg13 = $db_world->query("UPDATE Country SET Continent = 'Africa' WHERE Continent = 'Europe'"))
        {
            echo "<i>Opdateret korrekt.</i>";
        }
        else
        {
            echo "<i>FEJL!: Ikke opdateret korrekt.</i>";
        }
    }
    ?>
</div>

<div class="opg_container">
    <h3 id="opg14">Opgave 14</h3>
    <p><i>Nulstil ændringen fra forrige opgave.</i></p>
    <hr>
    <p>
        Via din CLI kan du importere den backup du foretog i opgave 13.
        Husk gerne at tømme databasen forinden (fx via en DROP og derefter CREATE).
        <pre>mysql -u [username] -p [database] < [database].sql</pre>
    </p>
</div>

<div class="opg_container">
    <h3 id="opg15">Opgave 15</h3>
    <p><i>Tilføj et nyt land. Sørg for at alle felter er udfyldt. Husk sprog og hovedstad.</i></p>
    <hr>
    <form action="#opg15" method="get">
        <input name="opg15" type="submit" value="Indsæt Narnia" />
    </form>
    <?php
    if (isset($_GET['opg15'])) {
        if ($opg15 = $db_world->query("INSERT INTO Country (Code, Name, Continent, Region, Population, LifeExpectancy, LocalName, GovernmentForm, Code2) VALUES ('NAR', 'Republic of Narnia', 'Europe', 'Southern Europe', 5, 99.9, 'Narnian', 'Republic', 'NA')")) {
            echo "<i>Opdateret korrekt.</i>";
        } else {
            echo "<i>FEJL!: Ikke opdateret korrekt.</i>";
        }
    }
    ?>
</div>

<div class="opg_container">
    <h3 id="opg16">Opgave 16</h3>
    <p><i>Opret Svendborg med alle oplysninger i City tabellen. Sæt Svendborg til at være hovedstad i Danmark.</i></p>
    <hr>
    <form action="#opg16" method="get">
        <input name="opg16" type="submit" value="Kør" />
    </form>
    <?php
    if (isset($_GET['opg16'])) {
        if ($opg16 = $db_world->query("INSERT INTO City (Name, CountryCode, District, Population) VALUES ('Svendborg', 'DNK', 'Noord-Holland', 47000)")) {
            echo "<i>Svendborg indsat korrekt.</i>";
            if ($opg16b = $db_world->query("UPDATE Country SET Capital = (SELECT ID FROM City WHERE Name = 'Svendborg') WHERE Code = 'DNK'")) {
                echo "<br><i>Danmarks hovedstad opdateret til Svendborg.</i>";
            } else {
                echo "<br><i>FEJL!: Svendborg kunne ikke sættes til at være hovedstad i Danmark.</i>";
            }
        } else {
            echo "<i>FEJL!: Svendborg ikke indsat korrekt.</i>";
        }
    }
    ?>
</div>


<div class="opg_container">
    <h3 id="opg17">Opgave 17</h3>
    <p><i>Slet alle lande, der har en forventet levetid under 70 år.</i></p>
    <hr>
    <p>Denne vil fejle. Dette skyldes at der på en foreign-key på City- og CountryLanguage-tabellerne er sat en constraint med "RESTRICT" på "ON DELETE".</p>
    <p>Jeg har derfor ændret denne til "CASCADE", da alle byer alligevel skal slettes hvis deres land ikke findes.</p>
    <form action="#opg17" method="get">
        <input name="opg17" type="submit" value="Slet lande med forventet levetid under 70 år" />
    </form>
    <?php
    if (isset($_GET['opg17'])) {
        $opg17alter = $db_world->query("ALTER TABLE `CountryLanguage` DROP FOREIGN KEY `countryLanguage_ibfk_1`; ALTER TABLE `CountryLanguage` ADD CONSTRAINT `countryLanguage_ibfk_1` FOREIGN KEY (`CountryCode`) REFERENCES `Country`(`Code`) ON DELETE CASCADE ON UPDATE RESTRICT; ALTER TABLE `City` DROP FOREIGN KEY `city_ibfk_1`; ALTER TABLE `City` ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`CountryCode`) REFERENCES `Country`(`Code`) ON DELETE CASCADE ON UPDATE RESTRICT;");

        if ($opg17 = $db_world->query("DELETE FROM Country WHERE LifeExpectancy < 70.0")) {
            echo "<i>" . $opg17->affected_rows . "  lande slettet korrekt.</i>";
        } else {
            echo "<i>FEJL!: Sletning ikke korrekt.</i>";
        }
    }
    ?>
</div>


<div class="opg_container">
    <h3 id="opg18">Opgave 18</h3>
    <p><i>Udslet hele Oceanien!</i></p>
    <hr>
    <p>Som i opgave 17, så er dette ej muligt uden de angivne ændringer til constraints sat.
        Disse er allerede ifm. opgave 17 ændret, hvorfor vi her ikke har behov for det.</p>
    <form action="#opg18" method="get">
        <input name="opg18" type="submit" value="Udslet hele Oceanien" />
    </form>
    <?php
    if (isset($_GET['opg18'])) {
        if ($opg18 = $db_world->query("DELETE FROM Country WHERE Continent = 'Oceania'")) {
            echo "<i>" . $opg18->affected_rows . "  lande slettet korrekt.</i>";
        } else {
            echo "<i>FEJL!: Sletning ikke korrekt.</i>";
        }
    }
    ?>
</div>


<div class="opg_container">
    <h3 id="opg20">Opgave 20</h3>
    <p><i>Slet relaterede poster til de to foregående opgaver (opgave 17 og 18) i tabellerne "City" og "CountryLanguage".</i></p>
    <hr>
    <p>Dette er allerede gjort ifm. de to opgaver. Da "ON DELETE"-constrainen på deres foreign-keys blev ændret til "CASCADE", betyder dette, at sletningen "trækker med over i de tabeller" - altså er disse elementer/rækker allerede slettet.</p>
</div>



<?php
# Include the base footer
include_once('base_footer.php');
?>