<?php
namespace app\index\model;
use think\Model;
use app\index\model\Cate;
class Article extends Model
{
	public function geAllArticles($cateid){
		$cate = new Cate();
		$allCateId =$cate->getchilrenid($cateid);
		$artres = $this->where("cateid IN($allCateId)")->order('id desc')->paginate(2);
		return $artres;
	}
	public function geHotArticles($cateid){
		$cate = new Cate();
		$allCateId =$cate->getchilrenid($cateid);
		$artres = $this->where("cateid IN($allCateId)")->order('click desc')->limit(5)->select();
		return $artres;
	}
}