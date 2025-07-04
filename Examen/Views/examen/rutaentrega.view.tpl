<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with rutaEntrega}}
  <form action="index.php?page=Examen_RutaEntrega&mode={{~mode}}&id_ruta={{id_ruta}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="id_rutaD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="id_rutaD" id="id_rutaD" placeholder="Código" value="{{id_ruta}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="id_ruta" value="{{id_ruta}}" />
      <input type="hidden" name="ruta_xss_token" value="{{~ruta_xss_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="origen">Origen</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="origen" id="origen" placeholder="Origen" value="{{origen}}" />
      {{if origen_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{origen_error}}
      </div>
      {{endif origen_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="destino">Destino</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="destino" id="destino" placeholder="Destino" value="{{destino}}" />
      {{if destino_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{destino_error}}
      </div>
      {{endif destino_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="distancia_km">Distancia (km)</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" step="0.01" name="distancia_km" id="distancia_km" placeholder="Distancia en kilómetros" value="{{distancia_km}}" />
      {{if distancia_km_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{distancia_km_error}}
      </div>
      {{endif distancia_km_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="duracion_min">Duración (min)</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" name="duracion_min" id="duracion_min" placeholder="Duración en minutos" value="{{duracion_min}}" />
      {{if duracion_min_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{duracion_min_error}}
      </div>
      {{endif duracion_min_error}}
    </div>
    {{endwith rutaEntrega}}

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
      window.location.assign("index.php?page=Examen_RutasEntrega");
    });
  });
</script>
