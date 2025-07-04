<?php
namespace Dao\Examen;

use Dao\Table;

class RutasEntrega extends Table
{
    public static function getAll()
    {
        $sqlstr = "SELECT id_ruta, origen, destino, distancia_km, duracion_min FROM RutasEntrega";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $id_ruta)
    {
        $sqlstr = "SELECT id_ruta, origen, destino, distancia_km, duracion_min FROM RutasEntrega WHERE id_ruta = :id_ruta";
        $params = ["id_ruta" => $id_ruta];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insert(
        string $origen,
        string $destino,
        float $distancia_km,
        int $duracion_min
    ) {
        $sqlstr = "INSERT INTO RutasEntrega (origen, destino, distancia_km, duracion_min) VALUES (:origen, :destino, :distancia_km, :duracion_min)";
        $params = [
            "origen" => $origen,
            "destino" => $destino,
            "distancia_km" => $distancia_km,
            "duracion_min" => $duracion_min
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function update(
        int $id_ruta,
        string $origen,
        string $destino,
        float $distancia_km,
        int $duracion_min
    ) {
        $sqlstr = "UPDATE RutasEntrega SET origen = :origen, destino = :destino, distancia_km = :distancia_km, duracion_min = :duracion_min WHERE id_ruta = :id_ruta";
        $params = [
            "id_ruta" => $id_ruta,
            "origen" => $origen,
            "destino" => $destino,
            "distancia_km" => $distancia_km,
            "duracion_min" => $duracion_min
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function delete(int $id_ruta)
    {
        $sqlstr = "DELETE FROM RutasEntrega WHERE id_ruta = :id_ruta";
        $params = ["id_ruta" => $id_ruta];
        return self::executeNonQuery($sqlstr, $params);
    }
}
?>
