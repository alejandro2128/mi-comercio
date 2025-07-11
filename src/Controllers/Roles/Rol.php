<?php
namespace Controllers\Roles;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Roles\Roles as DaoRoles;
use Utilities\Site;
use Utilities\Validators;

class Rol extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de Rol %s",
        "INS" => "Nuevo Rol",
        "UPD" => "Editar Rol %s",
        "DEL" => "Eliminar Rol %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $rol = [
        "rolesCod" => "",
        "rolesDsc" => "",
        "rolesEst" => "ACT"
    ];
    private $rol_xss_token = "";

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
            Renderer::render("roles/rol", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg("index.php?page=Roles-Roles", $ex->getMessage());
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";
        if (isset($this->modeDescriptions[$this->mode])) {
            $this->readonly = $this->mode === "DEL" ? "readonly" : "";
            $this->showCommitBtn = $this->mode !== "DSP";
            if ($this->mode !== "INS") {
                $this->rol = DaoRoles::getRolById($_GET["rolesCod"]);
                if (!$this->rol) {
                    throw new \Exception("No se encontró el Rol");
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad inválida");
        }
    }

    private function validateData()
    {
        $errors = [];
        $this->rol_xss_token = $_POST["rol_xss_token"] ?? "";
        $this->rol["rolesCod"] = strval($_POST["rolesCod"] ?? "");
        $this->rol["rolesDsc"] = strval($_POST["rolesDsc"] ?? "");
        $this->rol["rolesEst"] = strval($_POST["rolesEst"] ?? "ACT");

        if (Validators::IsEmpty($this->rol["rolesCod"])) {
            $errors["rolesCod_error"] = "El código del rol es requerido";
        }
        if (Validators::IsEmpty($this->rol["rolesDsc"])) {
            $errors["rolesDsc_error"] = "La descripción del rol es requerida";
        }
        if (!in_array($this->rol["rolesEst"], ["ACT", "INA"])) {
            $errors["rolesEst_error"] = "Estado inválido";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->rol[$key] = $value;
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
        $result = DaoRoles::insertRol(
            $this->rol["rolesCod"],
            $this->rol["rolesDsc"],
            $this->rol["rolesEst"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg("index.php?page=Roles-Roles", "Rol creado exitosamente");
        }
    }

    private function handleUpdate()
    {
        $result = DaoRoles::updateRol(
            $this->rol["rolesCod"],
            $this->rol["rolesDsc"],
            $this->rol["rolesEst"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg("index.php?page=Roles-Roles", "Rol actualizado exitosamente");
        }
    }

    private function handleDelete()
    {
        $result = DaoRoles::deleteRol($this->rol["rolesCod"]);
        if ($result > 0) {
            Site::redirectToWithMsg("index.php?page=Roles-Roles", "Rol eliminado exitosamente");
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["rol_xss_token"] = $this->rol_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->rol["rolesCod"]
        );
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;

        $rolEstKey = "rolesEst_" . strtoupper($this->rol["rolesEst"]);
        $this->rol[$rolEstKey] = "selected";

        $this->viewData["rol"] = $this->rol;
    }
}
?>
