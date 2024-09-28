<div class="formWrapper md:w-[700px]">
  <div class="w-full md:w-[390px]">
    <h3>Si ya estás registrado (a)</h3>
    <p>Completa los campos para poder ingresar</p>
  </div>
  <form action="#" method="GET">

    <div class="formWrapper__input <?= isset($error_phone) ? 'status_error' : '' ?>">
      <label for="telefono">Número de celular *</label>
      <input type="number" name="ph" id="telefono" placeholder="ej. 88888888" require>
      <?= isset($error_phone) ? ' <span class="text-[#E31F1F] font-semibold text-base">*El número de teléfono no se encuentra registrado.</span>' : '' ?>

    </div>

    <div>
      <button class="btn-primary">Ingresar</button>
    </div>
  </form>
</div>