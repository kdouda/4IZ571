<?php

namespace App\FrontModule\Components\OrderForm;

use App\Model\Entities\Address;
use App\Model\Entities\Category;
use App\Model\Entities\Order;
use App\Model\Entities\OrderItem;
use App\Model\Entities\User;
use App\Model\Facades\AddressFacade;
use App\Model\Facades\CartFacade;
use App\Model\Facades\OrderFacade;
use App\Model\Facades\UsersFacade;
use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nette\Utils\Html;
use Nextras\FormsRendering\Renderers\Bs4FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

/**
 * Class UserRegistrationForm
 * @package App\FrontModule\Components\UserRegistrationForm
 *
 * @method onFinished()
 * @method onCancel()
 */
class OrderForm extends Form
{

    use SmartObject;

    /** @var callable[] $onFinished */
    public $onFinished = [];
    /** @var callable[] $onCancel */
    public $onCancel = [];

    /** @var Nette\Security\User */
    private $user;

    /** @var OrderFacade */
    private $orderFacade;

    /** @var AddressFacade */
    private $addressFacade;

    /** @var CartFacade */
    private $cartFacade;

    /** @var UsersFacade  */
    private $usersFacade;

    /**
     * UserRegistrationForm constructor.
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     * @param UsersFacade $usersFacade
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function __construct(
        Nette\ComponentModel\IContainer $parent = null,
        string                          $name = null,
        Nette\Security\User             $user,
        OrderFacade                     $orderFacade,
        AddressFacade                   $addressFacade,
        CartFacade                      $cartFacade,
        UsersFacade                     $usersFacade
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::INLINE));
//        $this->getRenderer()->wrappers['pair']['container'] = 'div class=" mb-2 mr-sm-2 justify-content-center"';
        $this->user = $user;
        $this->orderFacade = $orderFacade;
        $this->addressFacade = $addressFacade;
        $this->cartFacade = $cartFacade;
        $this->usersFacade = $usersFacade;
        $this->createSubcomponents();
    }

    private function addAddressControls(
        string $prefix,
        string $caption,
        array $addresses,
        ?Nette\Forms\Controls\Checkbox $checkbox = null
    ) {
        $group = $this->addGroup($caption)
        ->setOption('container', Html::el('div class="form-block-2 col-6 flex-column align-self-start"'));

        $selectControl = $this->addSelect('address_' . $prefix . '_saved', 'Uložená adresa', $addresses)
                              ->setDefaultValue('');

        $group->add($selectControl);
        $this->getRenderer()->wrappers['label']['container'] ='div class="col-sm-3 col-form-label "';

        $fields = [];

        $fields[] = $this->addText($prefix . '_name', 'Jméno');

        $fields[] = $this->addText($prefix . '_street', 'Ulice a číslo popisné');

        $fields[] = $this->addText($prefix . '_city', 'Město');

        $fields[] = $this->addText($prefix . '_zip', 'PSČ');

        $fields[] = $this->addText($prefix . '_country', 'Země');

        foreach ($fields as $field) {
            if ($checkbox) {
                $field->addConditionOn($checkbox, Form::FILLED, true)
                      ->setRequired(false)
                      ->elseCondition()
                      ->addConditionOn($selectControl, Form::BLANK, true)
                      ->setRequired('Musíte vyplnit adresu pokud nemáte vybranou uloženou!');
            } else {
                $field->addConditionOn($selectControl, Form::BLANK, true)
                    ->setRequired('Musíte vyplnit adresu pokud nemáte vybranou uloženou!');
            }

            $group->add($field);
        }
    }

    private function createSubcomponents()
    {
        //$this->onValidate[] = [$this, "validateAddresses"];

        /** @var Address[] $addressSaved */
        $addressSaved = $this->addressFacade->getAddressByUser($this->user);

        $addresses = ["" => "Vyberte adresu nebo zadejte novou"];

        foreach ($addressSaved as $address) {
            $addresses[$address->addressId] = (string)$address;
        }

        $this->addAddressControls('delivery', 'Dodací adresa', $addresses);

        $checkSame = $this->addCheckbox('address_is_same', 'Fakturační adresa stejná jak dodací')
             ->setDefaultValue(false);

        $this->addAddressControls('billing', 'Fakturační adresa', $addresses, $checkSame);

        $buttonGroup = $this->addGroup();
        $buttonGroup->setOption('container', Html::el('div class="form-block-2 col-12 flex-column"'));
        $buttonGroup = $checkSame;
        $buttonGroup =  $this->addSubmit('submit', 'Potvrdit objednávku')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');

            $user = $this->usersFacade->getUser($this->user->getId());

            $addressBilling = null;
            $addressDelivery = null;

            if ($values["address_delivery_saved"]) {
                $addressDelivery = $this->addressFacade->getAddressById($values["address_delivery_saved"]);
            } else {
                $addressDelivery = new Address();
                $addressDelivery->assign(
                    [
                        "name"      => $values["delivery_name"],
                        "street"    => $values["delivery_street"],
                        "city"      => $values["delivery_city"],
                        "zip"       => $values["delivery_zip"],
                        "country"   => $values["delivery_country"],
                        "user"      => $user
                    ]
                );

                $this->addressFacade->saveAddress($addressDelivery);
            }

            if ($values["address_is_same"]) {
                $addressBilling = $addressDelivery;
            } else {
                if ($values["address_billing_saved"]) {
                    $addressBilling = $this->addressFacade->getAddressById($values["address_billing_saved"]);
                } else {
                    $addressBilling = new Address();

                    $addressBilling->assign(
                        [
                            "name"      => $values["billing_name"],
                            "street"    => $values["billing_street"],
                            "city"      => $values["billing_city"],
                            "zip"       => $values["billing_zip"],
                            "country"   => $values["billing_country"],
                            "user"      => $user
                        ]
                    );

                    $this->addressFacade->saveAddress($addressBilling);
                }
            }

            $order = new Order();
            $order->billingAddress = $addressBilling;
            $order->deliveryAddress = $addressDelivery;
            $order->createDate = new \DateTime();
            $order->lastModified = new \DateTime();
            $order->state = Order::STATE_NEW;
            $order->user = $user;

            $this->orderFacade->saveOrder($order);

            $cart = $this->cartFacade->getCartByUser($user);

            foreach ($cart->items as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order = $order;
                $orderItem->product = $cartItem->product;
                $orderItem->amount = $cartItem->count;
                $orderItem->unitPrice = $cartItem->product->price;
                $this->orderFacade->saveOrderItem($orderItem);
            }

            $this->cartFacade->deleteCartByUser($user);

            // send notification to owner, etc

            $this->onFinished();
        };

        $buttonGroup =  $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }

}