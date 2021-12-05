<?php

namespace App\AdminModule\Components\DimensionEditForm;

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
 * @package App\AdminModule\Components\DimensionEditForm
 *
 * @method onFinished(string $message = '')
 * @method onFailed(string $message = '')
 * @method onCancel()
 */
class DimensionEditForm extends Form
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

    /**
     * TagEditForm constructor.
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     * @param DimensionsFacade $dimensionsFacade
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function __construct(Nette\ComponentModel\IContainer $parent = null, string $name = null, DimensionsFacade $dimensionsFacade)
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
        $this->dimensionsFacade = $dimensionsFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $dimensionId = $this->addHidden('dimensionId');

        $this->addText('name', 'Název dimenze')
             ->setRequired('Musíte zadat název dimenze');

        $this->addTextArea('description', 'Popis dimenze')
             ->setRequired(false);

        // todo - jednotky, typy dimenze

//        $this->addSelect('type', 'Typ dimenze', [Dimension::TYPE_NUMBER => 'číslo', Dimension::TYPE_TEXT => 'text'])
//             ->setRequired(false);

        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');
            if (!empty($values['dimensionId'])) {
                try {
                    $dimension = $this->dimensionsFacade->getDimension($values['dimensionId']);
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaná dimenze nebyla nalezena.');
                    return;
                }
            } else {
                $dimension = new Dimension();
            }
            $dimension->assign($values, ['name', 'description']);
            $this->dimensionsFacade->saveDimension($dimension);
            $this->setValues(['dimensionId' => $dimension->dimensionId]);
            $this->onFinished('Dimenze byla uložena.');
        };

        $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([$dimensionId])
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
        if ($values instanceof Dimension) {
            $values = [
                'dimensionId'   => $values->dimensionId,
                'name'          => $values->name,
                'description'   => $values->description
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }

}