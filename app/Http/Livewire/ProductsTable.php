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

        return view('livewire.products-table', [
            'products' => $products,
        ]);
    }

    public function createProduct()
    {
        $this->validate([
            'requisitionDescription' => 'required',
            'quotationDescription' => 'required',
            'purchasePrice' => 'required',
            'salePrice' => 'required',            
        ]);
        
        $newProduct = Product::create([
            'descripcion_pedido' => $this->requisitionDescription,
            'descripcion_cotizacion' => $this->quotationDescription,
            'proveedor' => $this->supplierId,
            'moneda' => $this->currencyId,
            'categoria' => $this->categoryId,
            'precio_compra' => $this->purchasePrice,
            'precio_venta' =>  $this->salePrice,
            'punto_pedido' => $this->reorderPoint,
            'stock_inicial' => $this->initialStock,
        ]);

        $this->requisitionDescription = '';
        $this->quotationDescription = '';
        $this->supplierId = '';
        $this->currencyId = '';
        $this->categoryId = '';
        $this->purchasePrice = '';
        $this->salePrice = '';
        $this->reorderPoint = '';
        $this->initialStock = '';
        
        session()->flash('message', 'Producto agregado correctamente.');

        $this->emit('productListUpdated');
    }

    public function editProduct(Product $product, $field, $value)
    {
        $product->{$field} = $value;
        $product->save();

        $this->emit('productListUpdated');
    }

    public function confirmDelete(Product $product)
    {
        $this->dispatchBrowserEvent('showDeleteModal', [
            'productId' => $product->id,
        ]);
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();

        $this->emit('productListUpdated');
    }
}