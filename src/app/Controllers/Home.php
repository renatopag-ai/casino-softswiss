<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class Home extends BaseController {
    public function index() {
        $cache = \Config\Services::cache();
        $key = "tes";
        // Try to retrieve data from the cache
        $data = $cache->get($key);
        // If the data is not in the cache, generate it and store it in the cache for next time
        if (!$data) {
            // Generate some sample data to cache
            $data = [
                'name' => 'John silva',
                'email' => 'john@gato.net',
                'phone' => '4444-1111'
            ];
            // Store the data in the cache for 1 hour
            $cache->save($key, $data, 90);
        }
        // Output the cached data
        print_r($data);
    }
}
