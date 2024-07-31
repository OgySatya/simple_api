<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemPostRequest;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = item::all()->loadMissing('categories:id,name');
        return response($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemPostRequest $request)
    {
        $data = $request->validated();
        if ($data["image_file"]) {
            $file = $data["image_file"];
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '_' . $fileName;

            Storage::disk('public')->putFileAs('item', $file, $newName);
        }
        $item = Item::create($data + ['image' => asset("storage/item/" . $newName)]);
        return response($item);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::find($id);
        return response($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'image_file' => 'nullable|mimes:jpg,jpeg',
        ]);
        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '_' . $fileName;

            Storage::disk('public')->putFileAs('item', $file, $newName);
            $request['image'] = asset("storage/item/" . $newName);
        }
        $item = item::findOrFail($id);
        $item->update($request->all());
        return response($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);

        if ($item) {
            $item->delete();
            return 'Item deleted successfully.';
        }

        return 'error Item not found.';
    }
}
