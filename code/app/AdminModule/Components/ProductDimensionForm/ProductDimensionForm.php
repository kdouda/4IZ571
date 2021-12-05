<?php

namespace App\AdminModule\Components\ProductDimensionForm;

use App\Model\Entities\Category;
use App\Model\Entities\Dimension;
use App\Model\Entities\Product;
use App\Model\Entities\ProductDimension;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\DimensionsFacade;
use App\Model\Facades\ProductDimensionsFacade;
use App\Model\Facades\ProductsFacade;
use Dibi\UniqueConstraintViolationException;
use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs4FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

/**
 * Class CategoryEditForm
 * @package App\AdminModule\Components\DimensionEditForm
 *
 * @method onFinished(string $message = '')
 * @method onFailed(string $message = '')
 * @method onCancel()
 */
class ProductDimensionForm extends Form
{
    use SmartObject;

    /** @var callable[] $onFinished */
    public $onFinished = [];

    /** @var callable[] $onFailed */
    public $onFailed = [];

    /** @var callable[] $onCancel */
    public $onCancel = [];

    /** @var DimensionsFacade $dimensionsFacade */
    private $dimensionsFacade;

    /** @var ProductsFacade $dimensionsFacade */
    private $productsFacade;

    /** @var ProductDimensionsFacade $productDimensionsFacade */
    private $productDimensionsFacade;

    /**
     * TagEditForm constructor.
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     * @param DimensionsFacade $dimensionsFacade
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function __construct(
        Nette\ComponentModel\IContainer $parent = null,
        string $name = null,
        DimensionsFacade $dimensionsFacade,
        ProductsFacade $productsFacade,
        ProductDimensionsFacade $productDimensionsFacade
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
        $this->dimensionsFacade = $dimensionsFacade;
        $this->productsFacade = $productsFacade;
        $this->productDimensionsFacade = $productDimensionsFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $productDimensionId = $this->addHidden('productDimensionId');
        $productId = $this->addHidden('productId');

        $dimensions = $this->dimensionsFacade->findDimensions();

        $availableDimensions = [];

        // todo - zobrazit jen ty dimenze, které produkt ještě nemá

        foreach ($dimensions as $dimension) {
            $availableDimensions[$dimension->dimensionId] = $dimension->name;
        }

        $this->addSelect('dimensionId', 'Dimenze', $availableDimensions)
             ->setRequired('Musíte zadat dimenzi');

        $this->addText('value', 'Hodnota dimenze')
             ->setRequired('Musíte zadat hodnotu dimenze');

        $this->addTextArea('description', 'Popis dimenze')
             ->setRequired(false);

        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');

            if (!empty($values['productDimensionId'])) {
                try {
                    $productDimension = $this->productDimensionsFacade->getProductDimension($values['productDimensionId']);
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaná produktová dimenze nebyla nalezena.');
                    return;
                }
            } else {
                $productDimension = new ProductDimension();
            }

            $productDimension->assign($values, ['value', 'description']);

            try {
                $dimension = $this->dimensionsFacade->getDimension($values["dimensionId"]);
                $productDimension->dimension = $dimension;
            }  catch (\Exception $e) {
                $this->onFailed('Požadovaná dimenze nebyla nalezena.');
                return;
            }

            try {
                $product = $this->productsFacade->getProduct($values["productId"]);
                $productDimension->product = $product;
            }  catch (\Exception $e) {
                $this->onFailed('Požadovaný produkt nebyl nalezen.');
                return;
            }

            try {
                $this->productDimensionsFacade->saveProductDimension($productDimension);
            } catch (UniqueConstraintViolationException $ex) {
                $this->onFailed('Zadaná kombinace pro produkt již existuje!');
                return;
            }

            $this->setValues(['productDimensionId' => $productDimension->productDimensionId]);
            $this->onFinished('Dimenze produktu byla přidána.');
        };

        $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([$productDimensionId])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }

    /**
     * Metoda pro nastavení výchozích hodnot formuláře
     * @param Category|array|object $values
     * @param bool $erase = false
     * @return $this
     */
    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof ProductDimension) {
            $values = [
                'productDimensionId' => $values->productDimensionId,
                'productId'          => $values->product->productId,
                'dimensionId'        => $values->dimension->dimensionId,
                'description'        => $values->description,
                'value'              => $values->value
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }

}