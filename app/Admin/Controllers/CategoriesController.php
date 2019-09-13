<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    use HasResourceActions;
    /**
     * Title for current resource.
     *
     * @var string
     */
    // protected $title = 'App\Models\Category';

    public function index(Content $content)
    {
        return $content
            ->header('商品类目列表')
            ->body($this->grid());
    }


    public function edit($id, Content $content){
        return $content
            ->header('编辑商品类目')
            ->body($this->form(true)->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建商品类目')
            ->body($this->form(false));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $aa = new Category();
        $grid = new Grid($aa);

        $grid->column('id',__('Id'))->sortable();
        $grid->column('name',__('Name'));
        $grid->column('level',__('Level'));
        $grid->column('is_directory',__('Is directory'))->display(function ($value){
            return $value ? '是' : '否';
        });
        $grid->column('Path',__('Path'));
        $grid->actions(function($actions){
            $actions->disableView();
        });

        return $grid;
    }


    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('parent_id', __('Parent id'));
        $show->field('is_directory', __('Is directory'));
        $show->field('level', __('Level'));
        $show->field('path', __('Path'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($isEditing = false)
    {
        $form = new Form(new Category);

        $form->text('name', __('Name'))->rules('required');

        // 如果是编辑的情况
        if($isEditing){

            // 不允许用户修改『是否目录』和『父类目』字段的值
            // 用 display() 方法来展示值，with() 方法接受一个匿名函数，会把字段值传给匿名函数并把返回值展示出来

            $form->display('is_directory',__('Is directory'))->with(function($value){
                return $value ? '是' : '否';
            });

            // 支持用符号 . 来展示关联关系的字段
            $form->display('parent.name',__('Parent name'));

        }else{

            // 定义一个名为『是否目录』的单选框

            $form->radio('is_directory',__('Is directory'))
            ->options(['1'=>'是','0'=>'否'])
            ->default('0')
            ->rules('required');

            // 定义一个名为父类目的下拉框
            $form->select('parent_id', __('Parent id'))->ajax('/admin/api/categories');
        }
        return $form;
    }


    public function apiIndex(Request $request)
    {
        $search = $request->input('q');
        $result = Category::query()
            ->where('is_directory', true)  // 由于这里选择的是父类目，因此需要限定 is_directory 为 true
            ->where('name','like','%'.$search.'%')
            ->paginate();

       // 把查询出来的结果重新组装成 Laravel-Admin 需要的格式
        $result->setCollection($result->getCollection()->map(
            function (Category $category){
                return ['id'=>$category->id, 'text'=> $category->full_name];
            }));

        return $result;
    }
}
