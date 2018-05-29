<?php

# Init the global-settings
include_once('global.php');

# Include the base header
include_once('base_header.php');

?>

<h1>Besvarelse af opgave omkring Arrays</h1>

<div class="opg_container">
    <h3>Opgave a1</h3>
    <p><i>Lav et array med 5 navne og udskriv denne via en for-løkke.</i></p>
    <hr>
    <?php
    $a1_array = array('Arne', 'Børge', 'Carsten', 'Dorthe', 'Else');
    echo '<ul>';
    for ($i = 0; $i < count($a1_array); $i++){
        echo '<li>'.$a1_array[$i].'</li>';
    }
    echo '</ul>';
    ?>
</div>


<div class="opg_container">
    <h3>Opgave a2</h3>
    <p><i>Lav et array med ugedage og en med månedsnavne på dansk.
            Udskriv dags dato automatisk på dansk via disse arrays og dato-funktionen.</i></p>
    <hr>
    <?php
    // Create danish day/month arrays and make them 1-indexed (as opposed to the default 0-indexed)
    $da_day_array = array(1 => 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag', 'Søndag');
    $da_month_array = array(1 => 'Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'December');
    echo 'Dags dato er: '.$da_day_array[date('N')].' d. '.date('j').'. '.$da_month_array[date('n')].' '.date('Y');
    ?>
    <p>Dette kan dog gøres noget nemmere når man sørger for at sætte <pre>setlocale();</pre></p>
    <?php
    echo 'Dags dato er: '.strftime('%A d. %e. %B %Y');
    ?>
</div>


<div class="opg_container">
    <h3>Opgave a3</h3>
    <p><i>Tag arrayet fra Opg. a1, og udskriv disse i en ordnet liste via en foreach-lykke.</i></p>
    <hr>
    <ol>
        <?php
        foreach ($a1_array as $name){
            echo '<li>'.$name.'</li>';
        }
        ?>
    </ol>
</div>


<div class="opg_container">
    <h3>Opgave a4</h3>
    <p><i>Lav et array med kameraer og udskriv disse via en dropdown.
            Når en vælges, skal navnet vises sammen med et pixel-tal.</i></p>
    <p><small>Jeg har valgt at lave denne opgave via en javascript-løsning via jQuery.
        Dette giver muligheden for, at visningen kan opdateres dynamisk og vi behøver ikke arbejde med formularer og POST.</small></p>
    <hr>
    <?php
    $a4_camera_array = array();
    $a4_camera_array[1] = 'Canon EOS-1Ds Mark III';
    $a4_camera_array[2] = 'Canon EOS-1D Mark IV';
    $a4_camera_array[3] = 'Canon EOS 5D Mark II';
    $a4_camera_array[4] = 'Canon EOS 7D';
    $a4_camera_array[5] = 'Canon EOD 60D';
    $a4_camera_array[6] = 'Canon EOS 1100D';

    $a4_pixel_array = array();
    $a4_pixel_array[1] = '21';
    $a4_pixel_array[2] = '16,1';
    $a4_pixel_array[3] = '21,1';
    $a4_pixel_array[4] = '18';
    $a4_pixel_array[5] = '18';
    $a4_pixel_array[6] = '12';
    ?>

    <select onclick="update_camera()" id="select_camera">
        <?php
        foreach ($a4_camera_array as $key=>$value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        }
        ?>
    </select>
    <div id="camera_pixel_view"></div>

    <script type="application/javascript">
        // Convert PHP-array of pixels to JavaScript-array by encoding it in json.
        var $a4_pixel_array_js = <?php echo json_encode($a4_pixel_array); ?>;

        function update_camera() {
            // Get the id value and camera text from the dropdown
            var $id = $('#select_camera').val();
            var $camera = $('#select_camera option:selected').text();

            // Update the placeholder with the selected camera and its pixel-count from the dropbox
            $("#camera_pixel_view").html(`<span>Kamera '${$camera}' har ${$a4_pixel_array_js[$id]} megapixels.</span>`);
        }
    </script>
</div>


<div class="opg_container">
    <h3>Opgave a5</h3>
    <p><i>Lav et array med billede-stier til en ternings 6 forskellige udfald.
            Benyt derefter en random-funktion til at udskrive et vilkårligt terningkast.</i></p>
    <hr>
    <?php
    $a5_terning = array(
        'terning-1.png',
        'terning-2.png',
        'terning-3.png',
        'terning-4.png',
        'terning-5.png',
        'terning-6.png',
    );

    echo '<div id="terning"><img src="img/'.$a5_terning[array_rand($a5_terning)].'" /></div>';
    ?>
    <input type="button" value="Kast terningen!" onclick="throw_cube()" />
    
    <script type="application/javascript">
        function throw_cube() {
            var $random_num = Math.floor(Math.random()*6)+1;
            console.log($random_num);
            $('#terning').html(`<img src="img/terning-${$random_num}.png" />`);
        }
    </script>
</div>


<div class="opg_container">
    <h3>Opgave a6</h3>
    <p><i>Lav et associativt array med personoplysninger og udskriv disse inkl index-navnene.</i></p>
    <hr>
    <?php
    $a6_person = array();
    $a6_person['navn'] = 'Egon';
    $a6_person['efternavn'] = 'Olsen';
    $a6_person['alder'] = 20;
    $a6_person['uddannelse'] = 'webintegrator';

    foreach ($a6_person as $key=>$value){
        echo '<b>'.ucfirst($key).':</b> '.$value.'<br/>';
    }
    ?>
</div>


<div class="opg_container">
    <h3>Opgave 1 - Kalender</h3>
    <p><i>Der skal laves en "kalender" med visning af alle mdr-numre, datoer for nuværende mdr samt pile på de nuværende.
        Ligeledes skal der være en visning af dags dato, et random visning af 6 billeder udvalgt fra en pool på 8 billeder samt slutteligt
        12 visninger af billeder af terninger først "ASC" og derefter "DESC".</i></p>
    <hr>

    <div class="day_container">
        <?php
        // Print all days of the current month and set class on the current day
        $cur_day = date('j');
        for ($i = 1; $i <= date('t'); $i++){
            echo '<div class="day_num_cell '. ($cur_day == $i ? "day_cell_selected" : "") .'">'.
                $i.
                ($cur_day == $i ? '<div class="current_day_arrow">&ShortDownArrow;</div>': '').
                '</div>';
        }
        ?>
    </div>
    <div class="clear"></div>

    <div class="month_container">
        <?php
        // Print all month numbers and set class on current month
        $cur_month = date('n');
        for ($i = 1; $i <= 12; $i++){
            echo '<div class="month_num_cell '. ($cur_month == $i ? "month_cell_selected" : "") .'">'.
                $i.
                ($cur_month == $i ? '<div class="current_month_arrow">&ShortUpArrow;</div>': '').
                '</div>';
        }
        ?>
    </div>
    <div class="clear"></div>

    <div class="column_container">
        <div class="cur_date half_width">
            <p>Det er i dag den <?php echo strftime('%e. %B %Y'); ?> <br/>
            og klokken er <?php echo strftime('%R') ?></p>
        </div>

        <div class="pic_random half_width">
            <?php
            $pics = array('1.jpg', '2.jpg', '3.jpg', '4.jpg',
                          '5.jpg', '6.jpg', '7.jpg', '8.jpg');

            foreach (array_rand($pics, 6) as $item) {
                echo '<div class="half_width"><img src="img/cal_img/'.$pics[$item].'" /></div>';
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>

    <div class="cubs">
        <?php
        $joined_cubs = array_merge($a5_terning, array_reverse($a5_terning));

        foreach ($joined_cubs as $item) {
            echo '<div class="cal_terning"><img src="img/'.$item.'" /></div>';
        }
        ?>
    </div>
    <div class="clear"></div>
</div>









<?php
# Include the base footer
include_once('base_footer.php');
?>