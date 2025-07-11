<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with usuario}}
  <form action="index.php?page=Seguridad_Usuario&mode={{~mode}}&usuarioId={{usuarioId}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usuarioIdD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="usuarioIdD" id="usuarioIdD" placeholder="Código" value="{{usuarioId}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="usuarioId" value="{{usuarioId}}" />
      <input type="hidden" name="usuario_xss_token" value="{{~usuario_xss_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usuarioNombre">Nombre</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="usuarioNombre" id="usuarioNombre" placeholder="Nombre del Usuario" value="{{usuarioNombre}}" />
      {{if usuarioNombre_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{usuarioNombre_error}}
      </div>
      {{endif usuarioNombre_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usuarioCorreo">Correo Electrónico</label>
      <input class="col-12 col-m-9" {{~readonly}} type="email" name="usuarioCorreo" id="usuarioCorreo" placeholder="Correo del Usuario" value="{{usuarioCorreo}}" />
      {{if usuarioCorreo_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{usuarioCorreo_error}}
      </div>
      {{endif usuarioCorreo_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usuarioRol">Rol</label>
      <select name="usuarioRol" id="usuarioRol" class="col-12 col-m-9" {{if ~readonly}} readonly disabled {{endif ~readonly}}>
        <option value="ADM" {{usuarioRol_ADM}}>Administrador</option>
        <option value="USR" {{usuarioRol_USR}}>Usuario</option>
      </select>
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usuarioEstado">Estado</label>
      <select name="usuarioEstado" id="usuarioEstado" class="col-12 col-m-9" {{if ~readonly}} readonly disabled {{endif ~readonly}}>
        <option value="ACT" {{usuarioEstado_ACT}}>Activo</option>
        <option value="INA" {{usuarioEstado_INA}}>Inactivo</option>
      </select>
    </div>
    {{endwith usuario}}

    <div class="row my-4 align-center flex-end">
      {{if showCommitBtn}}
      <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar">Confirmar</button>
      &nbsp;
      {{endif showCommitBtn}}
      <button class="col-12 col-m-2" type="button" id="btnCancelar">
        {{if showCommitBtn}} Cancelar {{endif showCommitBtn}}
        {{ifnot showCommitBtn}} Regresar {{endifnot showCommitBtn}}
      </button>
    </div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      window.location.assign("index.php?page=Seguridad_Usuarios");
    });
  });
</script>
