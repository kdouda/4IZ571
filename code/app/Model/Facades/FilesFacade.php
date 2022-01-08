<?php

namespace App\Model\Facades;

use App\Model\Entities\Category;
use App\Model\Entities\File;
use App\Model\Repositories\CategoryRepository;
use App\Model\Repositories\FileRepository;

/**
 * Class CategoriesFacade - fasáda pro využívání kategorií z presenterů
 * @package App\Model\Facades
 */
class FilesFacade{
  /** @var FileRepository $fileRepository */
  private $fileRepository;

  public function __construct(FileRepository $categoryRepository){
    $this->fileRepository=$categoryRepository;
  }

  /**
   * Metoda pro načtení jedné kategorie
   * @param int $id
   * @return File
   * @throws \Exception
   */
  public function getFile(int $id):File {
    return $this->fileRepository->find($id); //buď počítáme s možností vyhození výjimky, nebo ji ošetříme už tady a můžeme vracet např. null
  }

  /**
   * Metoda pro uložení kategorie
   * @param File &$file
   * @return bool - true, pokud byly v DB provedeny nějaké změny
   */
  public function saveFile(File &$file):bool {
    return (bool)$this->fileRepository->persist($file);
  }

  /**
   * Metoda pro smazání kategorie
   * @param File $file
   * @return bool
   */
  public function deleteFile(File $file):bool {
    try{
      return (bool)$this->fileRepository->delete($file);
    }catch (\Exception $e){
      return false;
    }
  }

}