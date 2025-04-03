<?php
class RateImageModel {
    private $id;
    private $rate_id;
    private $img;

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
    public function setRate_id($rate_id)
    {
        $this->rate_id = $rate_id;
    }
    public function getRate_id()
    {
        return $this->rate_id;
    }
    public function setImg($img)
    {
        $this->img = $img;
    }
    public function getImg()
    {
        return $this->img;
    }
    public function insertImg(RateImageModel $img){
        $sql = "INSERT INTO rateimages (rate_id, img) VALUES (?, ?)";
        return $this->db->insert($sql, [$img->getRate_id(), $img->getImg()]);
    }
    
}