<?php
namespace Controllers\Usuarios;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Usuarios\Usuarios as DaoUsuarios;
use Utilities\Site;
use Utilities\Validators;

class Usuario extends PublicController
{
  private $viewData = [];
  private $mode = "DSP";
  private $modeDescriptions = [
    "DSP" => "Detalle de %s %s",
    "INS" => "Nuevo Usuario",
    "UPD" => "Editar %s %s",
    "DEL" => "Eliminar %s %s"
  ];
  private $readonly = "";
  private $showCommitBtn = true;
  private $usuario = [
    "usuarioId" => 0,
    "usuarioNombre" => "",
    "usuarioCorreo" => "",
    "usuarioRol" => "USR",
    "usuarioEstado" => "ACT"
  ];
  private $usuario_xss_token = "";

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
      Renderer::render("usuarios/usuario", $this->viewData);
    } catch (\Exception $ex) {
      Site::redirectToWithMsg("index.php?page=Usuarios-Usuarios", $ex->getMessage());
    }
  }

  private function getData()
  {
    $this->mode = $_GET["mode"] ?? "NOF";
    if (isset($this->modeDescriptions[$this->mode])) {
      $this->readonly = $this->mode === "DEL" ? "readonly" : "";
      $this->showCommitBtn = $this->mode !== "DSP";
      if ($this->mode !== "INS") {
        $this->usuario = DaoUsuarios::getUsuarioById(intval($_GET["usuarioId"]));
        if (!$this->usuario) {
          throw new \Exception("No se encontró el Usuario");
        }
      }
    } else {
      throw new \Exception("Formulario cargado en modalidad inválida");
    }
  }

  private function validateData()
  {
    $errors = [];
    $this->usuario_xss_token = $_POST["usuario_xss_token"] ?? "";
    $this->usuario["usuarioId"] = intval($_POST["usuarioId"] ?? "");
    $this->usuario["usuarioNombre"] = strval($_POST["usuarioNombre"] ?? "");
    $this->usuario["usuarioCorreo"] = strval($_POST["usuarioCorreo"] ?? "");
    $this->usuario["usuarioRol"] = strval($_POST["usuarioRol"] ?? "USR");
    $this->usuario["usuarioEstado"] = strval($_POST["usuarioEstado"] ?? "ACT");

    if (Validators::IsEmpty($this->usuario["usuarioNombre"])) {
      $errors["usuarioNombre_error"] = "El nombre es requerido";
    }
    if (Validators::IsEmpty($this->usuario["usuarioCorreo"])) {
      $errors["usuarioCorreo_error"] = "El correo es requerido";
    }
    if (!in_array($this->usuario["usuarioRol"], ["ADM", "USR"])) {
      $errors["usuarioRol_error"] = "Rol inválido";
    }
    if (!in_array($this->usuario["usuarioEstado"], ["ACT", "INA"])) {
      $errors["usuarioEstado_error"] = "Estado inválido";
    }

    if (count($errors) > 0) {
      foreach ($errors as $key => $value) {
        $this->usuario[$key] = $value;
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
        throw new \Exception("Modo inválido");
    }
  }

  private function handleInsert()
  {
    $result = DaoUsuarios::insertUsuario(
      $this->usuario["usuarioNombre"],
      $this->usuario["usuarioCorreo"],
      $this->usuario["usuarioRol"],
      $this->usuario["usuarioEstado"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg("index.php?page=Usuarios-Usuarios", "Usuario creado exitosamente");
    }
  }

  private function handleUpdate()
  {
    $result = DaoUsuarios::updateUsuario(
      $this->usuario["usuarioId"],
      $this->usuario["usuarioNombre"],
      $this->usuario["usuarioCorreo"],
      $this->usuario["usuarioRol"],
      $this->usuario["usuarioEstado"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg("index.php?page=Usuarios-Usuarios", "Usuario actualizado exitosamente");
    }
  }

  private function handleDelete()
  {
    $result = DaoUsuarios::deleteUsuario($this->usuario["usuarioId"]);
    if ($result > 0) {
      Site::redirectToWithMsg("index.php?page=Usuarios-Usuarios", "Usuario eliminado exitosamente");
    }
  }

  private function setViewData(): void
  {
    $this->viewData["mode"] = $this->mode;
    $this->viewData["usuario_xss_token"] = $this->usuario_xss_token;
    $this->viewData["FormTitle"] = sprintf(
      $this->modeDescriptions[$this->mode],
      $this->usuario["usuarioId"],
      $this->usuario["usuarioNombre"]
    );
    $this->viewData["showCommitBtn"] = $this->showCommitBtn;
    $this->viewData["readonly"] = $this->readonly;

    $usuarioEstadoKey = "usuarioEstado_" . strtolower($this->usuario["usuarioEstado"]);
    $this->usuario[$usuarioEstadoKey] = "selected";
    $usuarioRolKey = "usuarioRol_" . strtoupper($this->usuario["usuarioRol"]);
    $this->usuario[$usuarioRolKey] = "selected";

    $this->viewData["usuario"] = $this->usuario;
  }
}
?>
