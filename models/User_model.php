<?php
class User_model extends CI_Model {
    public function create_user($username, $password_hash) {
        return $this->db->insert('users', [
            'username' => $username,
            'password_hash' => $password_hash,
        ]);
    }

    public function get_user_by_username($username) {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    public function get_user($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_balance($user_id, $amount) {
        $this->db->set('balance', 'balance + ' . $amount, FALSE);
        $this->db->where('id', $user_id);
        return $this->db->update('users');
    }
}
?>