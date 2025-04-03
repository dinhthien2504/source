<?php
class AuthModel
{
    private $id = 0;
    private $name;
    private $phone;
    private $email;
    private $image = null;
    private $password;
    private $address = null;
    private $role = 0;
    private $status;

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

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // Đăng ký User
    public function insert_user(AuthModel $user)
    {
        $name = $user->getName();
        $phone = $user->getPhone();
        $email = $user->getEmail();
        $image = $user->getImage() !== null ? $user->getImage() : null;
        $password = $user->getPassword();
        $address = $user->getAddress() !== null ? $user->getAddress() : null;
        $sql = "INSERT INTO users (name, phone, email, image, password, address) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $name,
            $phone,
            $email,
            $image,
            $password,
            $address,
        ];
        // Chạy câu lệnh SQL
        return $this->db->insert($sql, $params);
    }

    // Đăng nhập
    public function login(AuthModel $user)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND status = 0 LIMIT 1";
        $db_user = $this->db->getOne($sql, ['email' => $user->getEmail()]);
        if ($db_user) {
            if ($db_user && $db_user['status'] != 1 && $user->getPassword() == $db_user['password']) {
                return $db_user; 
            }
        }
        return false;
    }

    //Update
    public function update_user(AuthModel $user)
    {
        $id = $user->getId();
        $name = $user->getName();
        $phone = $user->getPhone();
        $email = $user->getEmail();
        $image = $user->getImage() !== null ? $user->getImage() : null;
        $password = $user->getPassword();
        $address = $user->getAddress() !== null ? $user->getAddress() : null;
        $sql = "UPDATE users SET name = ?, phone = ?, email = ?, image = ?, password = ?, address = ? WHERE id = ?";
        $params = [
            $name,
            $phone,
            $email,
            $image,
            $password,
            $address,
            $id
        ];
        return $this->db->update($sql, $params);
    }

    //updatepass
    public function updatePass(AuthModel $user)
    {
        $email = $user->getEmail();
        $password = $user->getPassword();
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $params = [
            $password,
            $email
        ];
        return $this->db->update($sql, $params);
    }
    public function getUserEmail(AuthModel $user)
    {
        $email = $user->getEmail();
        $sql = "SELECT * FROM users WHERE email = ?";
        $params = [$email];

        return $this->db->getOne($sql, $params);
    }





    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $params = ['id' => $id];
        return $this->db->getOne($sql, $params);
    }

    public function getAllUserByRole(AuthModel $user)
    {
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE role = ? ";
        $sql .= "AND id NOT IN (?, ?)";
        return $this->db->getAll($sql, [$user->getRole(), 1, $user->getId()]);
    }

    public function getOneUserById(AuthModel $user)
    {
        return $this->db->getRecordById('users', $user->getId());
    }

    public function changeStatusUser(AuthModel $user)
    {
        $sql = "UPDATE users SET status = ? WHERE id = ?";
        return $this->db->update($sql, [$user->getStatus(), $user->getId()]);
    }

    // public function deleteUser(AuthModel $user)
    // {
    //     $sql = "DELETE FROM users WHERE id = ?";
    //     return $this->db->delete($sql, [$user->getId()]);
    // }

    public function deleteUser(AuthModel $user)
    {
        $this->db->beginTransaction(); // Bắt đầu transaction

        try {
            $userId = $user->getId();

            // 1. Xóa thông tin trong bảng `rateimages` dựa trên `rate_id` liên quan
            $sql = "DELETE FROM rateimages WHERE rate_id IN (SELECT id FROM rates WHERE user_id = ?)";
            $this->db->delete($sql, [$userId]);

            // 2. Xóa thông tin trong bảng `rates`
            $sql = "DELETE FROM rates WHERE user_id = ?";
            $this->db->delete($sql, [$userId]);

            // Các thao tác xóa khác như detailcarts, orders...
            $sql = "DELETE FROM detailcarts WHERE cart_id IN (SELECT id FROM carts WHERE user_id = ?)";
            $this->db->delete($sql, [$userId]);

            $sql = "DELETE FROM orderdetails WHERE order_id IN (SELECT id FROM orders WHERE user_id = ?)";
            $this->db->delete($sql, [$userId]);

            $sql = "DELETE FROM payment WHERE order_id IN (SELECT id FROM orders WHERE user_id = ?)";
            $this->db->delete($sql, [$userId]);

            $sql = "DELETE FROM carts WHERE user_id = ?";
            $this->db->delete($sql, [$userId]);

            $sql = "DELETE FROM orders WHERE user_id = ?";
            $this->db->delete($sql, [$userId]);

            // Cuối cùng, xóa người dùng trong bảng `users`
            $sql = "DELETE FROM users WHERE id = ?";
            $this->db->delete($sql, [$userId]);

            $this->db->commit(); // Hoàn tất transaction
            return true;
        } catch (Exception $e) {
            $this->db->rollBack(); // Quay lại trạng thái ban đầu nếu có lỗi
            return false;
        }
    }




    public function deleteStaff(AuthModel $user)
    {
        // Bước 1: Xóa các bản ghi liên quan trong bảng user_privileges
        $sql = "DELETE FROM user_privileges WHERE user_id = ?";
        $this->db->delete($sql, [$user->getId()]);

        // Bước 2: Xóa người dùng khỏi bảng users
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->delete($sql, [$user->getId()]);
    }


    // public function deleteStaff(AuthModel $user)
    // {
    //     // Bước 1: Xóa các bản ghi liên quan trong bảng user_privileges
    //     $sql = "DELETE FROM user_privileges WHERE user_id = ?";
    //     $this->db->delete($sql, [$user->getId()]);

    //     // Bước 2: Xóa người dùng khỏi bảng users
    //     $sql = "DELETE FROM users WHERE id = ?";
    //     return $this->db->delete($sql, [$user->getId()]);
    // }



    public function getOneUserByIdForOder(AuthModel $user)
    {
        $sql = "
            SELECT 
                u.*, 
                COUNT(CASE WHEN o.status = 0 THEN 1 ELSE NULL END) AS cOrders,
                COUNT(CASE WHEN o.status = 4 THEN 1 ELSE NULL END) AS sOrders
            FROM users u 
            LEFT JOIN orders o ON u.id = o.user_id
            WHERE u.id = :user_id
            GROUP BY u.id";

        return $this->db->getOne($sql, ['user_id' => $user->getId()]);
    }

    public function addStaff(AuthModel $user)
    {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 1)";
        return $this->db->insert($sql, [$user->getName(), $user->getEmail(), $user->getPassword()]);
    }
}
