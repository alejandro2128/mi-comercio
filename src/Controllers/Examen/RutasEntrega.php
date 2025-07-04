<?php
namespace Controllers\Examen;

use Controllers\PublicController;
use Dao\Examen\RutasEntrega as DaoRutasEntrega;
use Views\Renderer;

class RutasEntrega extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["rutasEntrega"] = DaoRutasEntrega::getAll();
        Renderer::render("examen/rutasentrega", $viewData);
    }
}
?>
