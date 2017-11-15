<?php

namespace V\Gold505;

class Row
{
    public $id;
    public $date;
    public $kbk;
    public $address;
    public $percent;

    public function __construct(array $data)
    {
        $this->date = $data[0];
        $this->kbk = $data[1];
        $this->address = $data[2];
        $this->percent = $data[3];

        $this->id = preg_replace('/[^0-9]/', '', strtotime($this->date) . $this->kbk);
    }
}