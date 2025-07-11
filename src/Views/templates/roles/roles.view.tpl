<h1>Trabajar con Roles</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Roles-Roles" />
          <label class="col-3" for="partialDescripcion">Descripción</label>
          <input class="col-9" type="text" name="partialDescripcion" id="partialDescripcion" value="{{partialDescripcion}}" />
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
        <th>
          {{ifnot OrderByRolesCod}}
          <a href="index.php?page=Roles-Roles&orderBy=rolescod&orderDescending=0">Código <i class="fas fa-sort"></i></a>
          {{endifnot OrderByRolesCod}}
          {{if OrderRolesCodDesc}}
          <a href="index.php?page=Roles-Roles&orderBy=clear&orderDescending=0">Código <i class="fas fa-sort-down"></i></a>
          {{endif OrderRolesCodDesc}}
          {{if OrderRolesCod}}
          <a href="index.php?page=Roles-Roles&orderBy=rolescod&orderDescending=1">Código <i class="fas fa-sort-up"></i></a>
          {{endif OrderRolesCod}}
        </th>
        <th class="left">
          {{ifnot OrderByRolesDsc}}
          <a href="index.php?page=Roles-Roles&orderBy=rolesdsc&orderDescending=0">Descripción <i class="fas fa-sort"></i></a>
          {{endifnot OrderByRolesDsc}}
          {{if OrderRolesDscDesc}}
          <a href="index.php?page=Roles-Roles&orderBy=clear&orderDescending=0">Descripción <i class="fas fa-sort-down"></i></a>
          {{endif OrderRolesDscDesc}}
          {{if OrderRolesDsc}}
          <a href="index.php?page=Roles-Roles&orderBy=rolesdsc&orderDescending=1">Descripción <i class="fas fa-sort-up"></i></a>
          {{endif OrderRolesDsc}}
        </th>
        <th>Estado</th>
        <th><a href="index.php?page=Roles-Rol&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles}}
      <tr>
        <td>{{rolescod}}</td>
        <td>
          <a class="link" href="index.php?page=Roles-Rol&mode=DSP&rolesCod={{rolescod}}">{{rolesdsc}}</a>
        </td>
        <td class="center">{{rolesest}}</td>
        <td class="center">
          <a href="index.php?page=Roles-Rol&mode=UPD&rolesCod={{rolescod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Roles-Rol&mode=DEL&rolesCod={{rolescod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>
  {{pagination}}
</section>
