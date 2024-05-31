<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'username';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'fullname', 'email', 'whatsapp', 'status', 'password', 'photo', 'user_role'];

    public function get_data($username)
    {
        $builder = $this->db->table('user')
            ->where(['username' => $username])
            ->get();

        return $builder->getRowArray();
    }
}
