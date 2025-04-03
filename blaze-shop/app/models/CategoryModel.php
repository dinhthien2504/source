<?php
class CategoryModel{
    private $id;
    private $name;
    private $status;

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setStatus($status)
    {
        return $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function getAllCate() {
        $sql = "SELECT * FROM categories ";
        return $this->db->getAll($sql);
    }
    public function getAllCateClient(){
        $sql = "SELECT * FROM categories ";
        $sql .= "WHERE status = 0";
        return $this->db->getAll($sql); 
    }
    public function getOneCate(CategoryModel $cate) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->db->getOne($sql, [$cate->getId()]);
    }

    public function addCate(CategoryModel $cate) {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        return $this->db->insert($sql, [$cate->getName()]);
    }

    public function deleteCate(CategoryModel $cate) {
        $sql = "DELETE FROM categories WHERE id = ?";
        return $this->db->delete($sql, [$cate->getId()]);
    }

    public function updateCate(CategoryModel $cate) {
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        return $this->db->update($sql, [$cate->getName(), $cate->getId()]);
    }

    public function countSubCate(CategoryModel $cate) {
        $sql = "SELECT COUNT(*) as total FROM subcategories WHERE category_id = ?";
        $result = $this->db->getOne($sql, [$cate->getId()]);
        return $result['total']; // Trả về tổng số danh mục con
    }
    
    public function changeStatusCate(CategoryModel $cate)
    {
        $sql = "UPDATE categories SET status = ? WHERE id = ?";
        return $this->db->update($sql, [$cate->getStatus(), $cate->getId()]);
    }
    
}
