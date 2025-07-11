<?php
namespace Dao\Usuarios;

use Dao\Table;

class Usuarios extends Table
{
  public static function getUsuarios(
    string $partialNombre = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
  ) {
    $sqlstr = "SELECT usercod, username, useremail, usertipo, userest FROM usuario";
    $sqlstrCount = "SELECT COUNT(*) as count FROM usuario";
    $conditions = [];
    $params = [];

    if ($partialNombre != "") {
      $conditions[] = "username LIKE :partialNombre";
      $params["partialNombre"] = "%" . $partialNombre . "%";
    }
    if (!in_array($status, ["ACT", "INA", ""])) {
      throw new \Exception("Estado inválido");
    }
    if ($status != "") {
      $conditions[] = "userest = :status";
      $params["status"] = $status;
    }

    if (count($conditions) > 0) {
      $sqlstr .= " WHERE " . implode(" AND ", $conditions);
      $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }

    if (!in_array($orderBy, ["usercod", "username", "useremail", "usertipo", ""])) {
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
      $page = $pagesCount - 1;
    }

    $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;
    $registros = self::obtenerRegistros($sqlstr, $params);
    return ["usuarios" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
  }

  public static function getUsuarioById(int $usercod)
  {
    $sqlstr = "SELECT usercod, username, useremail, usertipo, userest FROM usuario WHERE usercod = :usercod";
    $params = ["usercod" => $usercod];
    return self::obtenerUnRegistro($sqlstr, $params);
  }

  public static function insertUsuario(string $username, string $useremail, string $usertipo, string $userest)
  {
    $sqlstr = "INSERT INTO usuario (username, useremail, usertipo, userest) VALUES (:username, :useremail, :usertipo, :userest)";
    $params = [
      "username" => $username,
      "useremail" => $useremail,
      "usertipo" => $usertipo,
      "userest" => $userest
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function updateUsuario(int $usercod, string $username, string $useremail, string $usertipo, string $userest)
  {
    $sqlstr = "UPDATE usuario SET username = :username, useremail = :useremail, usertipo = :usertipo, userest = :userest WHERE usercod = :usercod";
    $params = [
      "usercod" => $usercod,
      "username" => $username,
      "useremail" => $useremail,
      "usertipo" => $usertipo,
      "userest" => $userest
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function deleteUsuario(int $usercod)
  {
    $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod";
    $params = ["usercod" => $usercod];
    return self::executeNonQuery($sqlstr, $params);
  }
}
?>
