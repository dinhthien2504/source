<?php 
class ImageModel{
    private $id = 0;
    private $product_id;
    private $image = '';

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
    }
    public function getProduct_id()
    {
        return $this->product_id;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function insertImg(ImageModel $img) {
        $sql = "INSERT INTO productimages (product_id, image) VALUES (?, ?)";
        return $this->db->insert($sql, [$img->getProduct_id(),$img->getImage()]);
    }
    public function getImgByIdPro(ImageModel $img){
        $sql = "SELECT * FROM productimages ";
        $sql .= "WHERE product_id = ?";
        return $this->db->getAll($sql, [$img->getProduct_id()]);
    }
    public function getImgById(ImageModel $img){
        $sql = "SELECT image FROM productimages ";
        $sql .= "WHERE id = ?";
        return $this->db->getOne($sql, [$img->getId()]);
    }
    public function deleteImg(ImageModel $img) {
        $imgData = $this->getImgById($img);
        $imagePath = _DIR_ROOT . '/public/assets/img/' . $imgData['image'];
        if (file_exists($imagePath)) {
            if (!unlink($imagePath)) {
                return false;
            }
        }
        return $this->db->delete("DELETE FROM productimages WHERE id = ?", [$img->getId()]);
    }
    
}