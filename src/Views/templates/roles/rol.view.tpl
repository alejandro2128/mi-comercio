<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with rol}}
  <form action="index.php?page=Roles-Rol&mode={{~mode}}&rolesCod={{rolesCod}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesCodD">Código</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="rolesCod" id="rolesCodD" placeholder="Código del Rol" value="{{rolesCod}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="rol_xss_token" value="{{~rol_xss_token}}" />
      {{if rolesCod_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{rolesCod_error}}
      </div>
      {{endif rolesCod_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesDsc">Descripción</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="rolesDsc" id="rolesDsc" placeholder="Descripción del Rol" value="{{rolesDsc}}" />
      {{if rolesDsc_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{rolesDsc_error}}
      </div>
      {{endif rolesDsc_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesEst">Estado</label>
      <select name="rolesEst" id="rolesEst" class="col-12 col-m-9" {{if ~readonly}} readonly disabled {{endif ~readonly}}>
        <option value="ACT" {{rolesEst_ACT}}>Activo</option>
        <option value="INA" {{rolesEst_INA}}>Inactivo</option>
      </select>
      {{if rolesEst_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{rolesEst_error}}
      </div>
      {{endif rolesEst_error}}
    </div>
    {{endwith rol}}

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
      window.location.assign("index.php?page=Roles-Roles");
    });
  });
</script>
