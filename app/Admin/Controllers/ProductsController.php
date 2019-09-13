<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;


class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Product';


    public function index(Content $content)
    {
        return $content
            ->header('商品列表')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->model()->with(['category']);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', '商品名称');
        // Laravel-Admin 支持用符号 . 来展示关联关系的字段
        $grid->column('category.name','类目');
        $grid->column('on_sale', '已上架')->display(function($value){
            return $value?'是':'否';
        });
        $grid->column('rating', '评分');
        $grid->column('sold_count', '销量');
        $grid->column('review_count', '评论数');
        $grid->column('price', '价格');

        $grid->actions(function($actions){
            $actions->disableView();
            $actions->disableDelete();
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
        $show->field('on_sale', __('On sale'));
        $show->field('rating', __('Rating'));
        $show->field('sold_count', __('Sold count'));
        $show->field('review_count', __('Review count'));
        $show->field('price', __('Price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

     public function create(Content $content)
    {
        return $content->header('创建商品')->body($this->form());
    }

    public function edit($id, Content $content)
    {
        return $content->header('编辑商品')->body($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);

        $form->editor('description', '商品描述')->rules('required');

        $form->text('title','商品名称')->rules('required');


        // 添加一个类目字段，与之前类目管理类似，使用 Ajax 的方式来搜索添加
        $form->select('category_id','类目')->options(function($id){
            $category = Category::find($id);
            if( $category ){
                return [ $category->id => $category->full_name ];
            }
        })->ajax('/admin/api/categories?is_directory=0');


        $form->image('image', '封面图片')->rules('required|image');

        $form->radio('on_sale', '上架')->options(['1'=>'是','0'=>'否'])->default('0');

        // 直接添加一对关的关联模型
        $form->hasMany('skus', 'SKU列表', function(Form\NestedForm $form){
            $form->text('title','SKU 名称')->rules('required');
            $form->text('description','SKU 描述')->rules('required');
            $form->text('price','单价')->rules('required|numeric|min:0.01');
            $form->text('stock','剩余库存')->rules('required|integer|min:0');
        });
        $form->saving(function(Form $form){
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price')?:0;
        });
        return $form;
    }


    public function store()
    {
        return $this->form()->store();
    }



    public function update($id)
    {
        return $this->form()->update($id);
    }


}
