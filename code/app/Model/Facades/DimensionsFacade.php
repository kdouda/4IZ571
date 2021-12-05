<?php

namespace App\Model\Facades;

use App\Model\Entities\Category;
use App\Model\Entities\Dimension;
use App\Model\Repositories\CategoryRepository;
use App\Model\Repositories\DimensionRepository;

/**
 * Class DimensionsFacade - fasáda pro využívání dimenzí z presenterů
 * @package App\Model\Facades
 */
class DimensionsFacade
{
    /** @var DimensionRepository $dimensionRepository */
    private $dimensionRepository;

    public function __construct(DimensionRepository $categoryRepository)
    {
        $this->dimensionRepository = $categoryRepository;
    }

    /**
     * Metoda pro načtení jedné dimenze
     * @param int $id
     * @return Dimension
     * @throws \Exception
     */
    public function getDimension(int $id): Dimension
    {
        return $this->dimensionRepository->find($id); //buď počítáme s možností vyhození výjimky, nebo ji ošetříme už tady a můžeme vracet např. null
    }

    /**
     * Metoda pro vyhledání dimenzí
     * @param array|null $params = null
     * @param int $offset = null
     * @param int $limit = null
     * @return Dimension[]
     */
    public function findDimensions(array $params = null, int $offset = null, int $limit = null): array
    {
        return $this->dimensionRepository->findAllBy($params, $offset, $limit);
    }

    /**
     * Metoda pro zjištění počtu dimenzí
     * @param array|null $params
     * @return int
     */
    public function findDimensionsCount(array $params = null): int
    {
        return $this->dimensionRepository->findCountBy($params);
    }

    /**
     * Metoda pro uložení dimenze
     * @param Dimension &$dimension
     * @return bool - true, pokud byly v DB provedeny nějaké změny
     */
    public function saveDimension(Dimension &$dimension): bool
    {
        return (bool)$this->dimensionRepository->persist($dimension);
    }

    /**
     * Metoda pro smazání dimenze
     * @param Dimension $dimension
     * @return bool
     */
    public function deleteDimension(Dimension $dimension): bool
    {
        try {
            return (bool)$this->dimensionRepository->delete($dimension);
        } catch (\Exception $e) {
            return false;
        }
    }

}