<h2>Galerii</h2>

<div class="row row-cols-1 row-cols-md-3 g-4">
<?php
for ($i=1; $i<=12; $i++) {
    echo '<div class="col">';
    echo '<div class="card">';
    echo '<img src="galerii/pilt' . $i . '.jpg" class="card-img-top" alt="Pilt ' . $i . '">';
    echo '</div>';
    echo '</div>';
}
?>
</div>

