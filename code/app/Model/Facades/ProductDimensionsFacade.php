<?php

namespace App\Model\Facades;

use App\Model\Entities\Category;
use App\Model\Entities\Dimension;
use App\Model\Entities\ProductDimension;
use App\Model\Repositories\CategoryRepository;
use App\Model\Repositories\DimensionRepository;
use App\Model\Repositories\ProductDimensionRepository;

/**
 * Class DimensionsFacade - fasáda pro využívání dimenzí z presenterů
 * @package App\Model\Facades
 */
class ProductDimensionsFacade
{
    /** @var ProductDimensionRepository $productDimensionRepository */
    private $productDimensionRepository;

    public function __construct(ProductDimensionRepository $categoryRepository)
    {
        $this->productDimensionRepository = $categoryRepository;
    }

    /**
     * Metoda pro načtení jedné dimenze
     * @param int $id
     * @return ProductDimension
     * @throws \Exception
     */
    public function getProductDimension(int $id): ProductDimension
    {
        return $this->productDimensionRepository->find($id);
    }

    /**
     * Metoda pro vyhledání dimenzí
     * @param array|null $params = null
     * @param int $offset = null
     * @param int $limit = null
     * @return ProductDimension[]
     */
    public function findProductDimensions(array $params = null, int $offset = null, int $limit = null): array
    {
        return $this->productDimensionRepository->findAllBy($params, $offset, $limit);
    }

    /**
     * Metoda pro zjištění počtu dimenzí
     * @param array|null $params
     * @return int
     */
    public function findProductDimensionsCount(array $params = null): int
    {
        return $this->productDimensionRepository->findCountBy($params);
    }

    /**
     * Metoda pro uložení dimenze
     * @param ProductDimension &$dimension
     * @return bool - true, pokud byly v DB provedeny nějaké změny
     */
    public function saveProductDimension(ProductDimension &$dimension): bool
    {
        return (bool)$this->productDimensionRepository->persist($dimension);
    }

    /**
     * Metoda pro smazání dimenze
     * @param ProductDimension $dimension
     * @return bool
     */
    public function deleteProductDimension(ProductDimension $dimension): bool
    {
        try {
            return (bool)$this->productDimensionRepository->delete($dimension);
        } catch (\Exception $e) {
            return false;
        }
    }

}