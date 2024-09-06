<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Daftar Produk</h1>
        <a href="{{ route('seller.dashboard') }}" class="btn btn-warning mb-3">Kembali</a>
        <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->product }}</td>
                    <td>{{ $product->harga }}</td>
                    <td><img src="{{ asset( $product->foto) }}" width="100"></td>
                    <td>
                        <a href="{{ route('product.edit', $product->id_product) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('product.destroy', $product->id_product) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
