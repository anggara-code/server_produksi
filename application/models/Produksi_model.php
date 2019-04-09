<?php 

class Produksi_model extends CI_model {

    public function getProduksi($id_produksi = null)
    {
        if($id_produksi === null) {
            // mengembalikan nilai array assocciative
            return $this->db->get('produksi')->result_array();
        } else {
            return $this->db->get_where('produksi', ['id_produksi' => $id_produksi])->result_array();
        }
    }

    public function deleteProduksi($id_produksi = null)
    {
        $this->db->delete('produksi', ['id_produksi' => $id_produksi]);
        return $this->db->affected_rows();
    }

    public function createProduksi($data)
    {
        $this->db->insert('produksi', $data);
        return $this->db->affected_rows();
    }

    public function updateProduksi($data, $id_produksi)
    {
        $this->db->update('produksi', $data, ['id_produksi' => $id_produksi]);
        return $this->db->affected_rows();
    }
}

?>