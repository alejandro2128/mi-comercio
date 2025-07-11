<h1>Trabajar con Usuarios</h1>

<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Usuarios-Usuarios">
          <label class="col-3" for="partialNombre">Nombre</label>
          <input class="col-9" type="text" name="partialNombre" id="partialNombre" value="{{partialNombre}}" />
          <label class="col-3" for="status">Estado</label>
          <select class="col-9" name="status" id="status">
            <option value="EMP" {{status_EMP}}>Todos</option>
            <option value="ACT" {{status_ACT}}>Activo</option>
            <option value="INA" {{status_INA}}>Inactivo</option>
          </select>
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
        <th>Nombre</th>
        <th>Correo</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>
          <a href="index.php?page=Usuarios-Usuario&mode=INS">Nuevo</a>
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach usuarios}}
      <tr>
        <td>{{usercod}}</td>
        <td>{{username}}</td>
        <td>{{useremail}}</td>
        <td>{{usertipo}}</td>
        <td>{{userest}}</td>
        <td class="center">
          <a href="index.php?page=Usuarios-Usuario&mode=DSP&id={{usercod}}">Ver</a>
          &nbsp;
          <a href="index.php?page=Usuarios-Usuario&mode=UPD&id={{usercod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Usuarios-Usuario&mode=DEL&id={{usercod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor usuarios}}
    </tbody>
  </table>
  {{pagination}}
</section>

