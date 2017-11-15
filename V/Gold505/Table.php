<?php

namespace V\Gold505;

class Table
{

    private $columns = [];
    private $hideColumns = [];
    private $rows = [];


    public function setColumns(array $columns, array $hideColumns = []): Table
    {
        $this->columns = $columns;
        $this->hideColumns = $hideColumns;

        return $this;
    }

    public function setRows(array $data): Table
    {
        $this->rows = $data;

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function begin(): string
    {
        return "<table cellspacing=\"2\" border=\"1\" cellpadding=\"5\">";
    }

    public function getHead(): string
    {
        $output = "<thead><tr>";

        foreach ($this->columns as $name) {
            $output .= "<th>" . $name . "</th>";
        }

        $output .= "</tr></thead>";

        return $output;
    }

    public function getBody(): string
    {
        $output = "<tbody>";

        foreach ($this->rows as $row) {
            $output .= "<tr>";

            foreach ($row as $key => $val) {
                if (in_array($key, $this->hideColumns)) continue;

                $output .= "<td>" . $val . "</td>";
            }

            $output .= "</tr>";
        }

        $output .= "</tbody>";

        return $output;
    }

    public function end(): string
    {
        return "</table>";
    }

    public function display()
    {
        $begin = $this->begin();
        $head = $this->getHead();
        $body = $this->getBody();
        $end = $this->end();

        echo $begin . $head . $body . $end;
    }
}