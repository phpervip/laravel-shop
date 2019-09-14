<?php
namespace App\Http\ViewComposers;
use App\Services\CategoryService;
use Illuminate\View\View;

class CategoryTreeComposer{

    protected $categoryService;

    // 使用 Laravel 的自动注入，注入我们所依赖的 CategoryService 类
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    // 当渲染指定的模板时，Laravel会调用composer 方法
    public function compose(View $view){
        // 使用with方法注入变量
        $view->with('categoryTree',$this->categoryService->getCategoryTree());
    }
}
