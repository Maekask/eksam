<?php
// Teade salvestamise kohta
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">'.htmlspecialchars($_SESSION['message']).'</div>';
    unset($_SESSION['message']);
}
?>

<h2>Registreeru üritusele</h2>

<form action="salvesta.php" method="post" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="eesnimi" class="form-label">Eesnimi</label>
        <input type="text" class="form-control" id="eesnimi" name="eesnimi" required>
        <div class="invalid-feedback">Palun sisesta eesnimi.</div>
    </div>
    <div class="mb-3">
        <label for="perenimi" class="form-label">Perenimi</label>
        <input type="text" class="form-control" id="perenimi" name="perenimi" required>
        <div class="invalid-feedback">Palun sisesta perenimi.</div>
    </div>
    <div class="mb-3">
        <label for="voistlusklass" class="form-label">Võistlusklass</label>
        <input type="text" class="form-control" id="voistlusklass" name="voistlusklass" required>
        <div class="invalid-feedback">Palun sisesta võistlusklass.</div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <div class="invalid-feedback">Palun sisesta korrektne e-mail.</div>
    </div>
    <button type="submit" class="btn btn-primary">Registreeru</button>
</form>

<script>
// Bootstrap validatsiooni kood
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>

