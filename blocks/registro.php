<?php
$mainImage = get_field('main_image');
var_dump('asdfasdf111');

if ($_POST) {
  var_dump('asdfasdf111222');

  include_once(get_template_directory() . '/blocks/register/save.php');
}

?>
<section class="overflow-hidden supperBackground pb-[250px]">
  <div class=" w-screen h-screen absolute left-0 top-0 z-0"></div>
  <div class="  relative z-10 py-24 md:py-20">

    <div class="container">
      <div class="flex flex-col items-center justify-center mb-[40px] md:mb-[60px]">
        <img src="<?php echo $mainImage['url']; ?>" alt="<?php echo $mainImage['alt']; ?>">

      </div>
      <div class="formWrapper md:w-[700px]">
        <div class="w-full md:w-[550px] mb-6">
          <h3>Registrate para ganar</h3>
          <p>Completá los campos para poder ingresar</p>
          <?= isset($error_factura) && $error_factura || isset($error_phone) && $error_phone ? ' <span class="text-[#E31F1F] text-center font-semibold text-base">Revisá los campos que se marcan en rojo para poder registrate.</span>' : '' ?>

        </div>
        <form action="#" id="newRegister" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="isNewRegister" value="true">
          <div class="formWrapper__input">
            <label for="nombre">Nombre Completo *</label>
            <input type="text" name="nombre" id="nombre" placeholder="ej. Veronica Peréz" require>
          </div>
          <div class="formWrapper__input <?= isset($error_phone) && $error_phone ? 'status_error' : '' ?>">
            <label for="telefono">Número de celular *</label>
            <input type="number" name="telefono" id="telefono" placeholder="88888888" require>
            <?= isset($error_phone) && $error_phone ? ' <span class="text-[#E31F1F] font-semibold text-base">*El número de teléfono ingresado ya se encuentra registrado.</span>' : '' ?>

          </div>
          <div class="formWrapper__input">
            <label for="email">Correo electrónico (opcional)</label>
            <input type="email" name="email" id="email" placeholder="ejemplo@gmail.com" require>
          </div>
          <div class="formWrapper__input">
            <label for="cedula">Cédula de identidad *</label>
            <input type="text" name="cedula" id="cedula" placeholder="000-000000-0000A" require>
          </div>
          <div class="formWrapper__input <?= isset($error_factura) && $error_factura ? 'status_error' : '' ?>">
            <label for="factura">Número de Factura *</label>
            <input type="text" name="factura" id="factura" placeholder="123-12-12345678" require>
            <?= isset($error_factura) && $error_factura ? ' <span class="text-[#E31F1F] font-semibold text-base">*El número de factura ingresado ya se encuentra registrado.</span>' : '' ?>

          </div>
          <div class="formWrapper__input--file">
            <label for="factura_imagen">Subí la fotografía completa de tu ticket/factura *</label>
            <input type="file" name="factura_imagen[]" id="factura_imagen" require>
            <span>Tipos de archivos aceptados: jpg, jpeg, png, Tamaño máximo de archivo: 20 MB.</span>
          </div>
          <div class="formWrapper__input--check">
            <input type="checkbox" name="terminos" id="terminos" require>
            <label for="">Acepto los Términos y Condiciones de la promoción.</label>
          </div>

          <div class="flex justify-center md:justify-start">
            <button class="btn-primary ">Subir y registrarte</button>
          </div>
        </form>
      </div>
    </div>


  </div>

  </div>
</section>