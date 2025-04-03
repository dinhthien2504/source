<?php

class SubCategoryModel
{
    private $id;
    private $category_id;
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

    public function setCateId($category_id)
    {
        return $this->category_id = $category_id;
    }
    public function getCateId()
    {
        return $this->category_id;
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

    public function getAllSubCate()
    {
        return $this->db->getAllRecord('subCategories');
    }
    public function getAllSubCateClient()
    {
        $sql = "SELECT * FROM subcategories ";
        $sql .= "WHERE status = 0";
        return $this->db->getAll($sql);
    }

    public function getSubCateForCate()
    {
        $sql = "SELECT sub.*, cate.name AS category_name
            FROM subcategories sub
            JOIN categories cate ON sub.category_id = cate.id";
        return $this->db->getAll($sql);
    }

    public function getSubCateByIdCate(SubCategoryModel $subCate)
    {
        $sql = "SELECT * FROM subcategories WHERE category_id = ?";
        return $this->db->getAll($sql, [$subCate->getCateId()]);
    }

    public function getCateByIdSubCate(SubCategoryModel $subCate)
    {
        $sql = "SELECT category_id FROM subcategories WHERE id = ?";
        return $this->db->getOne($sql, [$subCate->getId()]);
    }


    public function getOneSubCateForCate(SubCategoryModel $subCate)
    {
        $sql = "SELECT sub.*, cate.name AS category_name
            FROM subcategories sub
            JOIN categories cate ON sub.category_id = cate.id
            WHERE sub.id = ?";
        return $this->db->getOne($sql, [$subCate->getId()]);
    }

    public function addSubCate(SubCategoryModel $subCate)
    {
        $sql = "INSERT INTO subcategories (category_id, name) VALUES (?, ?)";
        return $this->db->insert($sql, [$subCate->getCateId(), $subCate->getName()]);
    }

    public function deleteSubCate(SubCategoryModel $subCate)
    {
        $sql = "DELETE FROM subcategories WHERE id = ?";
        return $this->db->delete($sql, [$subCate->getId()]);
    }

    public function updateSubCate(SubCategoryModel $subCate)
    {
        $sql = "UPDATE subcategories SET category_id = ?, name = ? WHERE id = ?";
        return $this->db->update($sql, [$subCate->getCateId(), $subCate->getName(), $subCate->getId()]);
    }

    public function changeStatusSubCate(SubCategoryModel $subCate)
    {
        $sql = "UPDATE subcategories SET status = ? WHERE id = ?";
        return $this->db->update($sql, [$subCate->getStatus(), $subCate->getId()]);
    }

    public function countProductsBySubCate(SubCategoryModel $subCate)
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE subcategory_id = ?";
        $result = $this->db->getOne($sql, [$subCate->getId()]);
        return $result['total']; // Trả về tổng số sản phẩm
    }
    public function countCateAndSubCate() {
        $sql = "SELECT (COUNT(Scate.id) + COUNT(cate.id)) as quantityCate 
                FROM subcategories Scate 
                LEFT JOIN categories cate ON cate.id = Scate.category_id";
        return $this->db->getOne($sql);
    }
}
