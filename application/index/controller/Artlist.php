<?php
namespace app\index\controller;
use app\index\controller\Common;
class Artlist extends Common
{
    public function index()
    {
        return view('artlist');
    }
}
