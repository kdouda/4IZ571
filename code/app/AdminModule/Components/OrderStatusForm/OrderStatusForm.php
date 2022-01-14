<?php

namespace App\AdminModule\Components\OrderStatusForm;

use App\AdminModule\Components\ProductDimensionForm\ProductDimensionForm;
use App\Model\Entities\Category;
use App\Model\Entities\Order;
use App\Model\Entities\ProductDimension;
use App\Model\Facades\DimensionsFacade;
use App\Model\Facades\OrderFacade;
use App\Model\Facades\ProductDimensionsFacade;
use App\Model\Facades\ProductsFacade;
use Dibi\UniqueConstraintViolationException;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs4FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

class OrderStatusForm extends Form
{
    use SmartObject;

    /** @var callable[] $onFinished */
    public $onFinished = [];

    /** @var callable[] $onFailed */
    public $onFailed = [];

    /** @var callable[] $onCancel */
    public $onCancel = [];

    /** @var OrderFacade $orderFacade */
    private $orderFacade;

    /**
     * TagEditForm constructor.
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     * @param OrderFacade $orderFacade
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function __construct(
        Nette\ComponentModel\IContainer $parent = null,
        string                          $name = null,
        OrderFacade                     $orderFacade
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
        $this->orderFacade = $orderFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $orderId = $this->addHidden('orderId');

        $this->addSelect('state', 'Stav objednávky', Order::getStates());

        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');

            if (!empty($values['orderId'])) {
                try {
                    $order = $this->orderFacade->getOrderById($values['orderId']);
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaná objednávka nebyla nalezena.');
                    return;
                }
            } else {
                $this->onFailed('Požadovaná objednávka nebyla nalezena.');
                return;
            }

            $order->assign($values, ['state']);

            $this->orderFacade->saveOrder($order);

            $this->onFinished('Stav objednávky byl změněn.');
        };

        $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([$orderId])
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
        if ($values instanceof Order) {
            $values = [
                'orderId' => $values->orderId,
                'state'   => $values->state
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }
}