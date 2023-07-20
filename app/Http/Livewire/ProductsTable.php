<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Currency;

class ProductsTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchTerm;
    public $suppliers;
    public $categories;
    public $currencies;
    public $requisitionDescription;
    public $quotationDescription;
    public $supplierId;
    public $currencyId;
    public $categoryId;
    public $purchasePrice;
    public $salePrice;
    public $reorderPoint;
    public $initialStock;
    public $searchProveedor = '';
    public $searchCategoria = '';
    public $field;
    public $value;
    public $editedProduct_id;
    public $nRequisitionDescription;
    public $nQuotationDescription;
    public $nSupplierId;
    public $nCurrencyId;
    public $nCategoryId;
    public $nPurchasePrice;
    public $nSalePrice;
    public $nReorderPoint;
    public $nInitialStock;
    

    protected $queryString = [
        'searchProveedor' => ['except' => ''],
        'searchCategoria' => ['except' => ''],
    ];

    protected $listeners = [
        'productListUpdated' => '$refresh',

    ];
    public function mount()
    {
    $this->suppliers = Supplier::all();
    $this->categories = Category::all();
    $this->currencies = Currency::all();
    }

    public function render()
    {
        $products = Product::with(['proveedor', 'categoria', 'moneda'])
            ->search($this->searchTerm)
            ->paginate(15);
        
        $this->dispatchBrowserEvent('contentChanged');

        return view('livewire.products-table', [
            'products' => $products,
        ]);
    }

    public function createProduct()
    {
        $this->validate([
            'nRequisitionDescription' => 'required',
            'nQuotationDescription' => 'required',
            'nCurrencyId' => 'required',
            'nSalePrice' => 'required',            
        ]);
        
        $newProduct = Product::create([
            'descripcion_pedido' => $this->nRequisitionDescription,
            'descripcion_cotizacion' => $this->nQuotationDescription,
            'proveedor' => $this->nSupplierId,
            'moneda' => $this->nCurrencyId,
            'categoria' => $this->nCategoryId,
            'precio_compra' => floatval($this->nPurchasePrice), 
            'precio_venta' =>  floatval($this->nSalePrice),
            'punto_pedido' => $this->nReorderPoint,
            'stock_inicial' => $this->nInitialStock,
        ]);

        $this->nRequisitionDescription = '';
        $this->nQuotationDescription = '';
        $this->nSupplierId = null;
        $this->nCurrencyId = null;
        $this->nCategoryId = null;
        $this->nPurchasePrice = null;
        $this->nSalePrice = null;
        $this->nReorderPoint = null;
        $this->nInitialStock = null;
        
        session()->flash('message', 'Producto agregado correctamente.');

        $this->emit('productListUpdated');
    }

    public function editedProduct(Product $product)
    {
        $this->editedProduct_id = $product->id;
        $this->requisitionDescription = $product->descripcion_pedido;
        $this->quotationDescription = $product->descripcion_cotizacion;
        $this->supplierId = $product->proveedor;
        $this->currencyId = $product->moneda;
        $this->categoryId = $product->categoria;
        $this->purchasePrice = $product->precio_compra;
        $this->salePrice = $product->precio_venta;
        $this->reorderPoint = $product->punto_pedido;
        $this->initialStock = $product->stock_inicial;
        
    }

    public function updateProduct()
    {
        $this->validate([
            'requisitionDescription' => 'required',
            'quotationDescription' => 'required',
            'currencyId' => 'required',
            'salePrice' => 'required',            
        ]);

        $product = Product::find($this->editedProduct_id);
        $product->descripcion_pedido = $this->requisitionDescription;
        $product->descripcion_cotizacion = $this->quotationDescription;
        $product->proveedor = $this->supplierId;
        $product->moneda = $this->currencyId;
        $product->categoria = $this->categoryId;
        $product->precio_compra = $this->purchasePrice;
        $product->precio_venta = $this->salePrice;
        $product->punto_pedido = $this->reorderPoint;
        $product->stock_inicial = $this->initialStock;
        $product->save();

        $this->cancelEdit();

        session()->flash('message', 'Producto actualizado correctamente.');
    }

    public function cancelNew()
    {
        $this->nRequisitionDescription = '';
        $this->nQuotationDescription = '';
        $this->nSupplierId = '';
        $this->nCurrencyId = '';
        $this->nCategoryId = '';
        $this->nPurchasePrice = '';
        $this->nSalePrice = '';
        $this->nReorderPoint = '';
        $this->nInitialStock = '';

        $this->emit('productListUpdated');
    }

    public function cancelEdit()
    {
        $this->editedProduct_id = null;
    }

    public function deleteProduct($productId)
    {
        Product::find($productId)->delete();
        session()->flash('message', 'Producto eliminado correctamente.');
    }
    
}
