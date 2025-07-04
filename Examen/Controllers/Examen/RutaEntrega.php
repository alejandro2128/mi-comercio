<?php
namespace Controllers\Examen;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Examen\RutasEntrega as DaoRutasEntrega;
use Utilities\Site;
use Utilities\Validators;

class RutaEntrega extends PublicController
{
  private $viewData = [];
  private $mode = "DSP";
  private $modeDescriptions = [
    "DSP" => "Detalle de Ruta %s",
    "INS" => "Nueva Ruta de Entrega",
    "UPD" => "Editar Ruta %s",
    "DEL" => "Eliminar Ruta %s"
  ];
  private $readonly = "";
  private $showCommitBtn = true;
  private $rutaEntrega = [
    "id_ruta" => 0,
    "origen" => "",
    "destino" => "",
    "distancia_km" => 0.0,
    "duracion_min" => 0
  ];
  private $ruta_xss_token = "";

  public function run(): void
  {
    try {
      $this->getData();
      if ($this->isPostBack()) {
        if ($this->validateData()) {
          $this->handlePostAction();
        }
      }
      $this->setViewData();
      Renderer::render("examen/rutaentrega", $this->viewData);
    } catch (\Exception $ex) {
      Site::redirectToWithMsg(
        "index.php?page=Examen_RutasEntrega",
        $ex->getMessage()
      );
    }
  }

  private function getData()
  {
    $this->mode = $_GET["mode"] ?? "NOF";
    if (isset($this->modeDescriptions[$this->mode])) {
      $this->readonly = $this->mode === "DEL" ? "readonly" : "";
      $this->showCommitBtn = $this->mode !== "DSP";
      if ($this->mode !== "INS") {
        $this->rutaEntrega = DaoRutasEntrega::getById(intval($_GET["id_ruta"]));
        if (!$this->rutaEntrega) {
          throw new \Exception("No se encontró la Ruta", 1);
        }
      }
    } else {
      throw new \Exception("Formulario cargado en modalidad invalida", 1);
    }
  }

  private function validateData()
  {
    $errors = [];
    $this->ruta_xss_token = $_POST["ruta_xss_token"] ?? "";
    $this->rutaEntrega["id_ruta"] = intval($_POST["id_ruta"] ?? "");
    $this->rutaEntrega["origen"] = strval($_POST["origen"] ?? "");
    $this->rutaEntrega["destino"] = strval($_POST["destino"] ?? "");
    $this->rutaEntrega["distancia_km"] = floatval($_POST["distancia_km"] ?? "");
    $this->rutaEntrega["duracion_min"] = intval($_POST["duracion_min"] ?? "");

    if (Validators::IsEmpty($this->rutaEntrega["origen"])) {
      $errors["origen_error"] = "El origen es requerido";
    }

    if (Validators::IsEmpty($this->rutaEntrega["destino"])) {
      $errors["destino_error"] = "El destino es requerido";
    }

    if ($this->rutaEntrega["distancia_km"] <= 0) {
      $errors["distancia_km_error"] = "La distancia debe ser mayor a cero";
    }

    if ($this->rutaEntrega["duracion_min"] <= 0) {
      $errors["duracion_min_error"] = "La duración debe ser mayor a cero";
    }

    if (count($errors) > 0) {
      foreach ($errors as $key => $value) {
        $this->rutaEntrega[$key] = $value;
      }
      return false;
    }
    return true;
  }

  private function handlePostAction()
  {
    switch ($this->mode) {
      case "INS":
        $this->handleInsert();
        break;
      case "UPD":
        $this->handleUpdate();
        break;
      case "DEL":
        $this->handleDelete();
        break;
      default:
        throw new \Exception("Modo invalido", 1);
    }
  }

  private function handleInsert()
  {
    $result = DaoRutasEntrega::insert(
      $this->rutaEntrega["origen"],
      $this->rutaEntrega["destino"],
      $this->rutaEntrega["distancia_km"],
      $this->rutaEntrega["duracion_min"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Examen_RutasEntrega",
        "Ruta de Entrega creada exitosamente"
      );
    }
  }

  private function handleUpdate()
  {
    $result = DaoRutasEntrega::update(
      $this->rutaEntrega["id_ruta"],
      $this->rutaEntrega["origen"],
      $this->rutaEntrega["destino"],
      $this->rutaEntrega["distancia_km"],
      $this->rutaEntrega["duracion_min"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Examen_RutasEntrega",
        "Ruta de Entrega actualizada exitosamente"
      );
    }
  }

  private function handleDelete()
  {
    $result = DaoRutasEntrega::delete($this->rutaEntrega["id_ruta"]);
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Examen_RutasEntrega",
        "Ruta de Entrega eliminada exitosamente"
      );
    }
  }

  private function setViewData(): void
  {
    $this->viewData["mode"] = $this->mode;
    $this->viewData["ruta_xss_token"] = $this->ruta_xss_token;
    $this->viewData["FormTitle"] = sprintf(
      $this->modeDescriptions[$this->mode],
      $this->rutaEntrega["id_ruta"]
    );
    $this->viewData["showCommitBtn"] = $this->showCommitBtn;
    $this->viewData["readonly"] = $this->readonly;
    $this->viewData["rutaEntrega"] = $this->rutaEntrega;
  }
}
?>
