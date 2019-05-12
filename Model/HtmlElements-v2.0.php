<?php

Class HtmlElements {
    public function __Construct() {

    }

    /**
     * The purpose of this tablegenerating function is to be simple enough
     * for the newest programmers to understand and maybe expand on
     *
     * @param  array  $dataArray2d              the array needs to be an 2d array with a
     *                                          numbered array around it and associative arrays inside
     * @param  string $tablename(optional)      a name to use for the css class of the table
     * @return string                           The return is a htmlTable
     */
    public function simpleTable(array $dataArray2d, string $tablename = "") {
        // head
        $thead = "<thead><tr>";
        foreach ($dataArray2d as $key => $value) {
            foreach ($value as $k => $v) {
                $thead .= "<th>" . $k . "</th>";
            }
            break;
        }
        $thead .= "</tr></thead>";

        // body
        $tbody = "<tbody>";
        foreach ($dataArray2d as $key => $value) {
            $row = "<tr>";
                foreach ($value as $k => $v) {
                    $row .= "<td>" . $value[$k] . "</td>";
                }
            $row  .= "</tr>";
            $tbody .= $row;
        }
        $tbody .= "</tbody>";

        $table = "<table border='1' class='$tablename'>";
        $table .= $thead;
        $table .= $tbody;
        $table .= "</table>";

        return $table;
    }

    /**
     * This method is used to fill a single row table with the given data
     * @param  array  $generationData needs to be a numbered array
     * @param  string $tableName      a name to use in the html class of the table
     * @return string                 returns a simple 1 row table
     */
    public function generatePaginationTable($generationData, $tableName) {
        $table = "<table class='$tableName'><tr>";
        for ($i=0; $i<count($generationData); $i++) {
            $table .= "<td>" . $generationData[$i] . "</td>";
        }
        $table .= "</tr></table>";

        return $table;
    }

    /**
     * this method is used to generate a table with data contained in them
     * @param  array  $dataArray2d       2 dimensional array the outer being an assoc array and the inner being numbered
     * @param  string $htmlTableName     a name that is used as id for the html table
     *                                   also the following html classes are generated to be used in css
     *                                   $tablename, $tablename--thead, $tablename--tbody, $tablename--tr, $tablename--th, $tablename--td
     *
     * @param  array  $option            an array or string with booleans
     *                                   option[0] border?
     *                                   option[1] width 100%?
     *                                   option[2] future use
     *                                   option[3] future use
     *
     * @param  array  $extraColumnsArray an array with extra column to be added can be used to extent functionality
     * @param  string $specialColumnName a column title for the extra collumns
     * @return
     */
    public function advancedTable(array $dataArray2d, string $tablename, array $option, array $extraColumnsArray = NULL, string $specialColumnName = NULL) {

        if (!empty($extraColumnsArray) ) {
            $extraLength = count($extraColumnsArray[0]);
        } else {
            $extraLength = 0;
        }

        $border = "";
        $width = "";

        if ($option[0] == "1") {
            $border = "border='1'";
        }

        if ($option[1] == "1") {
            $width = "width='100%'";
        }

        if ($option[2] == "1") {
            // select checkboxes
        }

        if ($option[3] == "1") {
            // colgroup normal and extra columns
        }

        //  start of head generation
        $head = "<thead class='$tablename--thead'>";
            foreach ($dataArray2d as $key => $value) {
                $row = "<tr class='$tablename--tr'>";
                "<td></td>";
                    foreach ($value as $columnName => $v) {
                        $columnName[0] = strToUpper($columnName[0]);
                        $row .= "<th class='$tablename--th'>" . $columnName . "</th>";
                    }
                    if ($extraLength > 0) {
                        $extraColumnName[0] = strToUpper($extraColumnName[0]);
                        $row .= "<th class='$tablename--th' colspan='$extraLength'>$extraColumnName</th>";
                    }

                $row .= "</tr>";
                $head .= $row;
                break;
            }
        $head .= "</thead>";

        // body generation
        $body = "<tbody class='$tablename--tbody'>";
            $i=0;
            foreach ($dataArray2d as $key => $value) {
                $row = "<tr class='$tablename--tr'>";
                    foreach ($value as $k => $v) {
                        $row .= "<td class='$tablename--td'>" . $value[$k] . "</td>";
                    }

                    if ($extraColumnsArray !== NULL) {
                        for ($ii=0; $ii < count($extraColumnsArray[$i]); $ii++) {
                            $row .= $extraColumnsArray[$i][$ii];
                        }
                    }
                $row  .= "</tr>";
                $body .= $row;
                $i++;
            }
        $body .= "</tbody>";

        $opening = "<table $border $width class='$tablename' id='$tablename'>";
        $closing .= "</table>";

        return $opening . $head . $table . $closing;
    }

    /**
     * UNTESTED!!!!
     * This method is used to generate a form based on the inputs
     * @param string  $sendMethod           set if the send method is a post, put, get, etc
     * @param string  $targetUrl            set where the form info needs to be sended to
     * @param string  $formName             set a form name to be used for the css
     * @param array   $data              an array with data from a DataBase
     * @param array   $columnNames       an array with database columnNames
     * @param array   $dataTypesArray    an array with database variableTypes used for frontend validation
     * @param array   $requiredNullArray an array with database required fields
     * @param integer $option               option is used to generate slightly diffrent forms
     *                                      option 1 is used to generate a form with no data prefilled
     *                                      option 3 is used to hide the first item of the form
     */
    public function generateForm($sendMethod, $targetUrl, $formName, $data, $columnNames, $dataTypesArray, $requiredNullArray, $option = 0) {
        $head = "<form class='$formName' id='$formName' name='$formName' action='$targetUrl' method='$sendmethod'>";

        $main = "";
        for ($i=0; $i < count($columnNames); $i++) {
            $loc_data           = $data[$columnNames[$i]];
            $loc_columnName     = $columnNames[$i];
            $loc_dataType       = $dataTypesArray[$i];
            $loc_required       = $requiredNullArray[$i];
            if ($option === 1) {
                $data = "";
            }

            if ($option === 3 || $option === "hidden") {
                $item = "<input class='$formName-input' id='$formName-$loc_columnName-label' name='$loc_columnName' value='$loc_data' type='hidden'>";
                $option = 0;
            }

            if ($option === 9 || $option === "hidden") {
                $item = "<input class='$formName-input' id='$formName-$loc_columnName-label' name='$loc_columnName' value='$loc_data' type='hidden'>";

            } else {
                $visibleColumnName = $loc_columnName;
                $visibleColumnName[0] = strToUpper($loc_columnName[0]);
                $item = "<label class='$formName-label' for='$formName-$loc_columnName-label'>$visibleColumnName</label>";
                $item .= "<input class='$formName-input' id='$formName-$loc_columnName-label' name='$loc_columnName' value='$loc_data' $loc_dataType $loc_required><span></span>";
            }

            $main .= $item;
        }

        $foot = "<input class='$formName-button' type='submit' value='submit'></form>";

        return $head . $main . $foot;
    }
}

?>
