<?php

namespace App\Repositories\Interfaces;

interface ImageRepositoryInterface
{

    public function store(array $imageData);
    public function getByUserId($user_id);
    public function deleteByUserId($user_id);
}
