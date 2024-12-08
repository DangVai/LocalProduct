<?php
class CategoryController extends BaseController
{
    public function index()
    {
        $categories = 'danh sách các bộ phim đẳng cấp nhật mỏi thời đái';
        $testProduct = [
            [
                'id' => 2,
                'name' => 'Product 1',
                'price' => 244.00,
                'quantity' => 50,
            ],
            [
                'id' => 3,
                'name' => 'Product 2',
                'price' => 100.00,
                'quantity' => 50,
            ],
            [
                'id' => 4,
                'name' => 'Product 3',
                'price' => 100.00,
                'quantity' => 50,
            ],
        ];
        return $this->view('frontend.categories.index',data: [
            'categorys' => $testProduct,
            'categories' => $categories
            ]);
    }
}