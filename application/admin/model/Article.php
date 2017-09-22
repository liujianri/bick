<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
   protected static function init()
    {
        Article::event('before_insert', function ($article) {
            if ($_FILES['thumb']['tmp_name']) {
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $article['thumb']='uploads/'.$info->getSaveName();
                }
            }
        });
        Article::event('before_update', function ($article) {
            if ($_FILES['thumb']['tmp_name']) {
                $art=Article::find($article->id);
                $thumbpath = $_SERVER['DOCUMENT_ROOT']."/bick/public/".$art['thumb'];
                if (file_exists($thumbpath)) {
                    @unlink($thumbpath);
                }
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $article['thumb']='uploads/'.$info->getSaveName();
                }
            }
           
        });
    }

}