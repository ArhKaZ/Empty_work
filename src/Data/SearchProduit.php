<?php


namespace App\Data;


use App\Entity\Article;
use App\Entity\CollectionArticle;

class SearchProduit
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var CollectionArticle[]
     */
    public $collections = [];

    /**
     * @var Article[]
     */
    public $articles = [];

    /**
     * @var bool
     */
    public $dans_catalogue;

    public function __construct() {
        $this->page = 1;
    }

    public function __toString(): string {
        return json_encode($this);
    }

    public static function create($json): SearchProduit
    {
        $data = json_decode($json, true);
        $obj = new SearchProduit();
        $obj->page = $data['page'];
        $obj->q = $data['q'];
        $obj->collections = $data['collections'];
        $obj->articles = $data['articles'];
        $obj->dans_catalogue = $data['dans_catalogue'];
        return $obj;
    }


}