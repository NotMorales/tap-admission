<?php

namespace App\Services;

use App\Logging\ActivityLogger;
use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use App\Repositories\ProductRepository;

class ProductService extends BaseService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ActivityLogger $logger,
    ) {}

    protected function repository(): BaseRepository
    {
        return $this->productRepository;
    }

    protected function afterCreate(BaseModel $model): void
    {
        $this->logger->info('PRODUCTS', 'CREATE', ['id' => (string) $model->_id]);
    }

    protected function afterUpdate(BaseModel $model): void
    {
        $this->logger->info('PRODUCTS', 'UPDATE', ['id' => (string) $model->_id]);
    }

    protected function afterDelete(BaseModel $model): void
    {
        $this->logger->info('PRODUCTS', 'DELETE', ['id' => (string) $model->_id]);
    }

    protected function notFoundMessage(): string
    {
        return 'Product not found.';
    }
}
