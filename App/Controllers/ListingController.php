<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;


class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require_once basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {

        $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

        loadView('listings/index', ['listings' => $listings]);
    }


    public function create()
    {

        loadView('listings/create');
    }

    public function show($params)
    {

        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ]; // Why did my teacher used this if $params is already ['id' => $id];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch(); // where are we saying: use this id for the :id? I don't see it.


        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }



        loadView('listings/show', ['listing' => $listing]);
    }



    public function store()
    {
        $allowedFields = [
            'title',
            'descriptions',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        $newListingData = array_map('sanitize', $newListingData);
        $newListingData['user_id'] = 1;
        $requiredFields = ['title', 'descriptions', 'email', 'city', 'state'];

        $errors = [];
        foreach ($requiredFields as $field) {

            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required!';
            }
        }
        if (!empty($errors)) {

            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            $fields = [];
            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
            }
            $fields = implode(', ', $fields);

            $values = [];
            foreach ($newListingData as $field => $value) {
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);
            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
            $this->db->query($query, $newListingData);
            redirect('/listings'); // get
        }
    }



    public function destroy($params)
    {
        $id = $params['id'];

        $params = ['id' => $id];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

        if (!$listing) {
            ErrorController::notFound("Listing not found");
            return;
        }

        $_SESSION['success_message'] = 'Listing deleted successfully';
        $this->db->query("DELETE FROM listings WHERE id = :id", $params);
        redirect('/listings');
    }


    public function edit($params)
    {

        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();


        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/edit', ['listing' => $listing]);
    }



    public function update($params)
    {

        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();


        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }
        $allowedFields = [
            'title',
            'descriptions',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $updateValues = [];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['title', 'descriptions', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {


            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {

                $errors[$field] = ucfirst($field) . " is required";
            }
        }

        if (!empty($errors)) {

            loadView('listings/edit', ['errors' => $errors, 'listing' => $listing]);
            exit;
        } else {
            $updateFields = [];
            foreach (array_keys($updateValues) as $field) {

                $updateFields[] = "{$field} = :{$field}"; // [0] => 'title = :title' [1] => 'descriptions = :descriptions' etc.
            }

            $updateFields = implode(', ', $updateFields); // string(230) "title = :title, descriptions = :descriptions, ...

            $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";

            $updateValues['id'] = $id;

            $this->db->query($updateQuery, $updateValues);

            $_SESSION['success_message'] = 'Listing updated';
            redirect('/listings/' . $id);
        }
    }
}
