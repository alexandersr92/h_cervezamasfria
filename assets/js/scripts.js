const toggleMenu = document.querySelector("#toggleMenu");

toggleMenu.addEventListener("click", () => {
  document.querySelector("#nav__list__mobile").classList.toggle("active");
  document.querySelector("#toggleMenu").classList.toggle("active");
});

const formRegisterNew = document.querySelector("#newRegister");

if (formRegisterNew) {
  formRegisterNew.addEventListener("submit", (e) => {
    e.preventDefault();
    //validate form
    const name = document.querySelector("#nombre");
    const telefono = document.querySelector("#telefono");
    const email = document.querySelector("#email");
    const cedula = document.querySelector("#cedula");
    const factura = document.querySelector("#factura");
    const terminos = document.querySelector("#terminos");
    const factura_imagen = document.querySelector("#factura_imagen");

    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    const cedulaRegex = /^[0-9]{3}-[0-9]{6}-[0-9]{4}[A-Za-z]{1}$/;
    const telefonoRegex = /^[0-9]{8}$/;

    if (email.value.length > 0) {
      if (!emailRegex.test(email.value)) {
        alert("El email no es válido");
        return;
      }
    }

    if (!cedulaRegex.test(cedula.value)) {
      alert("La cédula no es válida");
      return;
    }

    if (!telefonoRegex.test(telefono.value)) {
      alert("El teléfono no es válido");
      return;
    }

    if (
      !name.value ||
      !telefono.value ||
      !cedula.value ||
      !factura.value ||
      !terminos.checked ||
      !factura_imagen.value
    ) {
      alert("Todos los campos son obligatorios");
      return;
    }

    formRegisterNew.submit();
  });
}

const formRegisterExistent = document.querySelector("#registerExistent");

if (formRegisterExistent) {
  formRegisterExistent.addEventListener("submit", (e) => {
    e.preventDefault();

    const factura = document.querySelector("#factura");
    const terminos = document.querySelector("#terminos");
    const factura_imagen = document.querySelector("#factura_imagen");

    if (!factura.value || !terminos.checked || !factura_imagen.value) {
      alert("Todos los campos son obligatorios");
      return;
    }

    formRegisterExistent.submit();
  });
}

const cedula = document.querySelector("#cedula");

if (cedula) {
  //add - to cedula input field when user types it, this is the format 000-000000-0000A
  cedula.addEventListener("input", (e) => {
    const value = e.target.value;
    if (value.length === 3 || value.length === 10) {
      e.target.value = value + "-";
    }
  });
  //limit the input to 16 characters
  cedula.addEventListener("keypress", (e) => {
    if (e.target.value.length >= 16) {
      e.preventDefault();
    }
  });
  //last character should be a letter
  cedula.addEventListener("keyup", (e) => {
    const value = e.target.value;
    //alow delete key and backspace key
    if (e.keyCode === 8 || e.keyCode === 46) {
      return;
    }
    const lastChar = value[value.length - 1];
    if (value.length === 16 && !isNaN(lastChar)) {
      e.target.value = value.slice(0, -1);
    }
  });

  //uppercase the last character
  cedula.addEventListener("input", (e) => {
    const value = e.target.value;
    const lastChar = value[value.length - 1];
    if (value.length === 16) {
      e.target.value = value.slice(0, -1) + lastChar.toUpperCase();
    }
  });
  //don't allow letters in the first 13 characters
}

const factura = document.querySelector("#factura");

if (factura) {
  //limit the input to 15 characters
  factura.addEventListener("keypress", (e) => {
    if (e.target.value.length >= 15) {
      e.preventDefault();
    }
  });

  //don't allow letters in the first 13 characters
  factura.addEventListener("input", (e) => {
    const value = e.target.value;
    const lastChar = value[value.length - 1];
    if (value.length <= 13 && isNaN(lastChar)) {
      e.target.value = value.slice(0, -1);
    }
  });

  //add - to factura input field when user types it, this is the format 000-00-00000000
  factura.addEventListener("input", (e) => {
    const value = e.target.value;
    if (value.length === 3 || value.length === 6) {
      e.target.value = value + "-";
    }
  });

  //if paste long number, only take the first 15 characters
  factura.addEventListener("input", (e) => {
    const value = e.target.value;
    if (value.length > 15) {
      e.target.value = value.slice(0, 15);
    }
  });

  //remove spaces
  factura.addEventListener("input", (e) => {
    e.target.value = e.target.value.replace(/\s/g, "");
  });
}

const telefono = document.querySelector("#telefono");

if (telefono) {
  //limit the input to 8 characters
  telefono.addEventListener("keypress", (e) => {
    if (e.target.value.length >= 8) {
      e.preventDefault();
    }
  });
  //don't allow letters
  telefono.addEventListener("input", (e) => {
    const value = e.target.value;
    const lastChar = value[value.length - 1];
    if (isNaN(lastChar)) {
      e.target.value = value.slice(0, -1);
    }
  });
  //if paste long number, only take the first 8 characters
  telefono.addEventListener("input", (e) => {
    const value = e.target.value;
    if (value.length > 8) {
      e.target.value = value.slice(0, 8);
    }
  });
  telefono.addEventListener("input", (e) => {
    e.target.value = e.target.value.replace(/\s/g, "");
  });
}
