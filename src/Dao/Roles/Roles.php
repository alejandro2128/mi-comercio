<?php
namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
  public static function getRoles(
    string $partialDescripcion = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
  ) {
    $sqlstr = "SELECT rolescod, rolesdsc, rolesest, 
                      CASE WHEN rolesest = 'ACT' THEN 'Activo' 
                           WHEN rolesest = 'INA' THEN 'Inactivo' 
                           ELSE 'Sin Asignar' END as rolesStatusDsc 
               FROM roles";
    $sqlstrCount = "SELECT COUNT(*) as count FROM roles";
    $conditions = [];
    $params = [];

    if ($partialDescripcion != "") {
      $conditions[] = "rolesdsc LIKE :partialDescripcion";
      $params["partialDescripcion"] = "%" . $partialDescripcion . "%";
    }

    if (!in_array($status, ["ACT", "INA", ""])) {
      throw new \Exception("Estado inválido");
    }
    if ($status != "") {
      $conditions[] = "rolesest = :status";
      $params["status"] = $status;
    }

    if (count($conditions) > 0) {
      $sqlstr .= " WHERE " . implode(" AND ", $conditions);
      $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }

    if (!in_array($orderBy, ["rolescod", "rolesdsc", ""])) {
      throw new \Exception("Orden inválido");
    }
    if ($orderBy != "") {
      $sqlstr .= " ORDER BY " . $orderBy;
      if ($orderDescending) {
        $sqlstr .= " DESC";
      }
    }

    $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
    $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
    if ($page > $pagesCount - 1) {
      $page = max($pagesCount - 1, 0);
    }
    if ($page < 0) {
      $page = 0;
    }

    $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;
    $registros = self::obtenerRegistros($sqlstr, $params);

    return [
      "roles" => $registros,
      "total" => $numeroDeRegistros,
      "page" => $page,
      "itemsPerPage" => $itemsPerPage
    ];
  }

  public static function getRolById(string $rolescod)
  {
    $sqlstr = "SELECT rolescod, rolesdsc, rolesest FROM roles WHERE rolescod = :rolescod";
    $params = ["rolescod" => $rolescod];
    return self::obtenerUnRegistro($sqlstr, $params);
  }

  public static function insertRol(string $rolescod, string $rolesdsc, string $rolesest)
  {
    $sqlstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest) VALUES (:rolescod, :rolesdsc, :rolesest)";
    $params = [
      "rolescod" => $rolescod,
      "rolesdsc" => $rolesdsc,
      "rolesest" => $rolesest
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function updateRol(string $rolescod, string $rolesdsc, string $rolesest)
  {
    $sqlstr = "UPDATE roles SET rolesdsc = :rolesdsc, rolesest = :rolesest WHERE rolescod = :rolescod";
    $params = [
      "rolescod" => $rolescod,
      "rolesdsc" => $rolesdsc,
      "rolesest" => $rolesest
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function deleteRol(string $rolescod)
  {
    $sqlstr = "DELETE FROM roles WHERE rolescod = :rolescod";
    $params = ["rolescod" => $rolescod];
    return self::executeNonQuery($sqlstr, $params);
  }
}
?>

