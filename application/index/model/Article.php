<?php
namespace app\index\model;
use think\Model;
use app\index\model\Cate;
class Article extends Model
{
	public function geAllArticles($cateid){
		$cate = new Cate();
		$allCateId =$cate->getchilrenid($cateid);
		$artres = $this->where("cateid IN($allCateId)")->paginate(10);
		return $artres;
	}
}