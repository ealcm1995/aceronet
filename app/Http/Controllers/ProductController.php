<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Lógica para guardar
    }

    public function edit($id)
    {
        return view('products.edit');
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar
    }

    public function destroy($id)
    {
        // Lógica para eliminar
    }
}
