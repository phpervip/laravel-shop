<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Exceptions\InvalidRequestException;
use App\Models\Category;
use App\Models\OrderItem;

class ProductsController extends Controller
{
    // 使用 Laravel 的依赖注入，自动创建 $categoryService 对象
    public function index(Request $request)
    {
        $builder = Product::query()->where('on_sale',true);

        if($search = $request->input('search','')){
            $like = '%'.$search.'%';

            $builder->where(function($query) use ($like){
                    $query->where('title','like',$like)
                    ->orWhere('description','like',$like)
                    ->orWhereHas('skus',function($query) use ($like){
                        $query->where('title','like',$like)
                            ->orWhere('description','like',$like);
                    });
            });
        }

        // 如果有传入 category_id 字段，并且在数据库中有对应的类目
        if($request->input('category_id') && $category = Category::find($request->input('category_id'))){
            if($category->is_directory){
                $builder->whereHas('category',function($query) use ($category){
                    $query->where('path','like',$category->path.$category->id.'-%');
                });
            }else{
                $builder->where('category_id',$category->id);
            }
        }

        if($order = $request->input('order','')){
            if(preg_match('/^(.+)_(asc|desc)$/',$order,$m)){
                if(in_array($m[1],['price','sold_count','rating'])){
                    $builder->orderBy($m[1],$m[2]);
                }
            }
        }

        $products = $builder->paginate(16);


        return view('products.index',[
            'products'=>$products,
            'filters'=>[
                'search'    =>  $search,
                'order'     =>  $order,
            ],
            // 等价于 isset($category) ? $category : null
            'category'      => $category ?? null,
        ]);
    }

    public function show(Product $product, Request $request)
    {
        if(!$product->on_sale)
        {
            throw new InvalidRequestException('商品未上架');
        }

        $favored = false;
        if($user = $request->user()){
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }

        $reviews = OrderItem::query()
            ->with(['order.user', 'productSku']) // 预先加载关联关系
            ->where('product_id', $product->id)
            ->whereNotNull('reviewed_at') // 筛选出已评价的
            ->orderBy('reviewed_at', 'desc') // 按评价时间倒序
            ->limit(10) // 取出 10 条
            ->get();

        return view('products.show',['product'=>$product, 'favored'=>$favored, 'reviews' => $reviews]);

    }


    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if($user->favoriteProducts()->find($product->id)){
            return [];
        }

        $user->favoriteProducts()->attach($product);

        return [];
    }

    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);

        return [];
    }


    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);

        return view('products.favorites', ['products' => $products]);
    }


















}
