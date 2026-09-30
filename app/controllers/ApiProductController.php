<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->database();
    }

    public function index()
    {
        $this->authenticated_user();
        $stmt = $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at FROM products ORDER BY id DESC'
        );
        $this->api->respond($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function store()
    {
        $this->authenticated_user();
        $data = $this->validated_product();
        $this->db->raw(
            'INSERT INTO products (product_name, description, price, quantity) VALUES (?, ?, ?, ?)',
            [$data['product_name'], $data['description'], $data['price'], $data['quantity']]
        );
        $this->api->respond(['message' => 'Product added.'], 201);
    }

    public function update($id)
    {
        $this->authenticated_user();
        $id = $this->valid_id($id);
        $this->require_product($id);
        $data = $this->validated_product();
        $this->db->raw(
            'UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ? WHERE id = ?',
            [$data['product_name'], $data['description'], $data['price'], $data['quantity'], $id]
        );
        $this->api->respond(['message' => 'Product updated.']);
    }

    public function delete($id)
    {
        $this->authenticated_user();
        $id = $this->valid_id($id);
        $this->require_product($id);
        $this->db->raw('DELETE FROM products WHERE id = ?', [$id]);
        $this->api->respond(['message' => 'Product deleted.']);
    }

    private function authenticated_user()
    {
        $claims = $this->api->require_jwt();
        if (($claims['type'] ?? '') === 'refresh' || empty($claims['sub'])) {
            $this->api->respond_error('Unauthorized.', 401);
        }
        $stmt = $this->db->raw('SELECT id FROM users WHERE id = ? LIMIT 1', [(int) $claims['sub']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            $this->api->respond_error('Unauthorized.', 401);
        }
        return $user;
    }

    private function valid_id($id)
    {
        $value = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($value === false) {
            $this->api->respond_error('Invalid product ID.', 422);
        }
        return $value;
    }

    private function require_product($id)
    {
        $stmt = $this->db->raw('SELECT id FROM products WHERE id = ? LIMIT 1', [$id]);
        if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->api->respond_error('Product not found.', 404);
        }
    }

    private function validated_product()
    {
        $input = $this->api->body();
        $name = trim((string) ($input['product_name'] ?? ''));
        $description = trim((string) ($input['description'] ?? ''));
        $price = $input['price'] ?? null;
        $quantity = $input['quantity'] ?? null;

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('Product name must be 1 to 100 characters.', 422);
        }
        if ($description === '') {
            $this->api->respond_error('Description is required.', 422);
        }
        if (!is_numeric($price) || (float) $price < 0 || (float) $price > 99999999.99 ||
            !preg_match('/^\d+(\.\d{1,2})?$/', (string) $price)) {
            $this->api->respond_error('Price must be a non-negative amount with at most two decimal places.', 422);
        }
        $valid_quantity = filter_var($quantity, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        if ($valid_quantity === false) {
            $this->api->respond_error('Quantity must be a non-negative whole number.', 422);
        }
        return [
            'product_name' => $name,
            'description' => $description,
            'price' => number_format((float) $price, 2, '.', ''),
            'quantity' => $valid_quantity,
        ];
    }
}
