@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'EditSaleItems')

@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Sale Items</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('manageSaleItems.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <br>
    @if ($errors->any())
    <br>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('manageSaleItems.update',$saleitem->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden"  name="id" value="{{ $saleitem->id }}">
     <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" value="{{ $saleitem->itemName }}" placeholder="Name">
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
        <strong>Category:</strong>
        <select class="form-control select2" style="width: 100%;" name="category">
        @foreach($saleItemCategory as $categoryName)
            @if($categoryName->id==$saleitem->itemCategory)
                <option selected>{{ $categoryName->name }}</option>
            @else   
            <option>{{ $categoryName->name }}</option>
            @endif
       
        @endforeach
        <!-- <option disabled="disabled">California (disabled)</option> -->
        </select>
        </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Price(RM):</strong>
                <input type="text" name="price" class="form-control" value="{{ $saleitem->itemPrice	 }}" placeholder="Price">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Stock:</strong>
                <input type="text" name="stock" class="form-control" value="{{ $saleitem->itemStock }}" placeholder="Stock">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Size:</strong>
                <input list="list-sizes" name="size" class="form-control" value="{{ $saleitem->itemSize }}" placeholder="Size"/>
                <datalist id="list-sizes">
                    <option value="Small (S)">
                    <option value="Medium (M)">
                    <option value="Large (L)">
                    <option value="XLarge (XL)">
                    <option value="2XLarge (2XL)">
                    <option value="3XLarge (3XL)">
                </datalist>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Color:</strong>
                <input list="list-colors" name="color" class="form-control" value="{{ $saleitem->itemColor }}" placeholder="Color"/>
                <datalist id="list-colors">
                    <option value="White">
                    <option value="Yellow">
                    <option value="Yellow-Green">
                    <option value="Green">
                    <option value="Blue-Green">
                    <option value="Blue">
                    <option value="Blue-Violet">
                    <option value="Violet">
                    <option value="Red-Violet">
                    <option value="Red">
                    <option value="Red-Orange">
                    <option value="Orange">
                    <option value="Yellow-Orange">
                    <option value="Mixed">
                    <option value="Black">
                </datalist>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Brand:</strong>
                <input list="list-brand" name="brand" class="form-control" value="{{ $saleitem->itemBrand }}" placeholder="Brand"/>
                <datalist id="list-brand">
                    @foreach ($brandList as $brand)
                    <option value="{{ $brand->itemBrand }}">
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ $saleitem->itemDescription }}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Choose Images:</strong>
                <input type="file" name="images[]" multiple class="form-control" accept="image/*">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection