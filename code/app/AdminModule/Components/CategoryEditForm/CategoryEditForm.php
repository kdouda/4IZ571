<?php

namespace App\AdminModule\Components\CategoryEditForm;

use App\Model\Entities\Category;
use App\Model\Entities\Dimension;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\DimensionsFacade;
use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs4FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

/**
 * Class CategoryEditForm
 * @package App\AdminModule\Components\CategoryEditForm
 *
 * @method onFinished(string $message = '')
 * @method onFailed(string $message = '')
 * @method onCancel()
 */
class CategoryEditForm extends Form
{

    use SmartObject;

    /** @var callable[] $onFinished */
    public $onFinished = [];
    /** @var callable[] $onFailed */
    public $onFailed = [];
    /** @var callable[] $onCancel */
    public $onCancel = [];
    /** @var CategoriesFacade $categoriesFacade */
    private $categoriesFacade;
    /** @var DimensionsFacade $dimensionsFacade */
    private $dimensionsFacade;

    /**
     * TagEditForm constructor.
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     * @param CategoriesFacade $categoriesFacade
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function __construct(
        Nette\ComponentModel\IContainer $parent = null,
        string                          $name = null,
        CategoriesFacade                $categoriesFacade,
        DimensionsFacade                $dimensionsFacade
    )
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
        $this->categoriesFacade = $categoriesFacade;
        $this->dimensionsFacade = $dimensionsFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $categoryId = $this->addHidden('categoryId');

        $this->addText('title', 'Název kategorie')
            ->setRequired('Musíte zadat název kategorie');

        $this->addTextArea('description', 'Popis kategorie')
            ->setRequired(false);


        $this->addMultiSelect('dimensions', 'Dimenze', $this->getDimensionsForSelect())
            ->setRequired(false);

        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');
            if (!empty($values['categoryId'])) {
                try {
                    $category = $this->categoriesFacade->getCategory($values['categoryId']);
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaná kategorie nebyla nalezena.');
                    return;
                }
            } else {
                $category = new Category();
            }

            $dimensions = [];

            foreach ($values["dimensions"] as $dimensionId) {
                $dimensions[] = $this->dimensionsFacade->getDimension($dimensionId);
            }

            $category->assign($values, ['title', 'description']);
            $this->categoriesFacade->saveCategory($category);

            $category->replaceAllDimensions($dimensions);
            $this->categoriesFacade->saveCategory($category);

            $this->setValues(['categoryId' => $category->categoryId]);
            $this->onFinished('Kategorie byla uložena.');
        };
        $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([$categoryId])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }

    private function getDimensionsForSelect(): array
    {
        $dimensions = $this->dimensionsFacade->findDimensions();
        $kv = [];

        foreach ($dimensions as $dimension) {
            $kv[$dimension->dimensionId] = $dimension->name;
        }

        return $kv;
    }

    /**
     * Metoda pro nastavení výchozích hodnot formuláře
     * @param Category|array|object $values
     * @param bool $erase = false
     * @return $this
     */
    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Category) {
            $dimensions = [];
            foreach ($values->dimensions as $dimension) {
                $dimensions[] = $dimension->dimensionId;
            }

            $values = [
                'categoryId' => $values->categoryId,
                'title' => $values->title,
                'description' => $values->description,
                'dimensions' => $dimensions
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }

}