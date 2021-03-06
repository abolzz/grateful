<?php
  class Purchase {
    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    public function addPurchase($data) {
      // Prepare Query
      $this->db->query('INSERT INTO purchases (buyer_email, buyer_first_name, buyer_last_name, user_id, bought_listing, bought_quantity, purchase_key, status, customer_id, price) VALUES(:buyer, :first_name, :last_name, :bought_from, :bought_listing, :bought_quantity, :purchase_key, :status, :customer_id, :price)');

      // Bind Values
      $this->db->bind(':buyer', $data['buyer']);
      $this->db->bind(':first_name', $data['first_name']);
      $this->db->bind(':last_name', $data['last_name']);
      $this->db->bind(':bought_from', $data['bought_from']);
      $this->db->bind(':bought_listing', $data['bought_listing']);
      $this->db->bind(':bought_quantity', $data['bought_quantity']);
      $this->db->bind(':purchase_key', $data['purchase_key']);
      $this->db->bind(':status', $data['status']);
      $this->db->bind(':customer_id', $data['customer_id']);
      $this->db->bind(':price', $data['price']);

      // Execute
      $this->db->execute();

    }

    public function updateListing($data) {
      // Prepare Query
      $this->db->query('UPDATE listings SET quantity = (quantity - :bought_quantity) WHERE id = :bought_listing_id; UPDATE listings SET purchases = (purchases + 1) WHERE id = :bought_listing_id');

      // Bind Values
      $this->db->bind(':bought_listing_id', $data['bought_listing_id']);
      $this->db->bind(':bought_quantity', $data['bought_quantity']);

      // Execute
      $this->db->execute();
      
    }

    public function getPurchases($id) {
      $this->db->query('SELECT * FROM purchases WHERE lister_name = $id ORDER BY purchase_time DESC');

      $results = $this->db->resultset();

      return $results;
    }
  }