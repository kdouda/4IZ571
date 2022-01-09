<?php

namespace App\AdminModule\Components\UserEditForm;

use App\Model\Entities\Dimension;
use App\Model\Entities\File;
use App\Model\Entities\Product;
use App\Model\Entities\ProductDimension;
use App\Model\Entities\User;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\DimensionsFacade;
use App\Model\Facades\FilesFacade;
use App\Model\Facades\ProductDimensionsFacade;
use App\Model\Facades\ProductsFacade;
use App\Model\Facades\UsersFacade;
use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs4FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

/**
 * Class ProductEditForm
 * @package App\AdminModule\Components\ProductEditForm
 *
 * @method onFinished(string $message = '')
 * @method onFailed(string $message = '')
 * @method onCancel()
 */
class UserEditForm extends Form
{

    use SmartObject;

    /** @var callable[] $onFinished */
    public $onFinished = [];
    /** @var callable[] $onFailed */
    public $onFailed = [];
    /** @var callable[] $onCancel */
    public $onCancel = [];
    /** @var UsersFacade */
    private $usersFacade;

    /**
     * TagEditForm constructor.
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     * @param ProductsFacade $productsFacade
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function __construct(
        Nette\ComponentModel\IContainer $parent = null,
        string $name = null,
        UsersFacade $usersFacade
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
        $this->usersFacade = $usersFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $userId = $this->addHidden('userId');

        $this->addText('name', 'Jméno')
            ->setRequired('Uživatel musí mít jméno')
            ->setMaxLength(40);

        $this->addEmail('email', 'E-mail')
            ->setRequired('Zadejte e-mail.');

        $roles = $this->usersFacade->findRoles();
        $rolesKv = [];

        foreach ($roles as $role) {
            $rolesKv[$role->roleId] = $role->roleId;
        }

        $this->addSelect('roleId', 'Role', $rolesKv);

        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');

            if (!empty($values['userId'])) {
                try {
                    $user = $this->usersFacade->getUser($values['userId']);
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaný uživatel nebyl nalezen.');
                    return;
                }
            } else {
                $this->onFailed('Nelze odsud vytvořit nového uživatele.');
                return;
            }

            $user->assign($values, ['name', 'email']);

            $this->usersFacade->saveUser($user);

            $this->onFinished('Uživatel byl uložen.');
        };
        $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([$userId])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }

    /**
     * Metoda pro nastavení výchozích hodnot formuláře
     * @param Product|array|object $values
     * @param bool $erase = false
     * @return $this
     */
    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof User) {
            $values = [
                'userId'  => $values->userId,
                'name'    => $values->name,
                'email'   => $values->email,
                'roleId'  => $values->role->roleId
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }
}