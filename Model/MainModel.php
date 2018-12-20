<?php
/**
 *
 */
class MainModel {

    function __construct() {
        $this->DataHandler = new DataHandler(DB_HOST, DB_NAME, DB_USERNAME, DB_PASS, DB_TYPE);
        $this->HtmlElements = new HtmlElements();
    }

    public function selectAll() {
        $data = $this->DataHandler->readData(
            "SELECT *
            FROM spelers"
        );

        return $this->HtmlElements->advancedTable($data, "content_table", [1,0,0]);
    }
}

 ?>
