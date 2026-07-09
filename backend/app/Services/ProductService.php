<?php

namespace App\Services;

use App\Logging\ActivityLogger;
use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use App\Repositories\ProductRepository;
use App\Models\Product;
use App\Support\CodeGenerator;

class ProductService extends BaseService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ActivityLogger $logger,
    ) {}

    protected function auditModule(): string
    {
        return 'PRODUCTS';
    }

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

    public function create(array $data): BaseModel
    {
        $data['code'] = CodeGenerator::generate(Product::class, 'PROD');

        return parent::create($data);
    }

    protected function notFoundMessage(): string
    {
        return 'Product not found.';
    }

    public function allForExport()
    {
        return $this->repository()->allForExport();
    }
}
