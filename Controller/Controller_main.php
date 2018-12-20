<?php

/**
 *
 */
class Controller_main {
    function __construct() {
        $this->TemplatingSystem = new TemplatingSystem("view/templates/default.tpl");
        $this->MainModel = new MainModel();
    }

    public function mydefault() {
        $main = file_get_contents("view/partials/main.html");
        $mainData = $this->MainModel->selectAll();

        $this->TemplatingSystem->setTemplateData("main", $main);
        $this->TemplatingSystem->setTemplateData("mainData", $mainData);
        $this->TemplatingSystem->setTemplateData("appdir", APP_DIR);
        return $this->TemplatingSystem->getParsedTemplate();
    }
}


 ?>
