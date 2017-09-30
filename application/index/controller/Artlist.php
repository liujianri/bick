<?php
namespace app\index\controller;
use app\index\controller\Common;
use app\index\model\Article;
class Artlist extends Common
{
    public function index()
    {
    	$article = new Article();
    	$artRes=$article->geAllArticles(input('cateid'));
    	$this->assign('artRes',$artRes);
    	$hotRes = $article->geHotArticles(input('cateid'));
    	$this->assign('hotRes',$hotRes);
        return view('artlist');
    }
}
