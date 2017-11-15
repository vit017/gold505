<?php

namespace V\Gold505;

class RowWorker
{

    private $data = [];

    public function readCSV(string $path, string $delimiter): array
    {
        if (!is_file($path)) {
            throw new \Exception("File ".$path." Not Found!");
        }

        $arRows = [];
        $arNames = [];
        $row = 0;

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (null === $data[0]) {
                    continue;
                }

                if (0 === $row++) {
                    $arNames = $data;
                    continue;
                }

                $arRows[] = new Row($data);
            }
            fclose($handle);
        }

        return $arResult = ["names" => $arNames, "rows" => $arRows];
    }

    public function sortFunctionDateKbk()
    {
        $data = $this->getData();

        usort($data["rows"], function ($a, $b) {
            return $a->id > $b->id;
        });

        return $data["rows"];
    }

    public function joinSame(array $data): array
    {
        $arRows = [];

        foreach ($data as $row) {
            $arRows[$row->id][] = $row;
        }

        return $arRows;
    }

    public function sortRows(string $func, array $fields = []): array
    {
        if (empty($this->getData())) {
            return [];
        }

        return call_user_func_array([$this, $func], $fields);
    }

    public function saveData(array $data): RowWorker
    {
        $this->data = $data;

        return $this;
    }

    public function clearData(): RowWorker
    {
        $this->data = [];

        return $this;
    }

    public function prepareOutput(array $data): array
    {
        $arResult = [];
        $i = 0;
        $percent = 0;

        foreach ($data as $row) {
            $countRow = count($row);

            if ($countRow > 1) {
                foreach ($row as $r) {
                    $percent += (int)$r->percent;
                }
                $row[0]->percent = (int)($percent / $countRow) . " ({$countRow})";

                $arResult[$i] = $row[0];
            } else {
                $arResult[$i] = $row[0];
            }

            $i++;
            $percent = 0;
        }

        return $arResult;
    }

    public function getOutput(string $path, string $delimiter): array
    {
        $fileData = $this->readCSV($path, $delimiter);
        $this->saveData($fileData);
        $sortRows = $this->sortRows("sortFunctionDateKbk");
        $arRows = $this->joinSame($sortRows);
        $arResult = $this->prepareOutput($arRows);

        return $arResult;
    }

    public function getData(): array
    {
        return $this->data;
    }

}