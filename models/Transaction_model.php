<?php
class Transaction_model extends CI_Model {
    public function deposit($user_id, $amount) {
        $this->db->insert('transactions', [
            'receiver_id' => $user_id,
            'type' => 'deposit',
            'amount' => $amount
        ]);
        $this->User_model->update_balance($user_id, $amount);
    }

    public function transfer($sender_id, $receiver_id, $amount) {
        $sender = $this->User_model->get_user($sender_id);
        if ($sender->balance >= $amount) {
            $this->db->insert('transactions', [
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'type' => 'transfer',
                'amount' => $amount
            ]);
            $this->User_model->update_balance($sender_id, -$amount);
            $this->User_model->update_balance($receiver_id, $amount);
        }
    }

    public function reverse_transaction($transaction_id) {
        $txn = $this->db->get_where('transactions', ['id' => $transaction_id])->row();
        if ($txn && $txn->status !== 'reversed') {
            if ($txn->type === 'deposit') {
                $this->User_model->update_balance($txn->receiver_id, -$txn->amount);
            } else if ($txn->type === 'transfer') {
                $this->User_model->update_balance($txn->receiver_id, -$txn->amount);
                $this->User_model->update_balance($txn->sender_id, $txn->amount);
            }
            $this->db->where('id', $transaction_id);
            $this->db->update('transactions', ['status' => 'reversed']);
        }
    }

    public function get_user_transactions($user_id) {
        $this->db->where('sender_id', $user_id);
        $this->db->or_where('receiver_id', $user_id);
        return $this->db->get('transactions')->result();
    }
}