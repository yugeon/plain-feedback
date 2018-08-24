<?php

namespace App\Controllers;

use App\Library\BaseController;
use App\Models\Feedback;

class IndexController extends BaseController
{
    public function index()
    {
        $feedbackModel = new Feedback();
        $feedbacks = $feedbackModel->getAll();
        return $this->view('layouts/index', $feedbacks);
    }

    public function feedback()
    {
        $errors = [];
        $data = [];

        // validate feedback
        if (!empty($this->request->post['name'])) {
            $data['name'] = trim($this->request->post['name']);
            if (mb_strlen($data['name']) < 2) {
                $errors['name'][] = 'Name too small';
            }
            if (mb_strlen($data['name']) >= 255) {
                $errors['name'][] = 'Name too long';
            }
            if (!preg_match('/^[a-zA-Z0-9\-_]{2,50}$/i', $data['name'])) {
                $errors['name'][] = 'Name must contain only letters, digits and -, _ chars';
            }
        } else {
            $errors['name'][] = 'Name is required';
        }

        $data['email'] = isset($this->request->post['email']) ? trim($this->request->post['email']) : '';
        if ($data['email'] && false === filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'Incorrect email';
        }

        $data['text'] = isset($this->request->post['text']) ? trim($this->request->post['text']) : '';
        if (empty($data['text'])) {
            $errors['text'][] = 'Text is required';
        }

        if (empty($this->request->post['accept']) || !$this->request->post['accept']) {
            $errors['accept'][] = 'Your must accept feedback reglament';
        }

        if (empty($errors)) {
            // add feedback to db
            $feedbackModel = new Feedback();
            try {
                $feedbackModel->save($data);
            } catch (\Exception $e) {
                $errors['errorMsg'] = $e->getMessage();
            }
        }

        $data['date'] = date('c');
        $feedbackHtml = $this->view('feedback', ['feedback' => $data]);
        $result = [
            'status' => true,
            'innerHtml' => $feedbackHtml
        ];

        return json_encode(count($errors) > 0 ? $errors : $result);
    }
}
