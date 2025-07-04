<h1>Trabajar con Rutas de Entrega</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Examen_RutasEntrega">
          <label class="col-3" for="partialOrigen">Origen</label>
          <input class="col-9" type="text" name="partialOrigen" id="partialOrigen" value="{{partialOrigen}}" />
          <label class="col-3" for="partialDestino">Destino</label>
          <input class="col-9" type="text" name="partialDestino" id="partialDestino" value="{{partialDestino}}" />
        </div>
        <div class="col-4 align-end">
          <button type="submit">Filtrar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Distancia (km)</th>
        <th>Duración (min)</th>
        <th><a href="index.php?page=Examen_RutaEntrega&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach rutasEntrega}}
      <tr>
        <td>{{id_ruta}}</td>
        <td><a class="link" href="index.php?page=Examen_RutaEntrega&mode=DSP&id_ruta={{id_ruta}}">{{origen}}</a></td>
        <td>{{destino}}</td>
        <td class="right">{{distancia_km}}</td>
        <td class="right">{{duracion_min}}</td>
        <td class="center">
          <a href="index.php?page=Examen_RutaEntrega&mode=UPD&id_ruta={{id_ruta}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Examen_RutaEntrega&mode=DEL&id_ruta={{id_ruta}}">Eliminar</a>
        </td>
      </tr>
      {{endfor rutasEntrega}}
    </tbody>
  </table>
  {{pagination}}
</section>
