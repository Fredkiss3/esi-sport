<?php


namespace App\Controller;


use App\Repository\InfoFlashRepository;

trait BaseControllerTrait
{
    private $repositories = [
//        InfoFlashRepository::class,

    ];

    public function getData() : array
    {
        return [];
    }
}