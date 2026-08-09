<?php
// ProductManager.php
class ProductManager {
    private $db;
    
    public function __construct($database) {
        $this->db = $database->getConnection();
    }
    
    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function getProduct($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getProductBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE slug = ? AND is_active = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    public function createProduct($data) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, slug, description, image_path, content, is_active) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['image_path'],
            $data['content'],
            $data['is_active'] ?? 1
        ]);
    }
    
    public function updateProduct($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET name = ?, slug = ?, description = ?, image_path = ?, content = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['image_path'],
            $data['content'],
            $data['is_active'] ?? 1,
            $id
        ]);
    }
    
    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>