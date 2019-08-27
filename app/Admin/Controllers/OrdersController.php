<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    use HasResourceActions;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Order';



    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        // 只展示已支付的订单，并且默认按支付时间倒序排序
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at','desc');

        $grid->column('no','订单流水号');
        // 展示关联关系字段时，使用column方法
        $grid->column('user.name', '买家');
        $grid->column('total_amount', '总金额')->sortable();
        $grid->column('paid_at', '支付时间')->sortable();
        $grid->column('ship_status','物流')->display(function($value){
            return Order::$refundStatusMap[$value];
        });
        // 禁用创建按钮
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 禁用删除和编辑按钮
            $actions->disableDelete();
            $actions->disableEdit();
        });

        return $grid;
    }



    public function show(Order $order, Content $content)
    {
        return $content
            ->header('查看订单')
            // body 方法可以接受 Laravel 的视图作为参数
            ->body(view('admin.orders.show', ['order' => $order]));
    }
}
