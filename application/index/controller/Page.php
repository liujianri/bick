<?php
namespace app\index\controller;
use app\index\controller\Common;
class Page extends Common
{
    public function index()
    {
        return view('page');
    }
}
