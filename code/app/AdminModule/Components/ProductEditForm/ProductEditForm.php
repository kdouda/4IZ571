<?php

namespace App\AdminModule\Components\ProductEditForm;

use App\Model\Entities\Dimension;
use App\Model\Entities\File;
use App\Model\Entities\Product;
use App\Model\Entities\ProductDimension;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\DimensionsFacade;
use App\Model\Facades\FilesFacade;
use App\Model\Facades\ProductDimensionsFacade;
use App\Model\Facades\ProductsFacade;
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
class ProductEditForm extends Form
{

    use SmartObject;

    /** @var callable[] $onFinished */
    public $onFinished = [];
    /** @var callable[] $onFailed */
    public $onFailed = [];
    /** @var callable[] $onCancel */
    public $onCancel = [];
    /** @var CategoriesFacade */
    private $categoriesFacade;
    /** @var ProductsFacade $productsFacade */
    private $productsFacade;
    /** @var ProductDimensionsFacade  */
    private $productDimensionsFacade;
    /** @var DimensionsFacade  */
    private $dimensionsFacade;
    /** @var FilesFacade */
    private $filesFacade;

    /** @var null|Product */
    private $editingProduct = null;

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
        CategoriesFacade $categoriesFacade,
        ProductsFacade $productsFacade,
        ProductDimensionsFacade $productDimensionsFacade,
        DimensionsFacade $dimensionsFacade,
        FilesFacade $filesFacade,
        ?Product $product = null
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
        $this->categoriesFacade = $categoriesFacade;
        $this->productsFacade = $productsFacade;
        $this->productDimensionsFacade = $productDimensionsFacade;
        $this->dimensionsFacade = $dimensionsFacade;
        $this->editingProduct = $product;
        $this->filesFacade = $filesFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $productId = $this->addHidden('productId');
        $this->addText('title', 'Název produktu')
            ->setRequired('Musíte zadat název produktu')
            ->setMaxLength(100);

        $this->addText('url', 'URL produktu')
            ->setMaxLength(100)
            ->addFilter(function (string $url) {
                return Nette\Utils\Strings::webalize($url);
            })
            ->addRule(function (Nette\Forms\Controls\TextInput $input) use ($productId) {
                try {
                    $existingProduct = $this->productsFacade->getProductByUrl($input->value);
                    return $existingProduct->productId == $productId->value;
                } catch (\Exception $e) {
                    return true;
                }
            }, 'Zvolená URL je již obsazena jiným produktem');

        #region kategorie
        $categories = $this->categoriesFacade->findCategories();
        $categoriesArr = [];

        foreach ($categories as $category) {
            $categoriesArr[$category->categoryId] = $category->title;
        }

        $this->addMultiSelect('categories', 'Kategorie', $categoriesArr)
            //->setPrompt('--vyberte kategorie--')
            ->setRequired(false);

        #endregion kategorie

        $this->addTextArea('description', 'Popis produktu')
            ->setRequired('Zadejte popis produktu.');

        $this->addText('price', 'Cena')
            ->setHtmlType('number')
            ->addRule(Form::NUMERIC)
            ->setRequired('Musíte zadat cenu produktu');//tady by mohly být další kontroly pro min, max atp.

        $this->addCheckbox('available', 'Nabízeno ke koupi')
             ->setDefaultValue(true);

        if ($this->editingProduct) {
            $categoryDimensions = [];

            foreach ($this->editingProduct->categories as $category) {
                foreach ($category->dimensions as $dimension) {
                    $categoryDimensions[$dimension->dimensionId] = $dimension;
                }
            }

            foreach ($categoryDimensions as $dimension) {
                $this->addDimensionRow(
                    $this->editingProduct,
                    $dimension
                );
            }
        }

        #region obrázek
        $photoUpload = $this->addMultiUpload('photo', 'Fotka produktu');

        //pokud není zadané ID produktu, je nahrání fotky povinné
        $photoUpload //vyžadování nahrání souboru, pokud není známé productId
        ->addConditionOn($productId, Form::EQUAL, '')
            ->setRequired('Pro uložení nového produktu je nutné nahrát jeho fotku.');

        $photoUpload //limit pro velikost nahrávaného souboru
        ->addRule(Form::MAX_FILE_SIZE, 'Nahraný soubor je příliš velký', 1000000);

        $photoUpload //kontrola typu nahraného souboru, pokud je nahraný
        ->addCondition(Form::FILLED)
            ->addRule(function (Nette\Forms\Controls\UploadControl $photoUpload) {
                foreach ($photoUpload->value as $uploadedFile) {
                    if ($uploadedFile instanceof Nette\Http\FileUpload) {
                        $extension = strtolower($uploadedFile->getImageFileExtension());
                        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                            return false;
                        }
                    }
                }
                return true;
            }, 'Je nutné nahrát obrázek ve formátu JPEG či PNG.');
        #endregion obrázek

        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');
            if (!empty($values['productId'])) {
                try {
                    $product = $this->productsFacade->getProduct($values['productId']);
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaný produkt nebyl nalezen.');
                    return;
                }
            } else {
                $product = new Product();
            }

            $product->assign($values, ['title', 'url', 'description', 'available']);
            $categories = [];

            foreach ($values["categories"] as $category) {
                $categories[] = $this->categoriesFacade->getCategory($category);
            }

            $product->replaceAllCategories($categories);

            $product->price = floatval($values['price']);
            $dimensions = [];
            $existingDimensions = [];

            if ($values["productId"]) {
                $dims = $this->productDimensionsFacade->findProductDimensionsOfProduct($product);

                foreach ($dims as $dimension) {
                    $existingDimensions[$dimension->dimension->dimensionId] = $dimension;
                }
            }

            foreach ($values as $key => $value) {
                if (strpos($key, self::DIMENSION_PREFIX) === 0 && !empty($value)) {
                    $id = substr($key, strlen(self::DIMENSION_PREFIX));

                    if (array_key_exists($id, $existingDimensions)) {
                        $dim = $existingDimensions[$id];
                        unset($existingDimensions[$id]);
                    } else {
                        $dim = new ProductDimension();
                        $dim->dimension = $this->dimensionsFacade->getDimension($id);
                        $dim->product = $product;
                    }

                    $dim->value = $value;
                    $dimensions[] = $dim;
                }
            }

            foreach ($dimensions as $dimension) {
                $this->productDimensionsFacade->saveProductDimension($dimension);
            }

            foreach ($existingDimensions as $existingDimension) {
                $this->productDimensionsFacade->deleteProductDimension($existingDimension);
            }

            $this->setValues(['productId' => $product->productId]);

            $newPhotos = $values['photo'];

            foreach ($newPhotos as $photo) {
                if ($photo->isOk() && $photo instanceof Nette\Http\FileUpload && $photo->isImage()) {
                    $file = new File();
                    $filename = $this->productsFacade->saveProductPhoto($photo, $product);
                    $file->fileName = $filename;
                    $file->fileSize = $photo->size;
                    $image = $photo->toImage();
                    $file->width = $image->getWidth();
                    $file->height = $image->getHeight();
                    $this->filesFacade->saveFile($file);
                    $product->addToFiles($file);
                }
            }

            $this->productsFacade->saveProduct($product);

            //uložení fotky
            if (($values['photo'] instanceof Nette\Http\FileUpload) && ($values['photo']->isOk())) {
                try {
                    $this->productsFacade->saveProductPhoto($values['photo'], $product);
                } catch (\Exception $e) {
                    $this->onFailed('Produkt byl uložen, ale nepodařilo se uložit jeho fotku.');
                }
            }

            $this->onFinished('Produkt byl uložen.');
        };
        $this->addSubmit('storno', 'zrušit')
            ->setValidationScope([$productId])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }

    /**
     * Adds a dimension row to the form.
     *
     * @param Product $product
     * @param Dimension $dimension
     */
    private function addDimensionRow(Product $product, Dimension $dimension) : void
    {
        $this->addText(self::DIMENSION_PREFIX . $dimension->dimensionId, $dimension->name)
             ->setDefaultValue($this->productDimensionsFacade->getProductDimensionValue($product, $dimension))
             ->setRequired(false);
    }

    /**
     * Metoda pro nastavení výchozích hodnot formuláře
     * @param Product|array|object $values
     * @param bool $erase = false
     * @return $this
     */
    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Product) {
            $categories = [];

            $distinctDimensions = [];

            foreach ($values->categories as $category) {
                $categories[] = $category->categoryId;


                foreach ($category->dimensions as $dimension) {
                    //not the most efficient or readable
                    $distinctDimensions[$dimension->dimensionId] = $dimension;
                }
            }

            $values = [
                'productId' => $values->productId,
                'categories'=> $categories,
                'title' => $values->title,
                'url' => $values->url,
                'description' => $values->description,
                'price' => $values->price
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }

    const DIMENSION_PREFIX = 'dimension_';

}