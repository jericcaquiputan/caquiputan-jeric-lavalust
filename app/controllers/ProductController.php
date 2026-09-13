<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $this->call->view('products', ['products' => $this->ProductModel->all()]);
    }

    public function create()
    {
        $this->call->view('product_form', [
            'title' => 'Add Product',
            'action' => '/products/store',
            'product' => [],
            'errors' => [],
        ]);
    }

    public function store()
    {
        $data = $this->product_data();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->show_form('Add Product', '/products/store', $data, $errors);
            return;
        }

        $this->ProductModel->insert($data);
        $this->response->redirect_after_post('/products');
    }

    public function edit($id)
    {
        $id = (int) $id;
        $product = $this->ProductModel->find($id);

        if (empty($product)) {
            $this->response->redirect('/products');
            return;
        }

        $this->show_form('Edit Product', '/products/update/' . $id, $product, []);
    }

    public function update($id)
    {
        $id = (int) $id;
        $data = $this->product_data();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['id'] = $id;
            $this->show_form('Edit Product', '/products/update/' . $id, $data, $errors);
            return;
        }

        $this->ProductModel->update($id, $data);
        $this->response->redirect_after_post('/products');
    }

    public function delete($id)
    {
        $this->ProductModel->delete((int) $id);
        $this->response->redirect_after_post('/products');
    }

    private function product_data()
    {
        return [
            'product_name' => trim((string) $this->request->post('product_name', '')),
            'description' => trim((string) $this->request->post('description', '')),
            'price' => trim((string) $this->request->post('price', '')),
            'quantity' => trim((string) $this->request->post('quantity', '')),
        ];
    }

    private function validate($data)
    {
        $errors = [];

        if ($data['product_name'] === '' || strlen($data['product_name']) > 100) {
            $errors['product_name'] = 'Product name is required and must be 100 characters or fewer.';
        }
        if ($data['description'] === '') {
            $errors['description'] = 'Description is required.';
        }
        if ($data['price'] === '' || !is_numeric($data['price']) || (float) $data['price'] < 0) {
            $errors['price'] = 'Enter a valid non-negative price.';
        }
        if ($data['quantity'] === '' || filter_var($data['quantity'], FILTER_VALIDATE_INT) === false || (int) $data['quantity'] < 0) {
            $errors['quantity'] = 'Enter a valid non-negative whole number.';
        }

        return $errors;
    }

    private function show_form($title, $action, $product, $errors)
    {
        $this->call->view('product_form', compact('title', 'action', 'product', 'errors'));
    }
}
