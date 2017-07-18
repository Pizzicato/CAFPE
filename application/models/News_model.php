<?php
    /**
     *
     */
     class News_model extends MY_Model
     {
        public $table = 'news';
        public $primary_key = 'id';

        public function __construct()
        {
            parent::__construct();
        }
     }
