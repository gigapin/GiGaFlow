<?php


namespace Src;

class Pagination
{

    public function paginate(array $array, int $length)
    {
        if (isset($_GET['page'])) {
            $offset = $length * $_GET['page'];

            return array_slice($array, $offset, $length);
        }
    }


}