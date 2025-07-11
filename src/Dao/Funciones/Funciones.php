<?php
namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
  public static function getFunciones(
    string $partialDescripcion = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
  ) {
    $sqlstr = "SELECT fncod, fndsc, fnest,
                      CASE WHEN fnest = 'ACT' THEN 'Activo'
                           WHEN fnest = 'INA' THEN 'Inactivo'
                           ELSE 'Sin Asignar' END as funcionStatusDsc
               FROM funciones";
    $sqlstrCount = "SELECT COUNT(*) as count FROM funciones";
    $conditions = [];
    $params = [];

    if ($partialDescripcion != "") {
      $conditions[] = "fndsc LIKE :partialDescripcion";
      $params["partialDescripcion"] = "%" . $partialDescripcion . "%";
    }

    if (!in_array($status, ["ACT", "INA", ""])) {
      throw new \Exception("Estado inválido");
    }
    if ($status != "") {
      $conditions[] = "fnest = :status";
      $params["status"] = $status;
    }

    if (count($conditions) > 0) {
      $sqlstr .= " WHERE " . implode(" AND ", $conditions);
      $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }

    if (!in_array($orderBy, ["fncod", "fndsc", ""])) {
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
      "funciones" => $registros,
      "total" => $numeroDeRegistros,
      "page" => $page,
      "itemsPerPage" => $itemsPerPage
    ];
  }

  public static function getFuncionById(string $fncod)
  {
    $sqlstr = "SELECT fncod, fndsc, fnest FROM funciones WHERE fncod = :fncod";
    $params = ["fncod" => $fncod];
    return self::obtenerUnRegistro($sqlstr, $params);
  }

  public static function insertFuncion(string $fncod, string $fndsc, string $fnest)
  {
    $sqlstr = "INSERT INTO funciones (fncod, fndsc, fnest) VALUES (:fncod, :fndsc, :fnest)";
    $params = [
      "fncod" => $fncod,
      "fndsc" => $fndsc,
      "fnest" => $fnest
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function updateFuncion(string $fncod, string $fndsc, string $fnest)
  {
    $sqlstr = "UPDATE funciones SET fndsc = :fndsc, fnest = :fnest WHERE fncod = :fncod";
    $params = [
      "fncod" => $fncod,
      "fndsc" => $fndsc,
      "fnest" => $fnest
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function deleteFuncion(string $fncod)
  {
    $sqlstr = "DELETE FROM funciones WHERE fncod = :fncod";
    $params = ["fncod" => $fncod];
    return self::executeNonQuery($sqlstr, $params);
  }
}
?>
