<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
use think\Loader;
class Article extends Base
{   

    public function lst(){
        $artres=db('article')->field('a.*,b.catename')->alias('a')->join('bk_cate b','a.cateid=b.id')->paginate(10);
        $this->assign('artres',$artres);

        return view();
    }
    public function add(){
        
        if (request()->isPost()) {
            $data=input('post.');

            $validate = Loader::validate('Article'); 
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $article = new ArticleModel;
            // if ($_FILES['thumb']['tmp_name']) {
            //     $file = request()->file('thumb');
            //     $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            //     if ($info) {
            //         $data['thumb']='static/uploads/'.$info->getSaveName();;
            //     }
            // }
            if ($article->save($data)) {
                $this->redirect('lst');
            }else{
                $this->error('添加文章失败');
            }
            return;
        }
        $cate= new CateModel();
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }
    public function edit(){
        $artres=ArticleModel::get(input('id'));
        if (request()->isPost()) {

            $validate = Loader::validate('Article'); 
            if (!$validate->scene('edit')->check(input('post.'))) {
                $this->error($validate->getError());
            }
            $artres->save(input('post.'));

            if ($artres!==false) {
                $this->redirect('lst');
            }else{
                $this->error('修改失败');
            }
        }
        $cate= new CateModel();
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        $this->assign('artres',$artres);
        return view();
    }
    public function del(){
        $id=input('id');
        $arts=ArticleModel::get($id);
        $url=$arts->thumb;
        $thumbpath = $_SERVER['DOCUMENT_ROOT']."/bick/public/".$url;
        if (file_exists($thumbpath)) {
            @unlink($thumbpath);
        }
        if (ArticleModel::destroy($id)) {
            $this->redirect('lst');
        }else{
            $this->error('删除失败');
        }
    }

}